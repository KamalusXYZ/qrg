<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('roles')
            ->add('password')
            ->add('createDateTime')
            ->add('mail')
            ->add('victoryNb')
            ->add('totalScore')
            ->add('dailyScore')
            ->add('birthDate')
            ->add('firstName')
            ->add('lastName')
            ->add('city')
            ->add('country')
            ->add('avatarFullPath')
            ->add('isDeleted')
            ->add('questions')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
