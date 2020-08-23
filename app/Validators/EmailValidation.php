<?php


namespace App\Validators;


use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

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