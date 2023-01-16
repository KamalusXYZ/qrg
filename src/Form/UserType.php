<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Nom d utilisateur'],
                'label' => false,
            ])
            ->add('mail', EmailType::class, [
                'attr' => ['class' => 'form-control mt-2', 'placeholder' => '@mail'],
                'label' => false,
            ])
            ->add('lastName', TextType::class, [
                'attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Nom de famille'],
                'label' => false,
                'required'=>false,
            ])
            ->add('firstName', TextType::class, [
                'attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Prénom'],
                'label' => false,
                'required'=>false,
            ])
            ->add('city', TextType::class, [
                'attr' => ['class' => 'form-control mt-2', 'placeholder' => 'Ville'],
                'label' => false,
                'required'=>false,
            ])
            // TODO mettre en avant la france dans les choix
            ->add('country', CountryType::class, [
                'attr' => ['class' => 'form-control mt-2'],
                'label' => false,
                'required'=>false,

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
