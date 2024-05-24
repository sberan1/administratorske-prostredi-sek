<?php

namespace App\Core\Model\Entity\Type;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class Scale extends Type
{
    const PERCENTAGE = 'PERCENTAGE';
    const FOUR_POINT = 'FOUR_POINT';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "ENUM('PERCENTAGE', 'FOUR_POINT')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    public function getName()
    {
        return 'scale';
    }
}
