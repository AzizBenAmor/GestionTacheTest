<?php

namespace App\Observers;

use App\Enums\TaskEnums\TaskStatusEnum;
use App\Models\DTask;

class DTaskObserver
{
    public function creating(DTask $dTask): void
    {
        $user=auth()->user();
        $dTask->user_id=$user->id;
        $dTask->status= TaskStatusEnum::waiting()->value;
    }
}
