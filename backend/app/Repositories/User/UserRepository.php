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

    public function find(string $id): User
    {
        return User::findOrFail($id);
    }

    public function create(object $payload): User
    {
        return User::create((array) $payload);
    }

    public function update(int $userId, array $data): User
    {
        $user = User::findOrFail($userId);

        $user->update($data);

        return $user;
    }

    public function delete($id): void
    {
        $user = User::findOrFail($id);

        $user->delete();
    }
}
