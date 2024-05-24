<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UploadedFile
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\Column(type: "string", nullable: false)]
    private string $name;

    #[ORM\Column(type: "string", nullable: false)]
    private string $url;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"], nullable: false)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: SubjectAnswer::class, inversedBy: "files")]
    private ?SubjectAnswer $answer = null;

    #[ORM\Column(type: "uuid", nullable: true)]
    private ?string $answerId = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "files")]
    private User $user;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $userId;
}
