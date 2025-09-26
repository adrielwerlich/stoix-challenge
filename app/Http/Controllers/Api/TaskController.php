<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    /**
     * Store a newly created task.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'task_title' => 'required|string|max:255',
            'task_content' => 'required|string',
        ]);

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    /**
     * Display the specified task.
     */
    public function show(string $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    /**
     * Update the specified task.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'task_title' => 'sometimes|string|max:255',
            'task_content' => 'sometimes|string',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    /**
     * Remove the specified task.
     */
    public function destroy(string $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
