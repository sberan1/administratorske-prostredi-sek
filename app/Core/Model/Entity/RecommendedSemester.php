<?php

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "_RecommendedSemester")]
#[ORM\Index(columns: ["A", "B"], name: "_RecommendedSemester_AB_unique")]
class RecommendedSemester
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Semester::class)]
    #[ORM\JoinColumn(name: "A", referencedColumnName: "id")]
    private Semester $A;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Subject::class)]
    #[ORM\JoinColumn(name: "B", referencedColumnName: "id")]
    private Subject $B;
}
