<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - BuzzIn</title>

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

        .task-table {
            opacity: 0;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 50;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            max-width: 28rem;
            width: 100%;
            margin: 0 1rem;
        }
    </style>
</head>
<body style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);">
    <!-- Floating Elements Background -->
    <div class="floating-elements">
        <div class="floating-circle" style="width: 100px; height: 100px; top: 10%; left: 5%;"></div>
        <div class="floating-circle" style="width: 150px; height: 150px; top: 80%; right: 10%;"></div>
        <div class="floating-circle" style="width: 80px; height: 80px; top: 40%; right: 5%;"></div>
    </div>

    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-slate-800 to-slate-900 shadow-xl relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white font-bold text-sm">B</span>
                    </div>
                    <span class="ml-3 text-xl font-semibold" style="color: var(--text-primary);">BuzzIn Dashboard</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span style="color: var(--text-secondary);">Welcome, {{ Auth::user()->name }}</span>
                    <a href="{{ route('tasks.in-progress') }}" class="hover:text-blue-400 transition duration-300" style="color: var(--text-secondary);">
                        In Progress
                    </a>
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
                            <p class="text-sm font-medium" style="color: var(--text-secondary);">Pending</p>
                            <p class="text-2xl font-bold" style="color: var(--text-primary);">{{ $stats['pending_tasks'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card glass-effect rounded-xl p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500 bg-opacity-20">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium" style="color: var(--text-secondary);">In Progress</p>
                            <p class="text-2xl font-bold" style="color: var(--text-primary);">{{ $stats['in_progress_tasks'] }}</p>
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

            <!-- Quick Actions -->
            <div class="mb-8">
                <div class="flex flex-wrap gap-4">
                    <button id="addTaskBtn" class="glass-effect hover:bg-slate-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                        + Add New Task
                    </button>
                    <a href="{{ route('tasks.in-progress') }}" class="glass-effect hover:bg-slate-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                        View In Progress Tasks
                    </a>
                </div>
            </div>

            <!-- Tasks Table -->
            <div class="task-table glass-effect rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-600">
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary);">All Tasks</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-700 bg-opacity-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">Task Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">Priority</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">Progress</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-600">
                            @forelse($tasks as $task)
                            <tr class="hover:bg-slate-700 hover:bg-opacity-30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--text-primary);">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium" style="color: var(--text-primary);">{{ $task->name }}</div>
                                    @if($task->user_id !== Auth::id())
                                        <div class="text-xs" style="color: var(--text-secondary);">by {{ $task->user->name }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $task->status_color }} bg-opacity-20">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium {{ $task->priority_color }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm" style="color: var(--text-secondary);">{{ $task->filled_slot }}/{{ $task->total_slot }}</div>
                                        <div class="ml-3 w-20 bg-gray-600 rounded-full h-2">
                                            <div class="h-2 rounded-full {{ $task->progress_bar_color }}" style="width: {{ $task->progress_percentage }}%"></div>
                                        </div>
                                        <span class="ml-2 text-xs" style="color: var(--text-secondary);">{{ $task->progress_percentage }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button onclick="viewTaskDetail({{ $task->id }})" class="text-blue-400 hover:text-blue-300 mr-3">Detail</button>
                                    <button onclick="editTask({{ $task->id }})" class="text-yellow-400 hover:text-yellow-300 mr-3">Edit</button>
                                    <button onclick="deleteTask({{ $task->id }})" class="text-red-400 hover:text-red-300">Delete</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center" style="color: var(--text-secondary);">No tasks found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Detail Modal -->
    <div id="detailModal" class="modal-overlay">
        <div class="modal-content glass-effect rounded-2xl p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold" style="color: var(--text-primary);">Task Details</h3>
                <button type="button" id="closeDetailBtn" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div id="detailContent" class="space-y-4">
                <!-- Content will be populated by JavaScript -->
            </div>
            
            <div class="mt-6">
                <button type="button" id="closeDetailFooterBtn" class="w-full glass-effect hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Add/Edit Task Modal -->
    <div id="taskModal" class="modal-overlay">
        <div class="modal-content glass-effect rounded-2xl p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 id="modalTitle" class="text-xl font-bold" style="color: var(--text-primary);">Add New Task</h3>
                <button type="button" id="closeModalBtn" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="taskForm">
                <input type="hidden" id="taskId" name="task_id">
                
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
                        <option value="completed">Completed</option>
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
                        Save Task
                    </button>
                    <button type="button" id="cancelBtn" class="flex-1 glass-effect hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get modal elements
            const modal = document.getElementById('taskModal');
            const detailModal = document.getElementById('detailModal');
            const addTaskBtn = document.getElementById('addTaskBtn');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const closeDetailBtn = document.getElementById('closeDetailBtn');
            const closeDetailFooterBtn = document.getElementById('closeDetailFooterBtn');
            const taskForm = document.getElementById('taskForm');

            // Open modal function
            function openModal() {
                modal.classList.add('active');
                document.getElementById('modalTitle').textContent = 'Add New Task';
                taskForm.reset();
                document.getElementById('taskId').value = '';
                setTimeout(() => {
                    document.getElementById('taskName').focus();
                }, 100);
            }

            // Close modal function
            function closeModal() {
                modal.classList.remove('active');
                taskForm.reset();
                document.getElementById('taskId').value = '';
            }

            // Close detail modal function
            function closeDetailModal() {
                detailModal.classList.remove('active');
            }

            // Event listeners
            addTaskBtn.addEventListener('click', openModal);
            closeModalBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);
            closeDetailBtn.addEventListener('click', closeDetailModal);
            closeDetailFooterBtn.addEventListener('click', closeDetailModal);

            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            detailModal.addEventListener('click', function(e) {
                if (e.target === detailModal) {
                    closeDetailModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (modal.classList.contains('active')) {
                        closeModal();
                    }
                    if (detailModal.classList.contains('active')) {
                        closeDetailModal();
                    }
                }
            });

            // Form submission
            taskForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const taskId = document.getElementById('taskId').value;
                const url = taskId ? `/tasks/${taskId}` : '/tasks';
                const method = taskId ? 'PUT' : 'POST';
                
                // Add method override for PUT requests
                if (method === 'PUT') {
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
                        closeModal();
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
                targets: '.task-table',
                opacity: [0, 1],
                translateY: [20, 0],
                duration: 600
            }, '-=300');

            // Floating circles
            anime({
                targets: '.floating-circle',
                translateY: [
                    { value: -10, duration: 4000 },
                    { value: 10, duration: 4000 }
                ],
                translateX: [
                    { value: 5, duration: 3000 },
                    { value: -5, duration: 3000 }
                ],
                loop: true,
                direction: 'alternate',
                easing: 'easeInOutSine'
            });

            // Make functions global for inline onclick handlers
            window.openTaskModal = openModal;
            window.closeTaskModal = closeModal;
        });

        // Task actions
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

        function editTask(taskId) {
            fetch(`/tasks/${taskId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to fetch task');
                return response.json();
            })
            .then(task => {
                const modal = document.getElementById('taskModal');
                document.getElementById('modalTitle').textContent = 'Edit Task';
                document.getElementById('taskId').value = task.id;
                document.getElementById('taskName').value = task.name;
                document.getElementById('taskPriority').value = task.priority;
                document.getElementById('taskStatus').value = task.status;
                document.getElementById('taskSlots').value = task.total_slot;
                document.getElementById('taskFormLink').value = task.form_link || '';
                document.getElementById('taskDriveLink').value = task.drive_link || '';
                modal.classList.add('active');
                
                setTimeout(() => {
                    document.getElementById('taskName').focus();
                }, 100);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading task data');
            });
        }

        function viewTaskDetail(taskId) {
            fetch(`/tasks/${taskId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Failed to fetch task');
                return response.json();
            })
            .then(task => {
                const detailContent = document.getElementById('detailContent');
                const statusClass = task.status === 'completed' ? 'text-green-400' : 
                                   task.status === 'in_progress' ? 'text-blue-400' : 'text-yellow-400';
                const priorityClass = task.priority === 'high' ? 'text-red-400' : 
                                     task.priority === 'medium' ? 'text-yellow-400' : 'text-green-400';
                
                detailContent.innerHTML = `
                    <div class="grid grid-cols-1 gap-4">
                        <div class="glass-effect rounded-lg p-4">
                            <h4 class="text-sm font-medium mb-2" style="color: var(--text-secondary);">Task Name</h4>
                            <p class="text-lg font-semibold" style="color: var(--text-primary);">${task.name}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="glass-effect rounded-lg p-4">
                                <h4 class="text-sm font-medium mb-2" style="color: var(--text-secondary);">Status</h4>
                                <p class="text-sm font-semibold ${statusClass}">${task.status.replace('_', ' ').toUpperCase()}</p>
                            </div>
                            <div class="glass-effect rounded-lg p-4">
                                <h4 class="text-sm font-medium mb-2" style="color: var(--text-secondary);">Priority</h4>
                                <p class="text-sm font-semibold ${priorityClass}">${task.priority.toUpperCase()}</p>
                            </div>
                        </div>
                        
                        <div class="glass-effect rounded-lg p-4">
                            <h4 class="text-sm font-medium mb-2" style="color: var(--text-secondary);">Progress</h4>
                            <div class="flex items-center space-x-3">
                                <span style="color: var(--text-primary);">${task.filled_slot}/${task.total_slot}</span>
                                <div class="flex-1 bg-gray-600 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-blue-500" style="width: ${task.progress_percentage}%"></div>
                                </div>
                                <span class="text-sm" style="color: var(--text-secondary);">${task.progress_percentage}%</span>
                            </div>
                        </div>
                        
                        ${task.form_link || task.drive_link ? `
                        <div class="glass-effect rounded-lg p-4">
                            <h4 class="text-sm font-medium mb-3" style="color: var(--text-secondary);">Links</h4>
                            <div class="space-y-2">
                                ${task.form_link ? `
                                <a href="${task.form_link}" target="_blank" class="flex items-center text-blue-400 hover:text-blue-300 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Google Form
                                </a>
                                ` : ''}
                                ${task.drive_link ? `
                                <a href="${task.drive_link}" target="_blank" class="flex items-center text-green-400 hover:text-green-300 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                    </svg>
                                    Google Drive
                                </a>
                                ` : ''}
                            </div>
                        </div>
                        ` : ''}
                        
                        ${task.user_id !== {{ Auth::id() }} ? `
                        <div class="glass-effect rounded-lg p-4">
                            <h4 class="text-sm font-medium mb-2" style="color: var(--text-secondary);">Created By</h4>
                            <p style="color: var(--text-primary);">${task.user?.name || 'Unknown'}</p>
                        </div>
                        ` : ''}
                    </div>
                `;
                
                document.getElementById('detailModal').classList.add('active');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading task details');
            });
        }

        // Add global function to close any modal
        window.closeAnyModal = function() {
            const modals = document.querySelectorAll('.modal-overlay');
            modals.forEach(modal => modal.classList.remove('active'));
        }

        // Add global escape key handler for all modals
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const activeModal = document.querySelector('.modal-overlay.active');
                if (activeModal) {
                    activeModal.classList.remove('active');
                }
            }
        });
    </script>
</body>
</html>