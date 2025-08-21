<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Public Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user/register', [UserController::class, 'store']); // Public user registration
Route::post('/role/register', [RoleController::class, 'store']); // Public role registration needs to create role first before creating a user
Route::post('/user/read/{id}', [UserController::class, 'show']);
Route::get('/roles', [RoleController::class, 'publicIndex']);



Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('user')->controller(UserController::class)->group(function () {
        Route::get('/GetAll', 'index');
        Route::get('/read/{id}', 'show');
        Route::put('/edit/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

    Route::prefix('role')->controller(RoleController::class)->group(function () {
        Route::get('/GetAll', 'index');
        Route::get('/read/{id}', 'show');
        Route::post('/create', 'store');
        Route::put('/edit/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

    Route::apiResource('/permissions', PermissionController::class);

    Route::post('/role/{id}/permissions', [RoleController::class, 'assignPermissions']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
