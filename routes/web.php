<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DTaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PTaskStateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::post('login',[AuthController::class,'login']);
Route::get('/dashboard', [DTaskController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/{task}/update-status', [DTaskController::class, 'updateStatus'])->middleware(['auth', 'verified'])->name('status');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    ############################### task-state ###############################
    Route::prefix('task-states')->group(function () {
        Route::get('/', [PTaskStateController::class, 'index']);
        Route::get('/{id}', [PTaskStateController::class, 'show']);
    });
    ############################### task ###############################
    Route::prefix('tasks')->group(function () {
        Route::get('/', [DTaskController::class, 'index']);
        Route::post('/', [DTaskController::class, 'store'])->name('storeTask');
        Route::put('/{task}', [DTaskController::class, 'update'])->name('updateTask');
        Route::get('/{task}/edit', [DTaskController::class, 'edit'])->name('editTask');
        Route::get('/create', [DTaskController::class, 'create'])->name('createTask');
        Route::get('/{id}', [DTaskController::class, 'show']);
        Route::delete('/{task}', [DTaskController::class, 'destroy'])->name('deleteTask');
    });
});

require __DIR__.'/auth.php';

