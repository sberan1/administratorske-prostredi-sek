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
    #[ORM\Column(name: '"A"')]
    private $A;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Subject::class)]
    #[ORM\Column(name: '"B"')]
    private $B;

    public function getA(): Semester
    {
        return $this->A;
    }

    public function setA(string $A): void
    {
        $this->A = $A;
    }

    public function getB(): Subject
    {
        return $this->B;
    }

    public function setB(string $B): void
    {
        $this->B = $B;
    }


}
