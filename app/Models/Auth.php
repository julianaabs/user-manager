<?php


namespace App\Models;


/**
 * Class Auth
 * @package App\Models
 */
class Auth
{

    /**
     * @return bool
     */
    public function logged(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function me()
    {
        if (isset($_SESSION['user'])) {
            return User::query()->find($_SESSION['user']);
        }

        return null;
    }

    /**
     * Logout user
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
    }

    /**
     * @param array $values
     * @return bool
     */
    public function authenticate(array $values): bool
    {
        /** @var User $user */
        $user = User::query()->where('email', $values['email'])->first();

        if ($user) {
            if (password_verify($values['password'], $user->password)) {
                $_SESSION['user'] = $user->getKey();
                return true;
            }
        }

        var_dump($user);

        return false;

    }

}