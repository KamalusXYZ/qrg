<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Nom d utilisateur'],
                'label' => false,
            ])
//            ->add('agreeTerms', CheckboxType::class, [
//                'mapped' => false,
//                'constraints' => [
//                    new IsTrue([
//                        'message' => 'You should agree to our terms.',
//                    ]),
//                ],
//            ])
            // TODO retirer le label pour mot de passe
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller

                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control mt-2', 'placeholder' => 'Mot de passe',],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('mail', EmailType::class, [
                'attr' => ['class' => 'form-control mt-2', 'placeholder' => '@mail'],
                'label' => false,
            ])
            ->add('lastName', TextType::class, [
                'attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Nom de famille'],
                'label' => false,
            ])
            ->add('firstName', TextType::class, [
                'attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Prénom'],
                'label' => false,
            ])
            // TODO mettre en avant la france dans les choix
            ->add('country', CountryType::class, [
                'attr' => ['class' => 'form-control mt-2'],
                'label' => false,

            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text

            'attr' => ['class' => 'form-control'],
                'label'=>'Date de naissance'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
