<?php

namespace App\Http\Requests;

use Pearl\RequestValidate\RequestAbstract as ParentAbstract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Utils\Utils;

/**
 * Class RequestAbstract
 * @package App\Http\Requests
 */
class RequestAbstract extends ParentAbstract
{

    public $utils;
    /**
     * Format the errors from the given Validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function formatErrors(Validator $validator)
    {
        return new JsonResponse(
            [
                'status_code' => 400,
                'status' => 'failure',
                'data' => [],
                'message' => Utils::getInstance()->getErrorMessagesFromValidator($validator)
            ],
            400
        );
    }



}
