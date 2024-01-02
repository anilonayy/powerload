<?php

namespace App\Repositories\User;
use App\Models\User;
use App\Repositories\General\GeneralRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{

    protected GeneralRepositoryInterface $generalRepository;
    protected Model $model;
    public function __construct(GeneralRepositoryInterface $generalRepository, User $userModel)
    {
        $this->generalRepository = $generalRepository;
        $this->model = $userModel;
    }
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

    public function update(int $userId,array $data): User
    {
        $user = $this->model::findOrFail($userId);

        $user->update($data);

        return $user;
    }

    public function delete($id): void
    {
        $user = User::findOrFail($id);

        $user->delete();
    }
}
