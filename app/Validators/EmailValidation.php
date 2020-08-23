<?php


namespace App\Validators;


use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

/**
 * Class EmailValidation
 * @package App\Validators
 */
class EmailValidation extends AbstractRule
{

    /**
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        return User::query()->where('email', $value) === 0;
    }

}