<?php

namespace Utils\Rest\Clients;

/**
 * Class ClientFactory
 * @package Utils\Rest\Clients
 */
class ClientFactory
{
    /**
     * Creates objects for client classes
     *
     * @param string $className
     * @param array $constructorArguments
     *
     * @throws \Exception
     *
     * @return ClientInterface
     */
    public static function create(string $className, array $constructorArguments = []) : ClientInterface
    {
        $class = "Utils\\Rest\\Clients\\$className";
        if (class_exists($class)) {
            return new $class(...$constructorArguments);
        }

        throw new \Exception("Class $class not found");
    }
}