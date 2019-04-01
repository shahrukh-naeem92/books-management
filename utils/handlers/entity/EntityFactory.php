<?php

namespace Utils\Handlers\Entity;

/**
 * Class EntityFactory
 * @package Utils\Handlers\Entity
 */
class EntityFactory
{
    /**
     * Creates objects for handler classes
     *
     * @param string $className
     * @param array $constructorArguments
     *
     * @throws \Exception
     *
     * @return object
     */
    public static function create(string $className, array $constructorArguments = []) : object
    {
        $class = "Utils\\Handlers\\Entity\\$className";
        if (class_exists($class)) {
            return new $class(...$constructorArguments);
        }

        throw new \Exception("Class $class not found");
    }
}