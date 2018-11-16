<?php

namespace App\Domain\Form\FormType;

use App\Domain\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class LoginType extends AbstractType
{
    private $lastUsername;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->lastUserName = $options['lastUserName'];

        $builder
            ->add('userMail', EmailType::class, array(
                'label' => 'Email',
                'data' => $this->lastUsername
            ))
            ->add('password', PasswordType::class, array(
                'label' => 'Mot de passe'
            ))
            ->add('login', SubmitType::class, array(
                'label' => 'Se connecter'
            ))
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'lastUserName' => null,
            //csrd directly inject in template for controlling the name attribute
            'csrf_protection' => false,
            'validation_groups' => array('Default', 'login')

        ));
    }

}