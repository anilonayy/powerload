<?php

namespace App\Services\Auth;

use App\Services\Auth\AuthServiceInterface;

class AuthService implements AuthServiceInterface
{
    public function login(): bool
    {
        return false;
    }

    public function register(): bool
    {
        return false;
    }

    public function logout(): void
    {
        // Logout actions..
    }
}
