<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * Get all user resources.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find user resource by id.
     *
     * @param int $userId
     *
     * @return User
     */
    public function find(int $userId): User;

    /**
     * Create user resource.
     *
     * @param object $payload
     *
     * @return User
     */
    public function create(object $payload): User;

    /**
     * Update user resource.
     *
     * @param int    $userId
     * @param object $payload
     *
     * @return User
     */
    public function update(int $userId, object $payload): User;

    /**
     * Delete user resource.
     *
     * @param int $userId
     *
     * @return void
     */
    public function delete(int $userId): void;
}
