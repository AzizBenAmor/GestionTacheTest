<?php

namespace App\Repositories;

use App\Models\PTaskState;
use App\Repositories\Interfaces\PTaskStateRepositoryInterface;

class PTaskStateRepository implements PTaskStateRepositoryInterface
{

    public function __construct(private PTaskState $pTaskState)
    {
    }

    public function all($filters = [], $with= [])
    {
            return collection($this->pTaskState, $filters, $with,'status');
    }

    public function findById($id, $with= [])
    {
            return $this->pTaskState->with($with)->find($id);
    }

    public function create(array $data)
    {
        return $this->pTaskState->create($data);
    }

    public function update(PTaskState $pTaskState, array $data)
    {
        $pTaskState->update($data);
        return $pTaskState;
    }

    public function delete(PTaskState $pTaskState)
    {
        $pTaskState->delete();
    }
}
