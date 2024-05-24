<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Course
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\Column(type: "string", nullable: false)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Faculty::class, inversedBy: "courses")]
    private Faculty $faculty;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $facultyId;

    #[ORM\OneToMany(targetEntity: Semester::class, mappedBy: "course")]
    private $semesters;
}
