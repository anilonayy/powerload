<?php

namespace App\Services\User;

interface UserServiceInterface
{
    public function update(object $payload): array;

    public function updatePassword(object $payload): array;
}
