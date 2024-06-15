<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $tasks = Task::all();
        } else {
            $tasks = $user->tasks;
        }

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        $task = Auth::user()->tasks()->create($request->all());

        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);

        if (Auth::user()->hasRole('admin') || Auth::user()->id === $task->user_id) {
            return response()->json($task);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        $task = Task::findOrFail($id);

        if (Auth::user()->hasRole('admin') || Auth::user()->id === $task->user_id) {
            $task->update($request->all());
            return response()->json($task);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if (Auth::user()->hasRole('admin') || Auth::user()->id === $task->user_id) {
            // $task->delete();
            return response()->json(['message' => 'Task Deleted Successfully'], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }


    public function getUserTasks($userId)
    {
        // Check if the authenticated user is an admin
        if (!Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Retrieve tasks for the specified user
        $tasks = Task::where('user_id', $userId)->get();

        return response()->json($tasks);
    }
}
