<?php

namespace Tests\Unit\Utils\api;

use Utils\Api\ApiFactory;
use Tests\TestCase;
use Utils\Api\IceAndFireApi;

/**
 * Class ApiFactoryTest
 * @package Tests\Unit\Utils\api
 */
class ApiFactoryTest extends TestCase
{

    /**
     * Tests create function
     *
     * @dataProvider createDataProvider
     */
    public function testCreate($className)
    {
        if (empty($className)) {
            $this->expectException(\Exception::class);
            ApiFactory::create($className);
        } else {
            $path = explode('\\', $className);
            $this->assertInstanceOf($className, ApiFactory::create(array_pop($path)));
        }
    }


    /**
     * @return array
     */
    public function createDataProvider() : array
    {
        return [
            [
                ''
            ],
            [
                IceAndFireApi::class
            ]
        ];
    }
}