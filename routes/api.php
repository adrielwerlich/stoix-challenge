<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

// Tasks CRUD REST endpoints
// Route::apiResource('tasks', TaskController::class);

// Alternative explicit routes (if you prefer to define them individually):
Route::get('/tasks', [TaskController::class, 'index']);           // GET /api/tasks
Route::post('/tasks', [TaskController::class, 'store']);          // POST /api/tasks
Route::get('/tasks/{id}', [TaskController::class, 'show']);       // GET /api/tasks/{id}
Route::put('/tasks/{id}', [TaskController::class, 'update']);     // PUT /api/tasks/{id}
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // DELETE /api/tasks/{id}