<?php

namespace App\Http\Controllers;

// app/Http/Controllers/TaskController.php
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // Fetch all tasks for the authenticated user
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks;
        return response()->json($tasks);
    }

    // Store a new task
    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = $request->user()->tasks()->create([
            'task' => $request->task,
            'description' => $request->description,
            'completed' => false,
        ]);

        return response()->json($task, 201);
    }

    // Mark a task as completed
    public function update(Request $request, $id)
    {
        $task = $request->user()->tasks()->findOrFail($id);
        $task->update(['completed' => true]);

        return response()->json($task);
    }

    // Delete a task
    public function destroy(Request $request, $id)
    {
        $task = $request->user()->tasks()->findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
