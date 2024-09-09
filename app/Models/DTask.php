<?php

namespace App\Models;

use App\Enums\UserEnums\RoleEnum;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DTask extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'date',
    ];
    protected $with=[
        'creater',
        'assigned',
        'statusTask'
    ];
    protected static function booted()
    {
        static::addGlobalScope('owner', function (Builder $builder) {
            $user = auth()->user();
            $role=$user->role;
            if ($role !== RoleEnum::admin()->value) {
                $builder->where('user_id',$user->id)->orWhereHas('assigned', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            }
        });
    }
    public function creater(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function assigned()
    {
        return $this->belongsToMany(User::class, 'd_tasks_users');
    }

    public function statusTask(){
        return $this->belongsTo(PTaskState::class,'status');
    }
}
