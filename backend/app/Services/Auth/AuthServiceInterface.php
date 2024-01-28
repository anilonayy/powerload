<?php

namespace App\Services\Auth;


interface AuthServiceInterface
{
    public function login(object $payload): array;

    public function register(object $payload): array;
    public function forgotPassword(object $payload): array;
    public function resetPassword (object $payload): array;
    public function logout(): void;
}
