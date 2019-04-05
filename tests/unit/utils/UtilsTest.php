<?php

namespace Tests\Unit\Utils;

use Illuminate\Support\Facades\Validator;
use Utils\Utils;
use Tests\TestCase;

/**
 * Class UtilsTest
 * @package Tests\Unit\Utils
 */
class UtilsTest extends TestCase
{

    /**
     * Tests getErrorMessagesFromValidator function
     *
     * @return void
     */
    public function testGetErrorMessagesFromValidator() : void
    {
        $validator = Validator::make(
            [],
            [
                "name" => "required|string|max:250",
                "isbn" => "required|string|max:250",
            ]
        );

        $this->assertEquals(
            'The name field is required., The isbn field is required.',
            Utils::getInstance()->getErrorMessagesFromValidator($validator)
        );
    }
}