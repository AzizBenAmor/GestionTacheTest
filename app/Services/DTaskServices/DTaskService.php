<?php

namespace App\Services\DTaskServices;

use App\Exceptions\CustomException;
use App\Models\DTask;
use App\Models\PTaskState;
use App\Repositories\Interfaces\DTaskRepositoryInterface;
use App\Services\PTaskStateServices\PTaskStateService;
use App\Services\UserServices\UserService;
use Illuminate\Support\Facades\DB;

class DTaskService
{

    public function __construct(private DTaskRepositoryInterface $dTaskRepository)
    {
    }

    public function getAll($filters = [])
    {
      return $this->dTaskRepository->all($filters, $filters['with'] ?? []);
    }

    public function findById($id, $with= [])
    {
        return $this->dTaskRepository->findById($id, $with);
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $dTask= $this->dTaskRepository->create($data);
            DB::commit();
            return $dTask;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new CustomException($th->getMessage());
        }
    }

    public function updateStatus($dTask)
    {
        try {
            DB::beginTransaction();
            $dTask= $this->dTaskRepository->updateStatus($dTask);
            DB::commit();
            return $dTask;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new CustomException($th->getMessage());
        }
    }

    public function update(DTask $dTask, array $data)
    {
        try {
            DB::beginTransaction();
            $dTask = $this->dTaskRepository->update($dTask, $data);
            DB::commit();
            return $dTask;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new CustomException($th->getMessage());
        }
    }

    public function delete(DTask $dTask)
    {
         $this->dTaskRepository->delete($dTask);
    }


    public function getUsers($dTask=null){
        $userService=app(UserService::class);
        if ($dTask) {
            $assignedUserIds = $dTask->assigned->pluck('id')->toArray();
            return [$userService->getAll(),$assignedUserIds];
        }
        return $userService->getAll();
    }
    public function getStatus(){
        $pTaskService=app(PTaskStateService::class);
        
        return $pTaskService->getAll();
    }
}
