<?php

namespace App\Repositories\User;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return User::all();
    }

    /**
     *
     * @param integer $userId
     * @return User
     */
    public function find(int $userId): User
    {
        return User::findOrFail($userId);
    }

    /**
     *
     * @param object $payload
     * @return User
     */
    public function create(object $payload): User
    {
        return User::create((array) $payload);
    }

    /**
     *
     * @param integer $userId
     * @param object $payload
     * @return User
     */
    public function update(int $userId, object $payload): User
    {
        $user = User::findOrFail($userId);

        $user->update((array) $payload);

        return $user;
    }

    /**
     *
     * @param integer $userId
     * @return void
     */
    public function delete(int $userId): void
    {
        $user = User::findOrFail($userId);

        $user->delete();
    }
}
