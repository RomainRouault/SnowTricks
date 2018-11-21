<?php


namespace App\Domain\Form\FormHandler;

use App\Domain\Form\FormType\UpdateUserMailType;
use App\Domain\Form\FormType\UpdateUserPhotoType;
use App\Domain\Form\FormType\UpdateUserPassType;
use App\Domain\Form\Model\ChangePassword;
use App\Domain\Image\ImageBuilder;
use App\Domain\Image\ThumbnailGenerator;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Filesystem\Filesystem;


class UpdateUserHandler
{
    private $userRepository;
    private $formFactory;
    private $passwordEncoder;
    private $fileSystem;
    private $flashBag;
    private $mailer;
    private $twig;
    private $imageBuilder;
    private $thumbnailGenerator;
    private $userPhotoThumbnailMaxWidth;
    private $userPhotoThumbnailMaxHeight;
    private $targetDirectoryUserPhoto;
    private $currentUser;

    public function __construct(
        UserRepository $userRepository,
        Security $security,
        FormFactoryInterface $formFactory,
        UserPasswordEncoderInterface $passwordEncoder,
        Filesystem $filesystem,
        FlashBagInterface $flashBag,
        RouterInterface $router,
        \Swift_Mailer $mailer,
        \Twig_Environment $twig,
        ImageBuilder $imageBuilder,
        ThumbnailGenerator $thumbnailGenerator,
        $userPhotoThumbnailMaxWidth,
        $userPhotoThumbnailMaxHeight,
        $targetDirectoryUserPhoto
    ){
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->formFactory = $formFactory;
        $this->passwordEncoder = $passwordEncoder;
        $this->fileSystem = $filesystem;
        $this->flashBag = $flashBag;
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->imageBuilder = $imageBuilder;
        $this->thumbnailGenerator = $thumbnailGenerator;
        $this->userPhotoThumbnailMaxWidth = $userPhotoThumbnailMaxWidth;
        $this->userPhotoThumbnailMaxHeight = $userPhotoThumbnailMaxHeight;
        $this->targetDirectoryUserPhoto = $targetDirectoryUserPhoto;
        $this->currentUser = $this->getCurrentUser();
    }
    /*
     * Build the forms for updating the user data
     */
    public function buildUpdateForms() : array
    {
        // build request object
        $request = Request::createFromGlobals();

        //buildForm for updating user photo
        $userPhotoForm = $this->formFactory->create(UpdateUserPhotoType::class, $this->currentUser);

        //get old photo before submit
        $oldPhoto = $this->currentUser->getUserPhoto();
        //handling of the form
        $userPhotoForm->handleRequest($request);
        if ($userPhotoForm->isSubmitted() && $userPhotoForm->isValid()) {

            $this->handleUpdateUserPhoto($oldPhoto);
        }

        //buildForm for updating user mail
        $userMailForm = $this->formFactory->create(UpdateUserMailType::class, $this->currentUser);
        //handling of the form
        $userMailForm->handleRequest($request);
        if ($userMailForm->isSubmitted() && $userMailForm->isValid()) {
            $this->handleUpdateUserMail();
        }

        //buildForm for updating user pass
        $userPassForm = $this->formFactory->create(updateUserPassType::class, new ChangePassword());
        //handling of the form
        $userPassForm->handleRequest($request);
        if ($userPassForm->isSubmitted() && $userPassForm->isValid()){
            //get new pass data
            $this->handlePassUpdate($userPassForm);
        }

        //Create views...
        $userPhotoFormView = $userPhotoForm->createView();
        $userMailFormView = $userMailForm->createView();
        $userPassFormView = $userPassForm->createView();

        //...return all the forms view in array
        return array('userPhoto' => $userPhotoFormView, 'userMail' => $userMailFormView, 'userPass' => $userPassFormView);

    }

    public function buildUserRelatedData()
    {
        // Get the comments post by the user
        $userCommentCollection = $this->currentUser->getComments();
        $userComments = $userCommentCollection->getValues();
        // Get the tricks post by the user
        $userTricksCollection = $this->currentUser->getTricks();
        $userTricks = $userTricksCollection->getValues();

        //return the related data in array
        return array($userComments, $userTricks);
    }

    public function handleUpdateUserPhoto($oldPhoto)
    {
        // get the photo uploaded
        $photo = $this->currentUser->getUserPhoto();

        //get photo information
        $photoName = $this->imageBuilder->buildImageName();
        $photoExtension = $this->imageBuilder->guessExtension($photo);

        // build a thumbnail
        $this->thumbnailGenerator->build($photo, $this->targetDirectoryUserPhoto, $photoName, $photoExtension, $this->userPhotoThumbnailMaxWidth, $this->userPhotoThumbnailMaxHeight);

        //remove previous photo file
        $oldPhotoPath = $this->targetDirectoryUserPhoto . '/' . $oldPhoto;
        $this->fileSystem->remove($oldPhotoPath);

        // get the complete name of the photo
        $finalName = $photoName. '.' .$photoExtension;
        //set change and persist in DB
        $this->currentUser->setUserPhoto($finalName);
        $this->userRepository->persistUser($this->currentUser);

        $this->flashBag->add('validation', 'Photo ajoutée');
    }

    public function handleUpdateUserMail()
    {
        //create a token (for mail update)
        $this->currentUser->initiateToken();
        //leave the user's confirmation suspended - pending email confirmation
        $this->currentUser->setUserConfirmed(false);

        //persist new mail user and status
        $this->userRepository->persistUser($this->currentUser);

        //send confirmation message
        $message = (new \Swift_Message('Confirmation de votre nouvel email' ))
            ->setFrom('rouaults11@gmail.com')
            ->setTo($this->currentUser->getUserMail())
            ->setBody(
                $this->twig->render(
                    'email/updateMail.html.twig',
                    array('token' => $this->currentUser->getToken())
                ),
                'text/html'
            );

        $this->mailer->send($message);

        //add a flash message
        $this->flashBag->add('validation', 'Un e-mail vient d\'être envoyé à l\'adresse ' . $this->currentUser->getUserMail() . ' pour confirmation.');


    }

    public function handleMailUpdateConfirmation($token)
    {
        //check if the transmited token is available
        $user = $this->userRepository->findOneBySomeField('token', $token);

        if (isset($user))
        {
            //confirm user and erase token value
            $user->setUserConfirmed(true);
            $user->setToken(null);
            $this->userRepository->persistUser($user);
            $message = 'Modification de l\'adresse email effectuée.';
            return array('success' => true, 'message' => $message);

        }
        //else token is not available; throw a flash message
        $message = 'Utilisateur inconnu.';
        return array('success' => false, 'message' => $message);

    }

    public function handlePassUpdate($userPassForm)
    {

        //get new password
        $newPassword = $userPassForm->getData()->getNewPassword();

        //Encode the password
        $encodedNewPassword = $this->passwordEncoder->encodePassword($this->currentUser, $newPassword);
        $this->currentUser->setPassword($encodedNewPassword);

        //persist new user
        $this->userRepository->persistUser($this->currentUser);

        $this->flashBag->add('validation', 'Mot de passe modifié');
    }

    /*
     * Populate the entity with data from the current user
     */
    public function getCurrentUser()
    {
        $userName = $this->security->getUser()->getUsername();
        return $user = $this->userRepository->findOneBySomeField('userName', $userName);
    }

}