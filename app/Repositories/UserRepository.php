<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(private User $user)
    {
    }

    public function all($filters = [], $with= [])
    {
            return collection($this->user->own(), $filters, $with);
    }

    public function findById($id, $with= [])
    {
            return $this->user->with($with)->find($id);
    }

    public function create(array $data)
    {
        return $this->user->create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        $user->delete();
    }
}
