<?php

namespace Utils;

use Illuminate\Contracts\Validation\Validator;

/**
 * Class Utils
 * @package Utils
 */
class Utils
{

    /**
     * @var
     */
    private static $instance;

    /**
     * Private constructor for singleton pattern
     *
     * Utils constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return self
     */
    public static function getInstance() : self
    {
        return static::$instance ?: static::$instance = new static();
    }

    /**
     * Returns all errors of validator as string separated by comma
     *
     * @param Validator $validator
     *
     * @return string
     */
    public function getErrorMessagesFromValidator(Validator $validator) : string
    {
        $errorArray = [];
        $errors = $validator->getMessageBag()->toArray();
        foreach ($errors as $error) {
            $errorArray[] = implode(', ', $error);
        }

        return implode(', ', $errorArray);
    }
}