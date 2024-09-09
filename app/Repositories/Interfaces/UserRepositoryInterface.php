<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all($filters = [], $with = []);
    public function findById($id, $with= []);
    public function create(array $data);
    public function update(User $user, array $data);
    public function delete(User $user);
}
