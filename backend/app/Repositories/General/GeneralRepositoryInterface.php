<?php

namespace App\Repositories\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface GeneralRepositoryInterface
{
    public function _all(Collection $filterOptions): Collection;
    public function _find(Collection $filterOptions): Model;
    public function _findById(int $id, Collection $filterOptions): Model;
    public function _create(array $data): Model;
    public function _update(array $data): Model;
    public function _delete(int $id): void;
    public function _checkOwnerOfModel(int $ownerId): void;
    public function _load(Model $model, array $relations): Model;

}
