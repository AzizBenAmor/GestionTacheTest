<?php

namespace App\Repositories\Interfaces;

use App\Models\PTaskState;

interface PTaskStateRepositoryInterface
{
    public function all($filters = [], $with = []);
    public function findById($id, $with= []);
    public function create(array $data);
    public function update(PTaskState $pTaskState, array $data);
    public function delete(PTaskState $pTaskState);
}
