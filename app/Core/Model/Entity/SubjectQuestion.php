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

    #[ORM\Column(type: "text", nullable: false)]
    private string $content;

    #[ORM\Column(type: "scale" , nullable: false)]
    private string $scaleType;

    #[ORM\ManyToOne(targetEntity: Subject::class, inversedBy: "subjectQuestions")]
    private Subject $subject;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $subjectId;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "subjectQuestions")]
    private ?User $user = null;

    #[ORM\Column(type: "uuid", nullable: true)]
    private ?string $userId = null;

    #[ORM\OneToMany(targetEntity: SubjectAnswer::class, mappedBy: "question")]
    private $answers;
}
