<?php

use App\Enums\PPaymentActionEnums\PPaymentActionEnum;
use App\Enums\UserEnums\RoleEnum;
use App\Enums\UserEnums\UserStateEnum;
use App\Models\DLog;
use App\Models\DOrder;
use App\Models\DOrderHistory;
use App\Models\DOrderTime;
use App\Models\DPass;
use App\Models\PPreference;
use App\Models\PShortCode;
use App\Models\User;
use App\Notifications\MainNotification;
use App\Services\DOrderHistoryServices\DOrderHistoryService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

function collection($model, $filters, $with = [], $order = 'id', $select = [])
{
    $orderedModel = $model->orderByDesc($order)->filter($filters);
    if ($with) {
        $orderedModel->with($with);
    }

    if ($select) {
        $orderedModel->select($select);
    }

    return $orderedModel->paginate($filters['page_size'] ?? defaultPagination())
      ;
}

function uploadFile($file, $path)
{
    $fileName = uniqid() . '_' . time() . $file->hashName();

    return Storage::disk('local')->putFileAs(
        $path,
        $file,
        $fileName,
        'private'
    );
}

function defaultPagination()
{
    return  10;
}


function checkPermission($permission, $user, $model)
{
    return $user->can($permission) && $model->d_user_id == $user->d_user_id;

}