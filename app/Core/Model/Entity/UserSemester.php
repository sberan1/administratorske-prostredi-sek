<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UserSemester
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "userSemesters")]
    private User $user;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $userId;

    #[ORM\ManyToOne(targetEntity: Semester::class, inversedBy: "userSemesters")]
    private Semester $semester;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $semesterId;

    #[ORM\Column(type: "boolean", options: ["default" => false], nullable: false)]
    private bool $archived;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"], nullable: false)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $updatedAt;
}
