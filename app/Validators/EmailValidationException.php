<?php


namespace App\Validators;


use Respect\Validation\Exceptions\ValidationException;

/**
 * Class EmailValidationException
 * @package App\Validators
 */
class EmailValidationException extends ValidationException
{

    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Email has already been taken.'
        ]
    ];

}