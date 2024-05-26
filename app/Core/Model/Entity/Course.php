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

    public function getFaculty(): Faculty
    {
        return $this->faculty;
    }

    public function setFaculty(Faculty $faculty): void
    {
        $this->faculty = $faculty;
    }

    public function getFacultyId(): string
    {
        return $this->facultyId;
    }

    public function setFacultyId(string $facultyId): void
    {
        $this->facultyId = $facultyId;
    }

    /**
     * @return mixed
     */
    public function getSemesters()
    {
        return $this->semesters;
    }

    /**
     * @param mixed $semesters
     */
    public function setSemesters($semesters): void
    {
        $this->semesters = $semesters;
    }


}
