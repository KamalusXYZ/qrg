<?php

namespace App\Enum;

enum  QuestionTypeEnum: int
{
    case IMAGE_MODIFIED_QUESTION = 1;
    case TEXT_QUESTION = 2;
    case test = 3;


    public function toString(): string
    {
        return match ($this) {
            QuestionTypeEnum::IMAGE_MODIFIED_QUESTION => "IMAGE_MODIFIEE",
            QuestionTypeEnum::TEXT_QUESTION => "TEXT_QUESTION",



        };
    }
    public function toStringPhrasing(): string
    {
        return match ($this) {
            QuestionTypeEnum::IMAGE_MODIFIED_QUESTION => "Images modifées",
            QuestionTypeEnum::TEXT_QUESTION => "Question texte",
        };
    }
//    TODO améliorer avec une méthode qui fourni au builder un tableau de tout les cas
//    public function generateChoiceTab(): array
//    {
//       return QuestionTypeEnum::cases();
//    }

}

