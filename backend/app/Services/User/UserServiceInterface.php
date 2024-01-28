<?php

namespace App\Services\User;

interface UserServiceInterface
{
    /**
     * Update user resource.
     *
     * @param object $payload
     * @return array
     */
    public function update(object $payload): array;

    /**
     * Update user password.
     *
     * @param object $payload
     * @return void
     */
    public function updatePassword(object $payload): void;
}
