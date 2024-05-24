<?php

namespace App\Core\Model;

use Doctrine\ORM\Mapping\NamingStrategy;

class CamelNamingStrategy implements NamingStrategy
{
    public function classToTableName($className)
    {
        $parts = explode('\\', $className);
        $lastName = end($parts);
        return $this->quote($lastName);
    }

    public function propertyToColumnName($propertyName, $className = null)
    {
        return $this->quote($propertyName);
    }

    public function embeddedFieldToColumnName($propertyName, $embeddedColumnName, $className = null, $embeddedClassName = null)
    {
        return $this->quote($propertyName . ucfirst($embeddedColumnName));
    }

    public function referenceColumnName()
    {
        return '"id"';
    }

    public function joinColumnName($propertyName, $className = null)
    {
        return $this->quote($propertyName . 'Id');
    }

    public function joinTableName($sourceEntity, $targetEntity, $propertyName = null)
    {
        return $this->quote($sourceEntity . ucfirst($targetEntity));
    }

    public function joinKeyColumnName($entityName, $referencedColumnName = null)
    {
        return $this->quote($entityName . (ucfirst($referencedColumnName) ?: 'Id'));
    }


    private function quote(string $string)
    {
        if (!str_contains($string, '"')) {
            return "\"$string\"";
        }
        return $string;
    }
}