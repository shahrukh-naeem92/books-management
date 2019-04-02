<?php

namespace App\Http\Requests;

use App\Http\Requests\RequestAbstract;
use Utils\Handlers\Entity\BooksEntity;

/**
 * Class CreateBooks
 * @package App\Http\Requests
 */
class CreateBooks extends RequestAbstract
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
            "name" => "required|string|max:250",
            "isbn" => "required|string|max:250",
            "authors" => "required",
            "country" => "required|string|max:250",
            "number_of_pages" => "required|int",
            "publisher" => "required|string|max:250",
            "release_date" => "required|date",
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
