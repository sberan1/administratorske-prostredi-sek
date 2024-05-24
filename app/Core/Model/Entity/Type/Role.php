<?php

namespace App\Core\Model\Entity\Type;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class Role extends Type
{
    const ADMIN = 'ADMIN';
    const STUDENT = 'STUDENT';
    const TEACHER = 'TEACHER';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "ENUM('ADMIN', 'STUDENT', 'TEACHER')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    public function getName()
    {
        return 'role';
    }
}
