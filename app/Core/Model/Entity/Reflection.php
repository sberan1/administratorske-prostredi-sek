<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Reflection
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\Column(type: "string", nullable: false)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "reflections", cascade: ["remove"])]
    private User $user;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $userId;

    #[ORM\ManyToOne(targetEntity: Subject::class, inversedBy: "reflections", cascade: ["remove"])]
    private Subject $subject;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $subjectId;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"], nullable: false)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $updatedAt;

    #[ORM\OneToMany(targetEntity: UserCompetenceObtained::class, mappedBy: "reflection")]
    private $userCompetenceObtained;

    #[ORM\OneToMany(targetEntity: SubjectAnswer::class, mappedBy: "reflection")]
    private $subjectQuestionAnswers;
}
