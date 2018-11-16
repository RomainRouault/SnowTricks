<?php


namespace App\Domain\Form\FormHandler;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\Domain\Form\FormType\InscriptionType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InscriptionHandler
{
    private $userRepository;
    private $formFactory;
    private $passwordEncoder;
    private $flashBag;
    private $validator;
    private $mailer;
    private $twig;

    public function __construct(UserRepository $userRepository, FormFactoryInterface $formFactory, UserPasswordEncoderInterface $passwordEncoder, FlashBagInterface $flashBag, ValidatorInterface $validator, RouterInterface $router, \Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->userRepository = $userRepository;
        $this->formFactory = $formFactory;
        $this->passwordEncoder = $passwordEncoder;
        $this->flashBag = $flashBag;
        $this->validator = $validator;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }


    /**
     * @return \Symfony\Component\Form\FormView
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handleInscription()
    {
        //buildForm
        $user = new User();
        $form = $this->formFactory->create(InscriptionType::class, $user, array('validation_groups' => array('registration', 'Default')));

        // Handle the submit (will only happen on POST)
        $request = Request::createFromGlobals();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            //Encode the password
            $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            //create a token (for inscription confirmation)
            $user->initiateToken();

            //persist new user
            $this->userRepository->persistUser($user);

            //send confirmation message
            $message = (new \Swift_Message('Bienvenue sur SnowTricks '. ucfirst($user->getUsername()) .' !' ))
                ->setFrom('rouaults11@gmail.com')
                ->setTo($user->getUserMail())
                ->setBody(
                    $this->twig->render(
                        'email/inscription.html.twig',
                        array('userName' => $user->getUsername(), 'token' => $user->getToken())
                    ),
                    'text/html'
                );

            $this->mailer->send($message);

            //add a flash message
            $this->flashBag->add('validation', 'Votre inscription est bien enregistrée! Un e-mail automatique de confirmation vient d\'être envoyé à l\'adresse ' . $user->getUserMail() . '.');

        }

        //If no request submited // invalid form, return the view
        $formView = $form->createView();
        return $formView;

    }

    /*
     * Function to check and update the user status (email confirmed or not)
     */
    public function handleInscriptionConfirmation($token)
    {
        //check if the transmited token is available
        $user = $this->userRepository->findOneBySomeField('token', $token);

        if (isset($user))
        {
            //confirm user and erase token value
            $user->setUserConfirmed(true);
            $user->setToken(null);
            $this->userRepository->persistUser($user);
            return true;
        }
        //else token is not available; throw a flash message
        return false;

    }

}