<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createDateTime')
            ->add('text')
            ->add('trueAnswer')
            ->add('wrongAnswer1')
            ->add('wrongAnswer2')
            ->add('wrongAnswer3')
            ->add('type')
            ->add('attachmentPath')
            ->add('valid')
            ->add('isDeleted')
            ->add('games')
            ->add('tags')
            ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
