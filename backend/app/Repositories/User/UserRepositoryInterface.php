<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;
    public function find(string $id): User;
    public function create(object $payload): User;
    public function update(int $userId, array $payload): User;
    public function delete($id): void;
}
