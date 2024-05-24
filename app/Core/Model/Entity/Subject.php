<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Subject
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\Column(type: "string", nullable: false)]
    private string $name;

    #[ORM\Column(type: "string", nullable: false)]
    private string $code;

    #[ORM\ManyToOne(targetEntity: Semester::class, inversedBy: "subjects")]
    private Semester $recommendedSemester;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: "favouriteSubjects")]
    private $users;

    #[ORM\OneToMany(targetEntity: Reflection::class, mappedBy: "subject")]
    private $reflections;

    #[ORM\OneToMany(targetEntity: SubjectQuestion::class, mappedBy: "subject")]
    private $subjectQuestions;
}
