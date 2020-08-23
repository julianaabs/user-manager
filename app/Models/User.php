<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 *
 * @property-read string $name
 * @property-read string $email
 * @property-read string $password
 */
class User extends Model
{

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];


}