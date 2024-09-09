<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Filterable, HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function createdTasks(){
        return $this->hasMany(DTask::class);
    }

    public function assignedTasks()
    {
        return $this->belongsToMany(DTask::class, 'd_tasks_users');
    }

    public function getRoleAttribute()
    {
        return $this->roles[0]?->name ?? null;
    }
    public function scopeOwn($query){
        return $query->whereNot('id', auth()->user()->id);
    }
}
