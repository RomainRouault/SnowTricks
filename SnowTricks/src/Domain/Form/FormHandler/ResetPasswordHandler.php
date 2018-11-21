<?php


namespace App\Domain\Form\FormHandler;


use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Form\FormType\ForgotPasswordType;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use App\Domain\Form\FormType\ResetPasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordHandler
{
    private $formFactory;
    private $userRepository;
    private $flashBag;
    private $mailer;
    private $twig;
    private $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, UserRepository $userRepository,  \Swift_Mailer $mailer, \Twig_Environment $twig, FlashBagInterface $flashBag, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->formFactory = $formFactory;
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->flashBag = $flashBag;
        $this->passwordEncoder = $passwordEncoder;
    }

    /*
     * Method to handle the forgot Password form
     * Check if the email is registred. Then send a mail with token. Mail redirect to the resetPassword functionality.
     */
    public function forgotPassword()
    {
        //create new user
        $user = new User;
        //buildForm
        $form = $this->formFactory->create(ForgotPasswordType::class, $user);

        // Handle the submit
        $request = Request::createFromGlobals();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Find the user on DB
            $user = $this->userRepository->findOneBySomeField('userMail', $form->get('userMail')->getData());

            if ($user)
            {
                //create a token (for reset confirmation)
                $user->initiateToken();

                //persist user
                $this->userRepository->persistUser($user);

                //send confirmation message
                try {
                    $message = (new \Swift_Message('Réinitialisation de votre mot de passe'))
                        ->setFrom('rouaults11@gmail.com')
                        ->setTo($user->getUserMail())
                        ->setBody(
                            $this->twig->render(
                                'email/resetPassword.html.twig',
                                array('userName' => $user->getUsername(), 'token' => $user->getToken())
                            ),
                            'text/html'
                        );
                } catch (\Exception $e) {
                    $e->getMessage();
                }

                $this->mailer->send($message);

                //add a flash message
                $this->flashBag->add('validation', 'Votre demande a bien été enregistrée! Un e-mail vient d\'être envoyé à l\'adresse ' . $user->getUserMail() . '.');
            }

            else
            {
                $this->flashBag->add('error', 'Adresse email inconnue.');
            }
        }


        //If no request submited // invalid form, return the view
        $formView = $form->createView();
        return $formView;

    }

    /*
     * Method to handle the reinit of the password
     */
    public function resetPassword($token)
    {
        //get the user from DB with token
        $user = $this->userRepository->findOneBySomeField('token', $token);

        if ($user)
        {

            //buildForm
            $form = $this->formFactory->create(ResetPasswordType::class, $user);

            // Handle the submit - only happen on POST
            $request = Request::createFromGlobals();
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                //Encode new password password
                $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                //erase token
                $user->setToken(NULL);

                //persist user
                $this->userRepository->persistUser($user);

                //add a flash message
                $this->flashBag->add('validation', 'Modification du mot de passe effectuée.');

                //Get out of the form render view loop - redirect
                return false;
            }

            //If no request submited // invalid form, return the view
            $formView = $form->createView();
            return $formView;

        }

        //If no token or wrong tong token given
        return false;

    }


}