<?php

namespace App;

/**
 * Class Books
 * @package App
 */
class Books extends ModelAbstract
{

    /**
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected static $rules = [
        "name" => "required|string|max:250",
        "isbn" => "required|string|max:250",
        "authors" => "required",
        "country" => "required|string|max:250",
        "number_of_pages" => "required|int",
        "publisher" => "required|string|max:250",
        "release_date" => "required|date",
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'isbn',
        'authors',
        'number_of_pages',
        'publisher',
        'country',
        'release_date'
    ];

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function save(array $options = []) : bool
    {
        $this->authors = is_array($this->authors) ? implode(',', $this->authors): $this->authors;
        $this->release_date = date('Y-m-d', strtotime($this->release_date));

        return parent::save($options);
    }

    /**
     * @return array
     */
    public function getAuthors() : array
    {
        return is_string($this->authors) ? explode(',', $this->authors) : $this->authors;
    }
}
