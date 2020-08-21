<?php
declare(strict_types=1);

namespace App\Domain\User\Repositories;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User;
}
