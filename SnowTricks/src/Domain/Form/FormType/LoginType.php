<?php

namespace App\Domain\Form\FormType;

use App\Domain\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;


class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'required' => true,
                'label' => 'form.email',
                'constraints' => [
                    new Email(),
                    new Length([
                        'max' => 255
                    ])
                ]
            ])
            ->add('save', SubmitType::class, [
            'constraints' => [
                new Email(),
                new Length([
                    'max' => 255
                ])
                ]
    ])
    ;
    }
}