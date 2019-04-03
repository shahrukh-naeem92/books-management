<?php

namespace Utils\Api;

/**
 * Class ApiFactory
 * @package Utils\Api
 */
class ApiFactory
{
    /**
     * Creates objects for api classes
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
        $class = "Utils\\Api\\$className";
        if (class_exists($class)) {
            return new $class(...$constructorArguments);
        }

        throw new \Exception("Class $class not found");
    }
}