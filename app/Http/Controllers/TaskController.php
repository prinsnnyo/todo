<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // Retrieves all tasks for the authenticated user
    public function index() 
    { 
        // Fetch the tasks associated with the authenticated user
        $tasks = auth()->user()->tasks; 
        
        // Return tasks as JSON
        return response()->json($tasks); 
    } 

    // Stores a new task for the authenticated user
    public function store(Request $request) 
    { 
        // Validate the task field (make sure it's a string and required)
        $request->validate([
            'task' => 'required|string',
        ]); 

        // Create a new task associated with the authenticated user
        $task = auth()->user()->tasks()->create([
            'task' => $request->task, // The task description
            'completed' => false, // Default to incomplete
        ]); 

        // Return the newly created task as a JSON response
        return response()->json($task, 201); 
    } 

    // Deletes a task for the authenticated user
    public function destroy($id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
    
        // Ensure the task belongs to the authenticated user (this is optional as the relationship already ensures this)
        $this->authorize('delete', $task);
    
        $task->delete();
        return response()->json(null, 204);
    }
    
}
