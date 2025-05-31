<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }
        
        return $this->userDashboard();
    }

    private function userDashboard()
    {
        $user = Auth::user();
        $tasks = $user->accessibleTasks()->latest()->get();
        
        $stats = [
            'total_tasks' => $tasks->count(),
            'pending_tasks' => $tasks->where('status', 'pending')->count(),
            'in_progress_tasks' => $tasks->where('status', 'in_progress')->count(),
            'completed_tasks' => $tasks->where('status', 'selesai')->count(),
        ];

        return view('dashboard.user', compact('tasks', 'stats'));
    }

    private function adminDashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalTasks = Task::count();
        $recentTasks = Task::with('user')->latest()->take(10)->get();
        $users = User::where('role', 'user')->get();

        $stats = [
            'total_users' => $totalUsers,
            'total_tasks' => $totalTasks,
            'pending_tasks' => Task::where('status', 'pending')->count(),
            'completed_tasks' => Task::where('status', 'selesai')->count(),
        ];

        return view('dashboard.admin', compact('stats', 'recentTasks', 'users'));
    }
}
