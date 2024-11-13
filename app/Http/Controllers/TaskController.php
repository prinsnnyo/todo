<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() 
{ 
    $tasks = auth()->user()->tasks; 
    return response()->json($tasks); 
} 
 
public function store(Request $request) { 
    $request->validate(['task' => 'required|string']); 
    $task = auth()->user()->tasks()->create(['task' => $request->task]); 
    return response()->json($task); 
} 
 
public function destroy($id) 
{ 
    $task = auth()->user()->tasks()->findOrFail($id); 
    $task->delete(); 
    return response()->json(null, 204); 
} 
}
