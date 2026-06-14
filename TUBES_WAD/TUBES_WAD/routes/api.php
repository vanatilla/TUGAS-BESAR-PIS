<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TaskApiController;
use App\Http\Controllers\Api\NoteApiController;
use App\Http\Controllers\Api\ForumApiController;
use App\Http\Controllers\Api\ReminderApiController;
use App\Http\Controllers\Api\DashboardApiController;

/* ================= PUBLIC ================= */
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login',    [AuthApiController::class, 'login']);

/* ================= PROTECTED (Sanctum) ================= */
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout',  [AuthApiController::class, 'logout']);
    Route::get('/profile',  [AuthApiController::class, 'profile']);

    // Dashboard
    Route::get('/dashboard', [DashboardApiController::class, 'index']);

    // Tasks
    Route::get('/tasks',        [TaskApiController::class, 'index']);
    Route::get('/tasks/{id}',   [TaskApiController::class, 'show']);
    Route::post('/tasks',       [TaskApiController::class, 'store']);
    Route::put('/tasks/{id}',   [TaskApiController::class, 'update']);
    Route::delete('/tasks/{id}',[TaskApiController::class, 'destroy']);

    // Notes
    Route::get('/notes',        [NoteApiController::class, 'index']);
    Route::get('/notes/{id}',   [NoteApiController::class, 'show']);
    Route::post('/notes',       [NoteApiController::class, 'store']);
    Route::put('/notes/{id}',   [NoteApiController::class, 'update']);
    Route::delete('/notes/{id}',[NoteApiController::class, 'destroy']);

    // Forums
    Route::get('/forums',        [ForumApiController::class, 'index']);
    Route::get('/forums/{id}',   [ForumApiController::class, 'show']);
    Route::post('/forums',       [ForumApiController::class, 'store']);
    Route::put('/forums/{id}',   [ForumApiController::class, 'update']);
    Route::delete('/forums/{id}',[ForumApiController::class, 'destroy']);

    // Reminders
    Route::get('/reminders',        [ReminderApiController::class, 'index']);
    Route::post('/reminders',       [ReminderApiController::class, 'store']);
    Route::delete('/reminders/{id}',[ReminderApiController::class, 'destroy']);
});
