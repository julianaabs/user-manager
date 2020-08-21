<?php
declare(strict_types=1);

namespace App\Domain\User;

use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

/**
 * Class User
 * @package App\Domain\User
 */
class User extends Model
{

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'password'
    ];

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }
}
