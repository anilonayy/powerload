<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;
    public function find(string $id): User;
    public function create(array $data): User;
    public function update(int $userId, array $data): User;
    public function delete($id): void;
}
