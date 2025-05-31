<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TaskController extends Controller
{
    public function show(Task $task)
    {
        if (!$this->canManageTask($task)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->load(['user', 'logs.user']);
        return response()->json($task);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'total_slot' => 'required|integer|min:1',
            'form_link' => 'nullable|url',
            'drive_link' => 'nullable|url',
            'user_id' => 'nullable|exists:users,id'
        ]);

        $userId = $request->user_id ?? Auth::id();
        
        // Check if user can create task for this user_id
        if ($request->user_id && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Task::create([
            'user_id' => $userId,
            'name' => $request->name,
            'priority' => $request->priority,
            'total_slot' => $request->total_slot,
            'form_link' => $request->form_link,
            'drive_link' => $request->drive_link,
        ]);

        return response()->json(['success' => 'Task created successfully']);
    }

    public function update(Request $request, Task $task)
    {
        if (!$this->canManageTask($task)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'total_slot' => 'required|integer|min:1',
            'status' => 'sometimes|in:pending,in_progress,selesai',
            'form_link' => 'nullable|url',
            'drive_link' => 'nullable|url',
        ]);

        $task->update($request->only([
            'name', 'priority', 'total_slot', 'status', 'form_link', 'drive_link'
        ]));

        return response()->json(['success' => 'Task updated successfully']);
    }

    public function destroy(Task $task)
    {
        if (!$this->canManageTask($task)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->delete();
        return response()->json(['success' => 'Task deleted successfully']);
    }

    public function updateStatus(Request $request, Task $task)
    {
        if (!$this->canManageTask($task)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,selesai'
        ]);

        $task->update(['status' => $request->status]);
        return response()->json(['success' => 'Status updated successfully']);
    }

    public function submitWork(Request $request, Task $task)
    {
        if (!$this->canManageTask($task)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'screenshot' => 'required|image|max:10240', // 10MB max
            'filename' => 'required|string|max:255'
        ]);

        // Create temp directory if it doesn't exist
        $tempPath = public_path('temp');
        if (!File::exists($tempPath)) {
            File::makeDirectory($tempPath, 0755, true);
        }

        // Save file with custom name
        $extension = $request->file('screenshot')->getClientOriginalExtension();
        $filename = $request->filename . '.' . $extension;
        $request->file('screenshot')->move($tempPath, $filename);

        // Log the work
        TaskLog::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'filename' => $filename
        ]);

        // Update task progress
        $task->increment('filled_slot');
        
        // Check if task is completed
        if ($task->filled_slot >= $task->total_slot) {
            $task->update(['status' => 'selesai']);
        } elseif ($task->status === 'pending') {
            $task->update(['status' => 'in_progress']);
        }

        $task->refresh();

        return response()->json([
            'success' => 'Work submitted successfully',
            'progress' => $task->progress_percentage,
            'status' => $task->status
        ]);
    }

    public function inProgress()
    {
        $user = Auth::user();
        $tasks = $user->accessibleTasks()
                    ->where('status', 'in_progress')
                    ->with(['user', 'logs'])
                    ->latest()
                    ->get();

        return view('tasks.in-progress', compact('tasks'));
    }

    private function canManageTask(Task $task)
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return true;
        }

        // Check if user owns the task or is a collaborator
        $accessibleTaskIds = $user->accessibleTasks()->pluck('id')->toArray();
        return in_array($task->id, $accessibleTaskIds);
    }
}
