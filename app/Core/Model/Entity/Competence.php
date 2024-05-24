<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Competence
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\Column(type: "string", nullable: false)]
    private string $name;

    #[ORM\Column(type: "string", nullable: false)]
    private string $letter;

    #[ORM\Column(type: "string", nullable: false)]
    private string $description;

    #[ORM\ManyToOne(targetEntity: CompetenceGroup::class, inversedBy: "competences")]
    private ?CompetenceGroup $group = null;

    #[ORM\Column(type: "uuid", nullable: true)]
    private ?string $groupId = null;

    #[ORM\OneToMany(targetEntity: UserCompetenceObtained::class, mappedBy: "competence")]
    private $users;
}
