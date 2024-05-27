<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

#[ORM\Entity]
class Semester
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private $id;

    #[ORM\Column(type: "string", nullable: false)]
    private string $name;

    #[ORM\OneToMany(targetEntity: UserSemester::class, mappedBy: "semester")]
    private $userSemesters;

    #[ORM\OneToMany(targetEntity: RecommendedSemester::class, mappedBy: "A")]
    private $subjects;

    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: "semesters")]
    private Course $courses;

    #[ORM\OneToOne(targetEntity: Semester::class)]
    private ?Semester $nextSemester = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUserSemesters()
    {
        return $this->userSemesters;
    }

    /**
     * @param mixed $userSemesters
     */
    public function setUserSemesters($userSemesters): void
    {
        $this->userSemesters = $userSemesters;
    }

    /**
     * @return mixed
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * @param mixed $subjects
     */
    public function setSubjects($subjects): void
    {
        $this->subjects = $subjects;
    }

    public function getCourses(): Course
    {
        return $this->courses;
    }

    public function setCourses(Course $courses): void
    {
        $this->courses = $courses;
    }

    public function getNextSemester(): ?Semester
    {
        return $this->nextSemester;
    }

    public function setNextSemester(?Semester $nextSemester): void
    {
        $this->nextSemester = $nextSemester;
    }

}
