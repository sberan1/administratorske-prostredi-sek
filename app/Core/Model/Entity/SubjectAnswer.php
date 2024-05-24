<?php


namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class SubjectAnswer
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid")]
    private string $id;

    #[ORM\Column(type: "text", nullable: false)]
    private string $content;

    #[ORM\Column(type: "integer", nullable: false)]
    private int $scaleValue;

    #[ORM\ManyToOne(targetEntity: SubjectQuestion::class, inversedBy: "answers")]
    private SubjectQuestion $question;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $questionId;

    #[ORM\ManyToOne(targetEntity: Reflection::class, inversedBy: "subjectQuestionAnswers", cascade: ["remove"])]
    private Reflection $reflection;

    #[ORM\Column(type: "uuid", nullable: false)]
    private string $reflectionId;

    #[ORM\OneToMany(targetEntity: UserCompetenceObtained::class, mappedBy: "subjectAnswer")]
    private $competences;

    #[ORM\OneToMany(targetEntity: UploadedFile::class, mappedBy: "answer")]
    private $files;
}
?>

