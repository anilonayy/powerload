<?php

namespace App\Repositories\General;

use App\Enums\ResponseMessageEnums;
use App\Repositories\General\GeneralRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GeneralRepository implements GeneralRepositoryInterface
{
    protected Model $model;

    public function __construct(string $model)
    {
        $this->model = app()->make($model);
    }

    /**
     * @param Collection $filterOptions
     * @return Collection
     */
    public function _all(Collection $filterOptions): Collection
    {
        return $this->_applyFilters($filterOptions)->get();
    }


    /**
     * @param integer $id
     * @param array $columns
     * @param array $with
     * @return Model
     */
    public function _find(Collection $filterOptions): Model
    {
        return $this->_applyFilters($filterOptions)->first();
    }

    public function _findById(int $id, Collection $filterOptions): Model
    {
        return $this->_applyFilters($filterOptions)->find($id);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function _create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function _update(array $data): Model
    {
        $model = $this->model->findOrFail($data['id']);

        $model->update($data);

        return $model;
    }

    /**
     * @param integer $id
     * @return void
     */
    public function _delete(int $id): void
    {
        $model = $this->model->findOrFail($id);

        $model->delete();
    }

    public function _checkOwnerOfModel(int $ownerId): void
    {
        if ($ownerId !== auth()->user()->id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * @param Model $model
     * @param array $relations
     * @return Model
     */
    public function _load(Model $model, array $relations): Model
    {
        return $model->load($relations);
    }

    /**
     * @param Collection $filterOptions
     * @return Builder
     */
    private function _applyFilters(Collection $filterOptions): Builder
    {
        return $this->model->when($filterOptions->has('limit'), function (Builder $query) use ($filterOptions) {
            return $query->limit($filterOptions->get('limit'));
        })
        ->when($filterOptions->has('skip'), function (Builder $query) use ($filterOptions) {
            return $query->skip($filterOptions->get('skip'));
        })
        ->when($filterOptions->has('where'), function (Builder $query) use ($filterOptions) {
            return $query->where($filterOptions->get('where'));
        })
        ->when($filterOptions->has('with'), function (Builder $query) use ($filterOptions) {
            return $query->with($filterOptions->get('with'));
        })
        ->when($filterOptions->has('select'), function (Builder $query) use ($filterOptions) {
            return $query->select($filterOptions->get('select'));
        })
        ->when($filterOptions->has('withCount'), function (Builder $query) use ($filterOptions) {
            return $query->withCount($filterOptions->get('withCount'));
        })
        ->orderBy('id', 'ASC')
        ->when($filterOptions->has('orderBy'), function (Builder $query) use ($filterOptions) {
            return $query->orderBy($filterOptions->get('orderBy'));
        });
    }
}
