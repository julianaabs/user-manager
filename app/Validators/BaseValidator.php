<?php


namespace App\Validators;


use App\Models\User;
use Respect\Validation\Validator;

/**
 * Class BaseValidator
 * @package App\Validators
 */
class BaseValidator extends Validator
{

    /**
     * @param $value
     * @return bool
     */
    public static function validateUser($value)
    {
        return User::query()->where('email', $value) === 0;
    }

}