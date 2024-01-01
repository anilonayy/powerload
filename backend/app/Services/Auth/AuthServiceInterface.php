<?php

namespace App\Services\Auth;


interface AuthServiceInterface
{
    public function login(): bool;

    public function register(): bool;

    public function logout(): void;
}
