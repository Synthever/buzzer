<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // No need for constructor - auth middleware should be applied in routes
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return view('task.alltask', compact('tasks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Pending,In Progress,Completed',
            'priority' => 'required|in:Low,Medium,High',
            'deadline' => 'required|date',
            'total_slots' => 'required|integer|min:1',
            'completed_slots' => 'required|integer|min:0|lte:total_slots',
            'form_link' => 'nullable|url',
            'drive_link' => 'nullable|url',
        ]);

        $task = new Task($validated);
        $task->user_id = Auth::id();
        $task->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'task' => $task
        ]);
    }

    public function show(Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'task' => $task
        ]);
    }

    public function update(Request $request, Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Pending,In Progress,Completed',
            'priority' => 'required|in:Low,Medium,High',
            'deadline' => 'required|date',
            'total_slots' => 'required|integer|min:1',
            'completed_slots' => 'required|integer|min:0|lte:total_slots',
            'form_link' => 'nullable|url',
            'drive_link' => 'nullable|url',
        ]);

        $task->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'task' => $task
        ]);
    }

    public function destroy(Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ], 403);
        }

        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully'
        ]);
    }
}
