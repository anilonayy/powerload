<?php

namespace App\Repositories\User;
use App\Models\User;
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

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(array $data): User
    {
        $user = User::findOrFail($data['id']);

        $user->update($data);

        return $user;
    }

    public function delete($id): void
    {
        $user = User::findOrFail($id);

        $user->delete();
    }
}
