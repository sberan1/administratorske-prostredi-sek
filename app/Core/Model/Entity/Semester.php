<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Semester
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\Column(type: "string", nullable: false)]
    private string $name;

    #[ORM\OneToMany(targetEntity: UserSemester::class, mappedBy: "semester")]
    private $userSemesters;

    #[ORM\OneToMany(targetEntity: Subject::class, mappedBy: "recommendedSemester")]
    private $subjects;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: "semesters")]
    private Course $course;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $coursesId;

    #[ORM\OneToOne(targetEntity: Semester::class)]
    private ?Semester $nextSemester = null;

    #[ORM\Column(type: "uuid", nullable: true)]
    private ?string $nextSemesterId = null;

    #[ORM\ManyToOne(targetEntity: Semester::class)]
    private Semester $previousSemester;
}
