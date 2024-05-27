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

    #[ORM\OneToMany(mappedBy: "B", targetEntity: RecommendedSemester::class)]
    private $recommendedSemester;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: "favouriteSubjects")]
    private $users;

    #[ORM\OneToMany(targetEntity: Reflection::class, mappedBy: "subject")]
    private $reflections;

    #[ORM\OneToMany(targetEntity: SubjectQuestion::class, mappedBy: "subject")]
    private $subjectQuestions;


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

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getRecommendedSemester()
    {
        return $this->recommendedSemester;
    }

    /**
     * @param mixed $recommendedSemester
     */
    public function setRecommendedSemester($recommendedSemester): void
    {
        $this->recommendedSemester = $recommendedSemester;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function getReflections()
    {
        return $this->reflections;
    }

    /**
     * @param mixed $reflections
     */
    public function setReflections($reflections): void
    {
        $this->reflections = $reflections;
    }

    /**
     * @return mixed
     */
    public function getSubjectQuestions()
    {
        return $this->subjectQuestions;
    }

    /**
     * @param mixed $subjectQuestions
     */
    public function setSubjectQuestions($subjectQuestions): void
    {
        $this->subjectQuestions = $subjectQuestions;
    }
}
