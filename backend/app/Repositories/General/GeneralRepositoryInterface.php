<?php

namespace App\Repositories\General;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface GeneralRepositoryInterface
{
    public function all(array $columns = ['*'], mixed $with = [], array $where = [], int $page = 0, int $limit = 100): Collection;

    public function get(array $columns = ['*'], mixed $with = [], array $where = []): Model;

    public function find(int $id, array $columns = ["*"], array $with = []): Model;

    public function create(array $data): Model;

    public function update(array $data): Model;

    public function delete(int $id): void;
}
