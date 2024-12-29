<?php

namespace App\Livewire\Task;

use App\Enums\UserEnums\RoleEnum;
use App\Models\DTask;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;

    public $title;

    public $description;

    public $date;

    public $users = [];

    public $taskUsers;

    public function store()
    {
        $this->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date|after_or_equal:today',
            'users' => 'array|required',
            'users.*' => 'required|exists:users,id',
        ]);
        DB::beginTransaction();
        $dTask = DTask::create([
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
        ]);
        $user = auth()->user();
        if ($user->role == RoleEnum::user()->value) {
            $this->users[] = [$user->id];
        }
        $dTask->assigned()->attach($this->users);
        DB::commit();

        return redirect()->route('dashboard');
    }

    public function mount()
    {

        $this->taskUsers = User::own()->get();

    }

    public function render()
    {

        return view('livewire.task.create');
    }
}
