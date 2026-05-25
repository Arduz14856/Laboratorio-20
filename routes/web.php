<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/login');
});

// --- RUTAS DE AUTENTICACIÓN (PÚBLICAS) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Cierre de sesión genérico para ambos roles
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// --- RUTAS PROTEGIDAS POR AUTENTICACIÓN Y ROLES ---
Route::middleware('auth')->group(function () {

    //role:admin
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('admin.dashboard');
        Route::post('/usuarios', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    //role:usuario
    Route::middleware('role:usuario')->prefix('usuario')->group(function () {
        Route::get('/perfil', function () {
            return view('usuario.perfil');
        })->name('usuario.perfil');
    });

});