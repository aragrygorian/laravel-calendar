<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\SettingController;

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

Route::get("/cmd/{cmd}", function ($cmd) {
    \Artisan::call($cmd);
    echo "<pre>";
    return \Artisan::output();
});

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/user', UserController::class);
    Route::resource('/task' ,TaskController::class);
    Route::get('view_task' , [TaskController::class , 'getTask'])->name('task.view_task');
    Route::get('/logo' , [SettingController::class , 'logo'])->name('logo');
    Route::post('/change-logo' , [SettingController::class , 'change_logo'])->name('change-logo');
    Route::get('assign-task' ,[TaskController::class , 'calendar'])->name('assign-task');
    Route::post('fullcalenderAjax' ,[TaskController::class , 'ajax']);

    
});





require __DIR__.'/auth.php';
