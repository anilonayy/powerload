<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;
    public function find(int $userId): User;
    public function create(object $payload): User;
    public function update(int $userId, object $payload): User;
    public function delete(int $userId): void;
}
