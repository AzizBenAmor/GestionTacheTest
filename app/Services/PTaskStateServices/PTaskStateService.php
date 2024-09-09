<?php

namespace App\Services\PTaskStateServices;

use App\Models\PTaskState;

use App\Repositories\Interfaces\PTaskStateRepositoryInterface;

class PTaskStateService
{

    public function __construct(private PTaskStateRepositoryInterface $pTaskStateRepository)
    {
    }

    public function getAll($filters = [])
    {
      return $this->pTaskStateRepository->all($filters, $filters['with'] ?? []);
    }

    public function findById($id, $with= [])
    {
        return $this->pTaskStateRepository->findById($id, $with);
    }

    public function create(array $data)
    {
        return $this->pTaskStateRepository->create($data);
    }

    public function update(PTaskState $pTaskState, array $data)
    {
        return $this->pTaskStateRepository->update($pTaskState, $data);
    }

    public function delete(PTaskState $pTaskState)
    {
         $this->pTaskStateRepository->delete($pTaskState);
    }

}
