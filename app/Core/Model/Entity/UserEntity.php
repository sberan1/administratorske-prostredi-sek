<?php declare(strict_types=1);

namespace App\Core\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UserEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;


    #[ORM\Column(type: 'string')]
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
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

}