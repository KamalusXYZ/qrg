<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createDateTime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(length: 255)]
    private ?string $trueAnswer = null;

    #[ORM\Column(length: 255)]
    private ?string $wrongAnswer1 = null;

    #[ORM\Column(length: 255)]
    private ?string $wrongAnswer2 = null;

    #[ORM\Column(length: 255)]
    private ?string $wrongAnswer3 = null;

    #[ORM\Column(nullable: true)]
    private ?int $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $attachmentPath = null;

    #[ORM\Column(nullable: true)]
    private ?bool $valid = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isDeleted = null;

    #[ORM\ManyToMany(targetEntity: Game::class, inversedBy: 'questions')]
    private Collection $games;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'questions')]
    private Collection $tags;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'questions')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Answer::class)]
    private Collection $answers;

    #[ORM\Column(nullable: true)]
    private ?int $pixelationRate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $denied = null;

    #[ORM\Column(nullable: true)]
    private ?bool $checked = null;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateDateTime(): ?\DateTimeInterface
    {
        return $this->createDateTime;
    }

    public function setCreateDateTime(?\DateTimeInterface $createDateTime): self
    {
        $this->createDateTime = $createDateTime;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getTrueAnswer(): ?string
    {
        return $this->trueAnswer;
    }

    public function setTrueAnswer(string $trueAnswer): self
    {
        $this->trueAnswer = $trueAnswer;

        return $this;
    }

    public function getWrongAnswer1(): ?string
    {
        return $this->wrongAnswer1;
    }

    public function setWrongAnswer1(string $wrongAnswer1): self
    {
        $this->wrongAnswer1 = $wrongAnswer1;

        return $this;
    }

    public function getWrongAnswer2(): ?string
    {
        return $this->wrongAnswer2;
    }

    public function setWrongAnswer2(string $wrongAnswer2): self
    {
        $this->wrongAnswer2 = $wrongAnswer2;

        return $this;
    }

    public function getWrongAnswer3(): ?string
    {
        return $this->wrongAnswer3;
    }

    public function setWrongAnswer3(string $wrongAnswer3): self
    {
        $this->wrongAnswer3 = $wrongAnswer3;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAttachmentPath(): ?string
    {
        return $this->attachmentPath;
    }

    public function setAttachmentPath(?string $attachmentPath): self
    {
        $this->attachmentPath = $attachmentPath;

        return $this;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(?bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        $this->games->removeElement($game);

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    public function getPixelationRate(): ?int
    {
        return $this->pixelationRate;
    }

    public function setPixelationRate(?int $pixelationRate): self
    {
        $this->pixelationRate = $pixelationRate;

        return $this;
    }

    public function isDenied(): ?bool
    {
        return $this->denied;
    }

    public function setDenied(?bool $denied): self
    {
        $this->denied = $denied;

        return $this;
    }

    public function isChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(?bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }
}
