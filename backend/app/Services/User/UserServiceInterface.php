<?php

namespace App\Services\User;

interface UserServiceInterface
{
    public function update(array $payload): array;

    public function updatePassword(array $payload): array;
}
