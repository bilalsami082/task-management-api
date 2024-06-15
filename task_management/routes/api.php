<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);



Route::get('/users/{userId}/tasks', [TaskController::class, 'getUserTasks'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::resource('tasks', TaskController::class)->except(['create', 'edit']);

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['create', 'edit']);
        Route::get('users/{user}/tasks', [AdminController::class, 'viewUserTasks']);
    });
});
