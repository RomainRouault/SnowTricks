<?php


namespace App\Domain\Form\FormType;

namespace App\Domain\Form\FormType;

use App\Domain\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UpdateUserPhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userPhoto', FileType::class, array(
                'label' => false,
                'data_class' => null
            ))
            ->add('Save', SubmitType::class, array(
                'label' => 'Sauvegarder'
            ))
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'validation_groups' => array('Default', 'update')
        ));
    }


}