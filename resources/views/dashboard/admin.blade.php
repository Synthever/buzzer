<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - BuzzIn</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Anime.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    
    <style>
        :root {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --border: #475569;
            --glass-bg: rgba(30, 41, 59, 0.6);
            --glass-border: rgba(71, 85, 105, 0.3);
        }

        .glass-effect {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
        }

        .glass-effect:hover {
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(71, 85, 105, 0.5);
        }

        .floating-elements {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: -1;
        }
        
        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.1), rgba(99, 102, 241, 0.1));
        }

        .dashboard-container {
            opacity: 0;
        }

        .stat-card {
            opacity: 0;
        }

        .content-section {
            opacity: 0;
        }

        .modal {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            display: flex;
            opacity: 1;
        }

        .tab-button {
            transition: all 0.3s ease;
        }

        .tab-button.active {
            background: rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.5);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);">
    <!-- Floating Elements Background -->
    <div class="floating-elements">
        <div class="floating-circle" style="width: 120px; height: 120px; top: 5%; left: 3%;"></div>
        <div class="floating-circle" style="width: 160px; height: 160px; top: 70%; right: 5%;"></div>
        <div class="floating-circle" style="width: 90px; height: 90px; top: 30%; right: 8%;"></div>
    </div>

    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-slate-800 to-slate-900 shadow-xl relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white font-bold text-sm">B</span>
                    </div>
                    <span class="ml-3 text-xl font-semibold" style="color: var(--text-primary);">Admin Dashboard</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span style="color: var(--text-secondary);">Welcome, Admin</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="glass-effect hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Dashboard -->
    <div class="dashboard-container min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stat-card glass-effect rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-500 bg-opacity-20">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium" style="color: var(--text-secondary);">Total Users</p>
                            <p class="text-2xl font-bold" style="color: var(--text-primary);">{{ $stats['total_users'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card glass-effect rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500 bg-opacity-20">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium" style="color: var(--text-secondary);">Total Tasks</p>
                            <p class="text-2xl font-bold" style="color: var(--text-primary);">{{ $stats['total_tasks'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card glass-effect rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-500 bg-opacity-20">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium" style="color: var(--text-secondary);">Pending Tasks</p>
                            <p class="text-2xl font-bold" style="color: var(--text-primary);">{{ $stats['pending_tasks'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card glass-effect rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-500 bg-opacity-20">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium" style="color: var(--text-secondary);">Completed</p>
                            <p class="text-2xl font-bold" style="color: var(--text-primary);">{{ $stats['completed_tasks'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="content-section glass-effect rounded-xl mb-8">
                <div class="border-b border-slate-600">
                    <nav class="flex space-x-8 px-6 py-4">
                        <button onclick="switchTab('tasks')" class="tab-button glass-effect px-4 py-2 rounded-lg active">Recent Tasks</button>
                        <button onclick="switchTab('users')" class="tab-button glass-effect px-4 py-2 rounded-lg">User Management</button>
                        <button onclick="switchTab('collaborations')" class="tab-button glass-effect px-4 py-2 rounded-lg">Collaborations</button>
                    </nav>
                </div>

                <!-- Recent Tasks Tab -->
                <div id="tasks-tab" class="tab-content active p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold" style="color: var(--text-primary);">Recent Tasks</h3>
                        <button onclick="openTaskModal()" class="glass-effect hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                            + Add Task for User
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-700 bg-opacity-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: var(--text-secondary);">User</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: var(--text-secondary);">Task</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: var(--text-secondary);">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: var(--text-secondary);">Progress</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: var(--text-secondary);">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-600">
                                @forelse($recentTasks as $task)
                                <tr class="hover:bg-slate-700 hover:bg-opacity-30">
                                    <td class="px-4 py-4 text-sm" style="color: var(--text-primary);">{{ $task->user->name }}</td>
                                    <td class="px-4 py-4 text-sm" style="color: var(--text-primary); max-width: 200px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word;">{{ $task->name }}</td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $task->status_color }} bg-opacity-20">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            <span class="text-sm" style="color: var(--text-secondary);">{{ $task->filled_slot }}/{{ $task->total_slot }}</span>
                                            <div class="ml-2 w-16 bg-gray-600 rounded-full h-2">
                                                <div class="h-2 rounded-full {{ $task->progress_bar_color }}" style="width: {{ $task->progress_percentage }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        <button onclick="editTask({{ $task->id }})" class="text-yellow-400 hover:text-yellow-300 mr-2">Edit</button>
                                        <button onclick="deleteTask({{ $task->id }})" class="text-red-400 hover:text-red-300">Delete</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center" style="color: var(--text-secondary);">No tasks found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Users Tab -->
                <div id="users-tab" class="tab-content p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold" style="color: var(--text-primary);">User Management</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-700 bg-opacity-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: var(--text-secondary);">Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: var(--text-secondary);">Username</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: var(--text-secondary);">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: var(--text-secondary);">Tasks</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase" style="color: var(--text-secondary);">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-600">
                                @foreach($users as $user)
                                <tr class="hover:bg-slate-700 hover:bg-opacity-30">
                                    <td class="px-4 py-4 text-sm font-medium" style="color: var(--text-primary);">{{ $user->name }}</td>
                                    <td class="px-4 py-4 text-sm" style="color: var(--text-secondary);">{{ $user->username }}</td>
                                    <td class="px-4 py-4 text-sm" style="color: var(--text-secondary);">{{ $user->email }}</td>
                                    <td class="px-4 py-4 text-sm" style="color: var(--text-secondary);">{{ $user->tasks->count() }}</td>
                                    <td class="px-4 py-4 text-sm">
                                        <button onclick="editUser({{ $user->id }})" class="text-blue-400 hover:text-blue-300 mr-2">Edit</button>
                                        <button onclick="resetPassword({{ $user->id }})" class="text-yellow-400 hover:text-yellow-300 mr-2">Reset Password</button>
                                        <button onclick="manageCollaborations({{ $user->id }})" class="text-green-400 hover:text-green-300">Collaborations</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Collaborations Tab -->
                <div id="collaborations-tab" class="tab-content p-6">
                    <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary);">Collaboration Management</h3>
                    <p style="color: var(--text-secondary);">Manage user collaborations here. Click on "Collaborations" next to a user in the User Management tab to set up collaborations.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div id="taskModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="glass-effect rounded-2xl p-8 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold" style="color: var(--text-primary);">Add Task for User</h3>
                <button onclick="closeTaskModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="taskForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Select User</label>
                    <select id="taskUserId" name="user_id" required
                            class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            style="color: var(--text-primary);">
                        <option value="">Choose a user...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->username }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Task Name</label>
                    <input type="text" id="taskName" name="name" required
                        class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        style="color: var(--text-primary);" placeholder="Enter task name">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Priority</label>
                    <select id="taskPriority" name="priority" required
                            class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            style="color: var(--text-primary);">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Status</label>
                    <select id="taskStatus" name="status" required
                            class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            style="color: var(--text-primary);">
                        <option value="pending" selected>Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="selesai">Completed</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Total Slots</label>
                    <input type="number" id="taskSlots" name="total_slot" min="1" value="1" required
                        class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        style="color: var(--text-primary);" placeholder="Number of slots">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Google Form Link</label>
                    <input type="url" id="taskFormLink" name="form_link"
                        class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        style="color: var(--text-primary);" placeholder="https://forms.google.com/...">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Google Drive Link</label>
                    <input type="url" id="taskDriveLink" name="drive_link"
                        class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        style="color: var(--text-primary);" placeholder="https://drive.google.com/...">
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                        Create Task
                    </button>
                    <button type="button" onclick="closeTaskModal()" class="flex-1 glass-effect hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Global variables
        let isEditMode = false;
        let currentTaskId = null;

        // Animation and JavaScript functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Animation on load
            const timeline = anime.timeline({
                easing: 'easeOutCubic'
            });

            timeline.add({
                targets: '.dashboard-container',
                opacity: [0, 1],
                translateY: [30, 0],
                duration: 800
            })
            .add({
                targets: '.stat-card',
                opacity: [0, 1],
                translateY: [20, 0],
                delay: anime.stagger(100),
                duration: 600
            }, '-=600')
            .add({
                targets: '.content-section',
                opacity: [0, 1],
                translateY: [20, 0],
                duration: 600
            }, '-=300');

            // Floating circles
            anime({
                targets: '.floating-circle',
                translateY: [
                    { value: -12, duration: 4000 },
                    { value: 12, duration: 4000 }
                ],
                translateX: [
                    { value: 8, duration: 3500 },
                    { value: -8, duration: 3500 }
                ],
                loop: true,
                direction: 'alternate',
                easing: 'easeInOutSine'
            });

            // Task form submission with proper event handling
            const taskForm = document.getElementById('taskForm');
            taskForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const url = isEditMode ? `/tasks/${currentTaskId}` : '/tasks';
                
                if (isEditMode) {
                    formData.append('_method', 'PUT');
                }
                
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok) {
                        closeTaskModal();
                        alert(result.success || 'Task saved successfully');
                        location.reload();
                    } else {
                        alert(result.error || 'An error occurred');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while saving the task');
                }
            });

            // Close modal when clicking outside
            const taskModal = document.getElementById('taskModal');
            taskModal.addEventListener('click', function(e) {
                if (e.target === taskModal) {
                    closeTaskModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && taskModal.classList.contains('show')) {
                    closeTaskModal();
                }
            });
        });

        // Tab switching
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(`${tabName}-tab`).classList.add('active');
            event.target.classList.add('active');
        }

        // Modal functions
        function openTaskModal() {
            const modal = document.getElementById('taskModal');
            if (modal) {
                modal.classList.add('show');
                modal.style.display = 'flex';
                
                // Reset state
                isEditMode = false;
                currentTaskId = null;
                
                // Reset form
                const form = document.getElementById('taskForm');
                if (form) {
                    form.reset();
                }
                
                // Set title for add mode
                const titleElement = modal.querySelector('h3');
                if (titleElement) {
                    titleElement.textContent = 'Add Task for User';
                }
                
                // Focus on first field
                setTimeout(() => {
                    const userIdField = document.getElementById('taskUserId');
                    if (userIdField) {
                        userIdField.focus();
                    }
                }, 100);
            }
        }

        function closeTaskModal() {
            const modal = document.getElementById('taskModal');
            if (modal) {
                modal.classList.remove('show');
                
                // Add slight delay before hiding to allow transition
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
                
                // Reset form
                const form = document.getElementById('taskForm');
                if (form) {
                    form.reset();
                }
                
                // Reset state
                isEditMode = false;
                currentTaskId = null;
            }
        }

        // Admin functions
        async function resetPassword(userId) {
            if (confirm('Reset password to default (BuzzIn@123)?')) {
                try {
                    const response = await fetch(`/admin/users/${userId}/reset-password`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok) {
                        alert(result.success || 'Password reset successfully');
                    } else {
                        alert(result.error || 'Error resetting password');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while resetting password');
                }
            }
        }

        function manageCollaborations(userId) {
            alert('Collaboration management modal to be implemented');
        }

        function editUser(userId) {
            alert('User edit modal to be implemented');
        }

        async function editTask(taskId) {
            try {
                const response = await fetch(`/tasks/${taskId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                if (!response.ok) throw new Error('Failed to fetch task');
                
                const task = await response.json();
                
                // Set edit mode
                isEditMode = true;
                currentTaskId = taskId;
                
                // Populate form with task data
                document.getElementById('taskUserId').value = task.user_id;
                document.getElementById('taskName').value = task.name;
                document.getElementById('taskPriority').value = task.priority;
                document.getElementById('taskStatus').value = task.status;
                document.getElementById('taskSlots').value = task.total_slot;
                document.getElementById('taskFormLink').value = task.form_link || '';
                document.getElementById('taskDriveLink').value = task.drive_link || '';
                
                // Update modal title
                const modal = document.getElementById('taskModal');
                const titleElement = modal.querySelector('h3');
                if (titleElement) {
                    titleElement.textContent = 'Edit Task';
                }
                
                // Show modal
                modal.style.display = 'flex';
                modal.classList.add('show');
                
                // Focus on first field
                setTimeout(() => {
                    document.getElementById('taskName').focus();
                }, 100);
                
            } catch (error) {
                console.error('Error:', error);
                alert('Error loading task data');
            }
        }

        async function deleteTask(taskId) {
            if (!confirm('Are you sure you want to delete this task?')) return;
            
            try {
                const formData = new FormData();
                formData.append('_method', 'DELETE');
                
                const response = await fetch(`/tasks/${taskId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    alert(result.success || 'Task deleted successfully');
                    location.reload();
                } else {
                    alert(result.error || 'Error deleting task');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while deleting the task');
            }
        }
    </script>
</body>
</html>