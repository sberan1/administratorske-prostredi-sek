<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class SubjectQuestion
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\Column(type: "string", nullable: false)]
    private string $title;

    #[ORM\Column(type: "scale" , nullable: false)]
    private string $scaleType;

    #[ORM\ManyToOne(targetEntity: Subject::class, inversedBy: "subjectQuestions")]
    private Subject $subject;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "subjectQuestions")]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: SubjectAnswer::class, mappedBy: "question")]
    private $answers;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getScaleType(): string
    {
        return $this->scaleType;
    }

    public function setScaleType(string $scaleType): void
    {
        $this->scaleType = $scaleType;
    }

    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function setSubject(Subject $subject): void
    {
        $this->subject = $subject;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param mixed $answers
     */
    public function setAnswers($answers): void
    {
        $this->answers = $answers;
    }


}
