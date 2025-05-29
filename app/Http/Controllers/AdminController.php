<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // No need to add admin middleware here as it's already in the route group
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::withCount('tasks')->get();
        $tasks = Task::with(['user', 'collaborators'])->get();
        
        return view('admin.home', compact('users', 'tasks'));
    }
    
    /**
     * Get tasks for a specific user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserTasks($userId)
    {
        $user = User::findOrFail($userId);
        
        // Get user's own tasks
        $ownTasks = $user->tasks;
        
        // Get tasks where user is a collaborator
        $collaborativeTasks = Task::whereHas('collaborators', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
        
        // Merge the collections
        $tasks = $ownTasks->merge($collaborativeTasks);
        
        return response()->json(['tasks' => $tasks]);
    }
    
    /**
     * Get collaborators for a specific task.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTaskCollaborators($taskId)
    {
        $task = Task::findOrFail($taskId);
        $collaboratorIds = $task->collaborators->pluck('id')->toArray();
        
        return response()->json(['collaborators' => $collaboratorIds]);
    }
    
    /**
     * Update collaborators for a specific task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $taskId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTaskCollaborators(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $collaboratorIds = $request->input('collaborators', []);
        
        // Detach all existing collaborators
        $task->collaborators()->detach();
        
        // Attach new collaborators
        if (!empty($collaboratorIds)) {
            $task->collaborators()->attach($collaboratorIds);
        }
        
        return response()->json(['success' => true]);
    }
}
