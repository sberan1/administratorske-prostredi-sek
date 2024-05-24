<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UserCompetenceObtained
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "subjectsCompetencesObtained")]
    private User $user;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $userId;

    #[ORM\ManyToOne(targetEntity: Competence::class, inversedBy: "users")]
    private Competence $competence;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $competenceId;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"], nullable: false)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: Reflection::class, inversedBy: "userCompetenceObtained", cascade: ["remove"])]
    private ?Reflection $reflection = null;

    #[ORM\Column(type: "uuid", nullable: true)]
    private ?string $reflectionId = null;

    #[ORM\ManyToOne(targetEntity: SubjectAnswer::class, inversedBy: "competences")]
    private ?SubjectAnswer $subjectAnswer = null;

    #[ORM\Column(type: "uuid", nullable: true)]
    private ?string $subjectAnswerId = null;
}
