<?php

namespace App\Services;

class AuthService implements AuthServiceInterface
{
    private const ADMIN_USERNAME = 'admin';
    private const ADMIN_PASWORD = '123';

    /**
     * AuthService constructor.
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            return true;
        }

        return false;
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @return bool
     */
    public function logIn(string $login, string $password): bool
    {
        if ($login == self::ADMIN_USERNAME && $password == self::ADMIN_PASWORD) {
            $_SESSION['logged_in'] = true;

            return true;
        }

        return false;
    }

    public function logOut(): void
    {
        $_SESSION['logged_in'] = false;
    }
}
