<?php

namespace App\Services\Auth;


interface AuthServiceInterface
{
    public function login(array $payload): array;

    public function register(array $payload): array;

    public function logout(): array;
}
