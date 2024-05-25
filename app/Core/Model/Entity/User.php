<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nette\SmartObject;

#[ORM\Entity]
#[ORM\Table(name: "\"User\"", uniqueConstraints: [
    new ORM\UniqueConstraint(name: "unique_email", columns: ["email"]),
    new ORM\UniqueConstraint(name: "unique_activeUserSemesterId", columns: ["activeUserSemesterId"])
])]
class User
{
    use SmartObject;

    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\Column(type: "string", nullable: false)]
    private string $email;

    #[ORM\Column(type: "string", nullable: false)]
    private string $firstName;

    #[ORM\Column(type: "string", nullable: false)]
    private string $lastName;

    #[ORM\Column(type: "text", nullable: false)]
    private string $password;

    #[ORM\Column(type: "role", options: ["default" => "STUDENT"], nullable: false)]
    private string $role;

    #[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"], nullable: false)]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $updatedAt;

    #[ORM\ManyToOne(targetEntity: Faculty::class, inversedBy: "users")]
    private ?Faculty $faculty = null;

    #[ORM\OneToOne(targetEntity: UserSemester::class)]
    private ?UserSemester $activeUserSemester = null;

    #[ORM\Column(type: "uuid", nullable: true)]
    private ?string $activeUserSemesterId = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $hashedRefreshToken = null;

    #[ORM\ManyToMany(targetEntity: Subject::class, inversedBy: "users")]
    #[ORM\JoinTable(name: "\"_UserFavouriteSubjects\"",
        joinColumns: [new ORM\JoinColumn(name: "\"B\"", referencedColumnName: "\"id\"")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "\"A\"", referencedColumnName: "\"id\"")]
    )]
    private $favouriteSubjects;

    #[ORM\Column(type: "boolean", options: ["default" => true], nullable: false)]
    private bool $blocked;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $unblockPin = null;

    #[ORM\OneToMany(targetEntity: Reflection::class, mappedBy: "user")]
    private $reflections;

    #[ORM\OneToMany(targetEntity: UserCompetenceObtained::class, mappedBy: "user")]
    private $subjectsCompetencesObtained;

    #[ORM\OneToMany(targetEntity: DiaryEntry::class, mappedBy: "user")]
    private $diaryEntries;

    #[ORM\OneToMany(targetEntity: SubjectQuestion::class, mappedBy: "user")]
    private $subjectQuestions;

    #[ORM\OneToMany(targetEntity: UploadedFile::class, mappedBy: "user")]
    private $files;

    #[ORM\OneToMany(targetEntity: UserSemester::class, mappedBy: "user")]
    private $userSemesters;

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getFaculty(): ?Faculty
    {
        return $this->faculty;
    }

    public function getFacultyId(): ?string
    {
        return $this->facultyId;
    }

    public function getActiveUserSemester(): ?UserSemester
    {
        return $this->activeUserSemester;
    }

    public function getActiveUserSemesterId(): ?string
    {
        return $this->activeUserSemesterId;
    }

    public function getHashedRefreshToken(): ?string
    {
        return $this->hashedRefreshToken;
    }

    /**
     * @return mixed
     */
    public function getFavouriteSubjects()
    {
        return $this->favouriteSubjects;
    }

    public function isBlocked(): bool
    {
        return $this->blocked;
    }

    public function getUnblockPin(): ?string
    {
        return $this->unblockPin;
    }

    /**
     * @return mixed
     */
    public function getReflections()
    {
        return $this->reflections;
    }

    /**
     * @return mixed
     */
    public function getSubjectsCompetencesObtained()
    {
        return $this->subjectsCompetencesObtained;
    }

    /**
     * @return mixed
     */
    public function getDiaryEntries()
    {
        return $this->diaryEntries;
    }

    /**
     * @return mixed
     */
    public function getSubjectQuestions()
    {
        return $this->subjectQuestions;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return mixed
     */
    public function getUserSemesters()
    {
        return $this->userSemesters;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setFaculty(?Faculty $faculty): void
    {
        $this->faculty = $faculty;
    }

    public function setActiveUserSemester(?UserSemester $activeUserSemester): void
    {
        $this->activeUserSemester = $activeUserSemester;
    }

    public function setActiveUserSemesterId(?string $activeUserSemesterId): void
    {
        $this->activeUserSemesterId = $activeUserSemesterId;
    }

    public function setHashedRefreshToken(?string $hashedRefreshToken): void
    {
        $this->hashedRefreshToken = $hashedRefreshToken;
    }

    /**
     * @param mixed $favouriteSubjects
     */
    public function setFavouriteSubjects($favouriteSubjects): void
    {
        $this->favouriteSubjects = $favouriteSubjects;
    }

    public function setBlocked(bool $blocked): void
    {
        $this->blocked = $blocked;
    }

    public function setUnblockPin(?string $unblockPin): void
    {
        $this->unblockPin = $unblockPin;
    }

    /**
     * @param mixed $reflections
     */
    public function setReflections($reflections): void
    {
        $this->reflections = $reflections;
    }

    /**
     * @param mixed $subjectsCompetencesObtained
     */
    public function setSubjectsCompetencesObtained($subjectsCompetencesObtained): void
    {
        $this->subjectsCompetencesObtained = $subjectsCompetencesObtained;
    }

    /**
     * @param mixed $diaryEntries
     */
    public function setDiaryEntries($diaryEntries): void
    {
        $this->diaryEntries = $diaryEntries;
    }

    /**
     * @param mixed $subjectQuestions
     */
    public function setSubjectQuestions($subjectQuestions): void
    {
        $this->subjectQuestions = $subjectQuestions;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files): void
    {
        $this->files = $files;
    }

    /**
     * @param mixed $userSemesters
     */
    public function setUserSemesters($userSemesters): void
    {
        $this->userSemesters = $userSemesters;
    }
}
