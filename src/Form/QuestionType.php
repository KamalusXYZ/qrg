<?php

namespace App\Form;

use App\Entity\Question;
use App\Enum\QuestionTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class,[
                'attr' => ['class' => 'form-control mb-3'],'label' => 'Type de question',

                'choices'  => [
                    QuestionTypeEnum::IMAGE_MODIFIED_QUESTION->toStringPhrasing() => QuestionTypeEnum::IMAGE_MODIFIED_QUESTION->value,
                    QuestionTypeEnum::TEXT_QUESTION->toStringPhrasing() => QuestionTypeEnum::TEXT_QUESTION->value

                ] ])
            ->add('attachmentPath', FileType::class, [
                'label' => 'Image ou autre média',
                'attr' => ['class' => 'form-control mb-3'],

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid jpeg document',
                    ])
                ],
            ])
            ->add('text',TextareaType::class, [
                'attr' => ['class' => 'form-control mb-3'],
                'label' => 'Contenu de la question',
                            ])
            ->add('trueAnswer',TextType::class, [
                'attr' => ['class' => 'form-control mb-3'],
                'label' => 'Bonne réponse',
            ])
            ->add('wrongAnswer1',TextType::class, [
                'attr' => ['class' => 'form-control mb-3'],
                'label' => '1ère mauvaise réponse',
            ])
            ->add('wrongAnswer2',TextType::class, [
                'attr' => ['class' => 'form-control mb-3'],
                'label' => '2ème mauvaise réponse',
            ])
            ->add('wrongAnswer3',TextType::class, [
                'attr' => ['class' => 'form-control mb-3'],
                'label' => '3ème mauvaise réponse',
            ])

//            ->add('attachmentPath')
//            ->add('valid')
//            ->add('isDeleted')
//            ->add('games')
//            ->add('tags')
//            ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
