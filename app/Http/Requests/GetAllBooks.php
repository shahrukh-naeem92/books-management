<?php

namespace App\Http\Requests;

/**
 * Class GetAllBooks
 * @package App\Http\Requests
 */
class GetAllBooks extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string',
            'country' => 'string',
            'publisher' => 'string',
            'release_date' => 'int',
        ];
    }
}
