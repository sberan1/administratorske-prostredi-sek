<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CompetenceGroup
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\Column(type: "string", nullable: false)]
    private string $name;

    #[ORM\Column(type: "integer", nullable: false)]
    private int $number;

    #[ORM\Column(type: "string", nullable: false)]
    private string $color;

    #[ORM\OneToMany(targetEntity: Competence::class, mappedBy: "group")]
    private $competences;
}
