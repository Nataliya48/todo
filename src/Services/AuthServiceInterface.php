<?php

namespace App\Services;

interface AuthServiceInterface
{
    /**
     * @return bool
     */
    public function isLoggedIn(): bool;

    /**
     * @param string $login
     * @param string $password
     *
     * @return bool
     */
    public function logIn(string $login, string $password): bool;

    /**
     *
     */
    public function logOut(): void;

}
