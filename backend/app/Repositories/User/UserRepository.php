<?php

namespace App\Repositories\User;
use App\Models\User;
use App\Repositories\General\GeneralRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return User::all();
    }

    public function find(int $userId): User
    {
        return User::findOrFail($userId);
    }

    public function create(object $payload): User
    {
        return User::create((array) $payload);
    }

    public function update(int $userId, object $payload): User
    {
        $user = User::findOrFail($userId);

        $user->update((array) $payload);

        return $user;
    }

    public function delete(int $userId): void
    {
        $user = User::findOrFail($userId);

        $user->delete();
    }
}
