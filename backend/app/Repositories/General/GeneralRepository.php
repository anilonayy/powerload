<?php

namespace App\Repositories\General;

use App\Models\AppModel;
use App\Repositories\General\GeneralRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class GeneralRepository implements GeneralRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $columns
     * @param mixed $with
     * @param array $where
     * @param integer $page
     * @param integer $limit
     * @return Collection
     */
    public function all(array $columns = ['*'], mixed $with = [], array $where = [], int $page = 0, int $limit = 100): Collection
    {
        return $this->model->with($with ?? '')->where($where ?? [])->skip($page)->limit($limit)->get($columns);
    }

    /**
     * @param array $columns
     * @param mixed $with
     * @param array $where
     * @return Model
     */
    public function get(array $columns = ['*'], mixed $with = [], array $where = []): Model
    {
        return $this->model->with($with ?? '')->where($where ?? [])->limit(1)->get($columns)->first();
    }

    /**
     * @param integer $id
     * @param array $columns
     * @param array $with
     * @return Model
     */
    public function find(int $id, array $columns = ["*"], array $with = []): Model
    {
        return $this->model->with($with ?? '')->find($id, $columns);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function update(array $data): Model
    {
        $model = $this->model->findOrFail($data['id']);

        $model->update($data);

        return $model;
    }

    /**
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $model = $this->model->findOrFail($id);

        $model->delete();
    }
}
