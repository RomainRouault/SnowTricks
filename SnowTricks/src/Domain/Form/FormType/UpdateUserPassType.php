<?php


namespace App\Domain\Form\FormType;

use App\Domain\Form\Model\ChangePassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class UpdateUserPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(
            'label' => 'Votre mot de passe actuel',
            ))
            ->add('newPassword', RepeatedType::class, array(
            'type' => PasswordType::class,
            'first_options'  => array('label' => 'Nouveau mot de passe'),
            'second_options' => array('label' => 'Répéter le mot de passe'),
            'invalid_message' => 'Les champs doivent correspondre',
            'label' => 'Nouveau mot de passe'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => "Soumettre"
            ))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ChangePassword::class
        ));
    }


}