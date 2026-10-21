
<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;

// LOGIN
Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::get('/login', function () {
    return redirect()->route('login');
})->name('login.page');

Route::post('/login', [LoginController::class, 'store'])
    ->name('login.submit');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->name('logout');

// DASHBOARD ANGGOTA
Route::middleware(['auth', 'role:anggota'])->group(function () {
    Route::get('/anggota/dashboard', function () {
        return view('dashboard.anggota');
    })->name('anggota.dashboard');

    Route::get('/tasks/create', [TaskController::class, 'create'])
        ->name('tasks.create');

    Route::post('/tasks', [TaskController::class, 'store'])
        ->name('tasks.store');
});

// DASHBOARD LEAD
Route::middleware(['auth', 'role:lead'])->group(function () {
    Route::get('/lead/dashboard', function () {
        return view('dashboard.lead');
    })->name('lead.dashboard');
});

// DASHBOARD ADMIN DAN MANAJEMEN AKUN
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin', [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'inactiveUsers' => User::where('is_active', false)->count(),
        ]);
    })->name('admin.dashboard');

    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    Route::post('/admin/users', [UserController::class, 'store'])
        ->name('admin.users.store');

    Route::put('/admin/users/{user}', [UserController::class, 'update'])
        ->name('admin.users.update');

    Route::patch('/admin/users/{user}/toggle-active', [
        UserController::class,
        'toggleActive'
    ])->name('admin.users.toggle-active');
});
