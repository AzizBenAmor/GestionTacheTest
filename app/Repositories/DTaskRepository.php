<?php

namespace App\Repositories;

use App\Enums\TaskEnums\TaskStatusEnum;
use App\Enums\UserEnums\RoleEnum;
use App\Models\DTask;
use App\Repositories\Interfaces\DTaskRepositoryInterface;

class DTaskRepository implements DTaskRepositoryInterface
{

    public function __construct(private DTask $dTask)
    {
    }

    public function all($filters = [], $with= [])
    {
            return collection($this->dTask, $filters, $with);
    }

    public function findById($id, $with= [])
    {
            return $this->dTask->with($with)->find($id);
    }

    public function create(array $data)
    {
        $dTask=$this->dTask->create($data);
        $user=auth()->user();
        if ($user->role == RoleEnum::user()->value) {
            $data['users']=[$user->id];
        }
        $dTask->assigned()->attach($data['users']);
        return $dTask;
    }

    public function update(DTask $dTask, array $data)
    {
        $user=auth()->user();
        if (!$user->id==$dTask->user_id || !$user->role == RoleEnum::admin()->value) {
            unset($data['date']);
            unset($data['title']);
            unset($data['description']);
            unset($data['users']);
            if (isset($data['users'])) {
                $dTask->assigned()->sync($data['users']);
            }
        }
        $dTask->update($data);
        return $dTask;
    }

    public function delete(DTask $dTask)
    {
        $dTask->delete();
    }

    public function updateStatus(DTask $dTask){
        if ($dTask->status == TaskStatusEnum::Finished()->value) {
            $dTask->update([
                'status'=>TaskStatusEnum::waiting()->value
            ]);
        }
        else {
            $dTask->update([
                'status'=>$dTask->status+1
            ]); 
        }
    }

}
