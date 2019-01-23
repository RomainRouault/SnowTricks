<?php


namespace App\Domain\Form\FormHandler;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\Domain\Form\FormType\InscriptionType;
use App\Domain\Tools\Mailer;
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

    public function __construct(UserRepository $userRepository, FormFactoryInterface $formFactory, UserPasswordEncoderInterface $passwordEncoder, FlashBagInterface $flashBag, ValidatorInterface $validator, RouterInterface $router, Mailer $mailer, \Twig_Environment $twig)
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
        $form = $this->formFactory->create(InscriptionType::class, $user);

        // Handle the submit (will only happen on POST)
        $request = Request::createFromGlobals();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->initiateToken();

            $this->userRepository->persistUser($user);

            //send confirmation message
            $emailSubject = 'Bienvenue sur SnowTricks '. ucfirst($user->getUsername()) .' !';
            $emailBody = $this->twig->render(
                'email/inscription.html.twig', array('userName' => $user->getUsername(), 'token' => $user->getToken())
            );

            if ($this->mailer->sendMail($user->getUserMail(), $emailSubject, $emailBody)) {
                //add a flash message
                $this->flashBag->add(
                    'validation',
                    'Votre inscription est bien enregistrée! Un e-mail automatique de confirmation vient d\'être envoyé à l\'adresse ' . $user->getUserMail() . '.'
                );
            }

            else{
                $this->flashBag->add(
                    'error',
                    'Inscription en attente: Échec de l\'envoi du message à l\'adresse ' . $user->getUserMail() . '. Merci de contacter ' . $this->mailer::SENDER_EMAIL_ADRESS . ''
                );

            }


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
            $message = 'Inscription terminée, vous pouvez maintenant profitez de toutes les fonctionnalités du site en vous rendant sur "connexion".';
            return array('success' => true, 'message' => $message);
        }
        //else token is not available; throw a flash message
        $message = 'Adresse email déjà validée';
        return array ('success' => false, 'message' => $message);

    }

}