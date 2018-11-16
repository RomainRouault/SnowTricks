<?php


namespace App\Domain\Form\FormHandler;

use App\Domain\Entity\User;
use App\Domain\Form\FormType\UpdateUserMailType;
use App\Domain\Form\FormType\UpdateUserPhotoType;
use App\Domain\Image\ImageBuilder;
use App\Domain\Image\ThumbnailGenerator;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Filesystem\Filesystem;


class UpdateUserHandler
{
    private $userRepository;
    private $formFactory;
    private $passwordEncoder;
    private $fileSystem;
    private $flashBag;
    private $validator;
    private $mailer;
    private $twig;
    private $imageBuilder;
    private $thumbnailGenerator;
    private $userPhotoThumbnailMaxWidth;
    private $userPhotoThumbnailMaxHeight;
    private $targetDirectoryUserPhoto;

    public function __construct(
        UserRepository $userRepository,
        Security $security,
        FormFactoryInterface $formFactory,
        UserPasswordEncoderInterface $passwordEncoder,
        Filesystem $filesystem,
        FlashBagInterface $flashBag,
        ValidatorInterface $validator,
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
        $this->validator = $validator;
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->imageBuilder = $imageBuilder;
        $this->thumbnailGenerator = $thumbnailGenerator;
        $this->userPhotoThumbnailMaxWidth = $userPhotoThumbnailMaxWidth;
        $this->userPhotoThumbnailMaxHeight = $userPhotoThumbnailMaxHeight;
        $this->targetDirectoryUserPhoto = $targetDirectoryUserPhoto;
    }

    /*
     * Build the forms for updating the user data
     */
    public function buildUpdateForms() : array
    {
        //build user object
        $user = new User();

        // build request object
        $request = Request::createFromGlobals();

        //buildForm for updating user photo
        $userPhotoForm = $this->formFactory->create(UpdateUserPhotoType::class, $user);

        //handling of the form
        $userPhotoForm->handleRequest($request);

        if ($userPhotoForm->isSubmitted() && $userPhotoForm->isValid()) {

            $this->handleUpdateUserPhoto($user);
        }

        //buildForm for updating user mail
        $userMailForm = $this->formFactory->create(UpdateUserMailType::class, $user);
        //handling of the form
        if ($userMailForm->isSubmitted() && $userMailForm->isValid()) {
            $this->handleUpdateUserMail();
        }

        //Create view and return an array of form view
        $userPhotoFormView = $userPhotoForm->createView();
        $userMailFormView = $userMailForm->createView();

        return array($userPhotoFormView, $userMailFormView);

    }

    public function handleUpdateUserPhoto(User $user)
    {
        // get the photo uploaded
        $photo = $user->getUserPhoto();

        //get photo information
        $photoName = $this->imageBuilder->buildImageName();
        $photoExtension = $this->imageBuilder->guessExtension($photo);

        // build a thumbnail
        $this->thumbnailGenerator->build($photo, $this->targetDirectoryUserPhoto, $photoName, $photoExtension, $this->userPhotoThumbnailMaxWidth, $this->userPhotoThumbnailMaxHeight);


        // warm the entity by getting the current user
        $userName = $this->security->getUser()->getUsername();
        $user = $this->userRepository->findOneBySomeField('userName', $userName);

        //destroy previous photo file
        $oldPhotoName = $user->getUserPhoto();
        $oldPhotoPath = $this->targetDirectoryUserPhoto . '/' . $oldPhotoName;
        $this->fileSystem->remove($oldPhotoPath);

        // get the complete name of the photo
        $finalName = $photoName. '.' .$photoExtension;
        //set change and persist in DB
        $user->setUserPhoto($finalName);
        $this->userRepository->persistUser($user);

        $this->flashBag->add('validation', 'Photo ajoutée');
    }

    public function handleUpdateUserMail()
    {

    }

}