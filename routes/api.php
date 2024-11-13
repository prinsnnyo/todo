<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Route to get authenticated user info
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route to get all tasks
Route::middleware('auth:sanctum')->get('/tasks', [TaskController::class, 'index']);
Route::middleware('auth:sanctum')->post('/tasks', [TaskController::class, 'store']);
Route::middleware('auth:sanctum')->patch('/tasks/{task}', [TaskController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/tasks/{task}', [TaskController::class, 'destroy']);