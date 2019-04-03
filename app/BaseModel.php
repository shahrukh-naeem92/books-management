<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Validator as ParentValidator;
use Utils\Utils;

/**
 * Class BaseModel
 * @package App
 */
class BaseModel extends Model
{
    /**
     * @var
     */
    protected static $rules;

    /**
     * @var
     */
    private $validator;

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
        if ($this->validate()) {
            return parent::save($options);
        } else {
            throw new \InvalidArgumentException(
                Utils::getInstance()->getErrorMessagesFromValidator($this->validator)." for ". static::class
            );
        }
    }

    /**
     * Validate current model before saving it to the database
     *
     * @return bool
     */
    protected function validate() : bool
    {
        // get validator object
        $v = $this->getValidator();
        // return the result
        return $v->passes();
    }


    /**
     * @return ParentValidator
     */
    public function getValidator() : ParentValidator
    {
        return $this->validator ?: $this->validator = Validator::make($this->toArray(), static::$rules);
    }

}
