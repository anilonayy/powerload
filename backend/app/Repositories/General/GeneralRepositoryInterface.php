<?php

namespace App\Repositories\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface GeneralRepositoryInterface
{
    public function all(Collection $filterOptions): Collection;
    public function find(Collection $filterOptions): Model;

    public function create(array $data): Model;

    public function update(array $data): Model;

    public function delete(int $id): void;
    public function load(Model $model, array $relations): Model;

}
