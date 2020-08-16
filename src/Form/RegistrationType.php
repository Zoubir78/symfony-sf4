<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champs nom est manquant.']),
                    new Length([
                        'max' => 15,
                        'maxMessage' => 'Le nom ne peut contenir plus de {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe ne peut contenir moins de {{ limit }} caractères.',
                        'max' => 15,
                        'maxMessage' => 'Le mot de passe ne peut contenir plus de {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('confirm_password', PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
