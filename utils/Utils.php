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
     * @return Utils
     */
    public static function getInstance()
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
        return $this->convertErrorsToString($validator->getMessageBag()->toArray());
    }

    /**
     * Converts array of errors to comma separated string
     *
     * @param array $errors
     *
     * @return string
     */
    private function convertErrorsToString(array $errors) : string
    {
        $errorArray = [];
        foreach ($errors as $error) {
            $errorArray[] = implode(', ', $error);
        }

        return implode(', ', $errorArray);
    }
}