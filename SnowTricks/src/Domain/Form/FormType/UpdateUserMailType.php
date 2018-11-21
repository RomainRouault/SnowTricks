<?php


namespace App\Domain\Form\FormType;

use App\Domain\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
Use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UpdateUserMailType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('userMail', EmailType::class, array(
                'label' => 'Email',
            ))
            ->add('Register', SubmitType::class, array(
                'label' => 'Modifier'
            ))
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'validation_groups' => array('Default')
        ));
    }


}