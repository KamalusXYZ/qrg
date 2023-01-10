<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $submittedDateTime = null;

    #[ORM\Column(nullable: true)]
    private ?bool $result = null;

    #[ORM\Column(nullable: true)]
    private ?int $chosenType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $writtenText = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    private ?Question $question = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubmittedDateTime(): ?\DateTimeInterface
    {
        return $this->submittedDateTime;
    }

    public function setSubmittedDateTime(?\DateTimeInterface $submittedDateTime): self
    {
        $this->submittedDateTime = $submittedDateTime;

        return $this;
    }

    public function isResult(): ?bool
    {
        return $this->result;
    }

    public function setResult(?bool $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getChosenType(): ?int
    {
        return $this->chosenType;
    }

    public function setChosenType(?int $chosenType): self
    {
        $this->chosenType = $chosenType;

        return $this;
    }

    public function getWrittenText(): ?string
    {
        return $this->writtenText;
    }

    public function setWrittenText(?string $writtenText): self
    {
        $this->writtenText = $writtenText;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
