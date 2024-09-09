<?php

namespace App\Repositories\Interfaces;

use App\Models\DTask;

interface DTaskRepositoryInterface
{
    public function all($filters = [], $with = []);
    public function findById($id, $with= []);
    public function create(array $data);
    public function update(DTask $dTask, array $data);
    public function delete(DTask $dTask);
    public function updateStatus(DTask $dTask);
}
