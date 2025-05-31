<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>In Progress Tasks - BuzzIn</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='url(%23grad)'/>%3Cdefs%3E%3ClinearGradient id='grad' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%233b82f6'/%3E%3Cstop offset='100%25' style='stop-color:%236366f1'/%3E%3C/linearGradient%3E%3C/defs%3E<text x='16' y='22' text-anchor='middle' fill='white' font-family='Arial, sans-serif' font-size='18' font-weight='bold'>B</text></svg>" type="image/svg+xml">

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

        .page-container {
            opacity: 0;
        }

        .task-card {
            opacity: 0;
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 50;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }
    </style>
</head>
<body style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);">
    <!-- Floating Elements Background -->
    <div class="floating-elements">
        <div class="floating-circle" style="width: 80px; height: 80px; top: 15%; left: 8%;"></div>
        <div class="floating-circle" style="width: 120px; height: 120px; top: 70%; right: 10%;"></div>
        <div class="floating-circle" style="width: 60px; height: 60px; top: 40%; right: 15%;"></div>
    </div>

    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-slate-800 to-slate-900 shadow-xl relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white font-bold text-sm">B</span>
                    </div>
                    <span class="ml-3 text-xl font-semibold" style="color: var(--text-primary);">BuzzIn - In Progress Tasks</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition duration-300" style="color: var(--text-secondary);">
                        Dashboard
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

    <!-- Main Content -->
    <div class="page-container min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-2" style="color: var(--text-primary);">In Progress Tasks</h1>
                <p style="color: var(--text-secondary);">Tasks that are currently being worked on</p>
            </div>

            @if($tasks->isEmpty())
                <div class="glass-effect rounded-xl p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-lg font-semibold mb-2" style="color: var(--text-primary);">No In Progress Tasks</h3>
                    <p style="color: var(--text-secondary);">You don't have any tasks in progress at the moment.</p>
                    <a href="{{ route('dashboard') }}" class="inline-block mt-4 glass-effect hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        Back to Dashboard
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tasks as $task)
                        <div class="task-card glass-effect rounded-xl p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-semibold" style="color: var(--text-primary);">{{ $task->name }}</h3>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $task->priority_color }} bg-opacity-20">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>

                            @if($task->user_id !== Auth::id())
                                <p class="text-sm mb-3" style="color: var(--text-secondary);">by {{ $task->user->name }}</p>
                            @endif

                            <!-- Progress -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-2">
                                    <span style="color: var(--text-secondary);">Progress</span>
                                    <span style="color: var(--text-primary);">{{ $task->filled_slot }}/{{ $task->total_slot }}</span>
                                </div>
                                <div class="w-full bg-gray-600 rounded-full h-3">
                                    <div class="h-3 rounded-full {{ $task->progress_bar_color }}" style="width: {{ $task->progress_percentage }}%"></div>
                                </div>
                                <p class="text-xs mt-1" style="color: var(--text-secondary);">{{ $task->progress_percentage }}% complete</p>
                            </div>

                            <!-- Links -->
                            @if($task->form_link || $task->drive_link)
                                <div class="mb-4 space-y-2">
                                    @if($task->form_link)
                                        <a href="{{ $task->form_link }}" target="_blank" class="flex items-center text-sm text-blue-400 hover:text-blue-300">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Google Form
                                        </a>
                                    @endif
                                    @if($task->drive_link)
                                        <a href="{{ $task->drive_link }}" target="_blank" class="flex items-center text-sm text-green-400 hover:text-green-300">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                            </svg>
                                            Google Drive
                                        </a>
                                    @endif
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <button onclick="openWorkModal({{ $task->id }})" 
                                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200">
                                    Submit Work
                                </button>
                                <button onclick="viewDetails({{ $task->id }})" 
                                        class="glass-effect hover:bg-slate-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200">
                                    Details
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Task Detail Modal -->
    <div id="detailModal" class="modal">
        <div class="glass-effect rounded-2xl p-8 max-w-lg w-full mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold" style="color: var(--text-primary);">Task Details</h3>
                <button id="closeDetailModalBtn" type="button" class="text-gray-400 hover:text-white transition-colors">
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

    <!-- Submit Work Modal -->
    <div id="workModal" class="modal">
        <div class="glass-effect rounded-2xl p-8 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold" style="color: var(--text-primary);">Submit Work</h3>
                <button id="closeWorkModalBtn" type="button" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="workForm" enctype="multipart/form-data">
                <input type="hidden" id="workTaskId" name="task_id">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Screenshot</label>
                    <input type="file" id="screenshot" name="screenshot" accept="image/*" required
                           class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           style="color: var(--text-primary);">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">File Name</label>
                    <input type="text" id="filename" name="filename" required
                           class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           style="color: var(--text-primary);" placeholder="Enter custom filename (without extension)">
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                        Submit Work
                    </button>
                    <button type="button" id="cancelWorkBtn" class="flex-1 glass-effect hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const timeline = anime.timeline({
                easing: 'easeOutCubic'
            });

            timeline.add({
                targets: '.page-container',
                opacity: [0, 1],
                translateY: [30, 0],
                duration: 800
            })
            .add({
                targets: '.task-card',
                opacity: [0, 1],
                translateY: [20, 0],
                delay: anime.stagger(100),
                duration: 600
            }, '-=600');

            // Floating circles
            anime({
                targets: '.floating-circle',
                translateY: [
                    { value: -8, duration: 3000 },
                    { value: 8, duration: 3000 }
                ],
                translateX: [
                    { value: 5, duration: 2500 },
                    { value: -5, duration: 2500 }
                ],
                loop: true,
                direction: 'alternate',
                easing: 'easeInOutSine'
            });

            // Modal event listeners
            const modal = document.getElementById('workModal');
            const detailModal = document.getElementById('detailModal');
            const closeBtn = document.getElementById('closeWorkModalBtn');
            const cancelBtn = document.getElementById('cancelWorkBtn');
            const closeDetailBtn = document.getElementById('closeDetailModalBtn');
            const closeDetailFooterBtn = document.getElementById('closeDetailFooterBtn');

            // Close modal events
            closeBtn.addEventListener('click', closeWorkModal);
            cancelBtn.addEventListener('click', closeWorkModal);
            closeDetailBtn.addEventListener('click', closeDetailModal);
            closeDetailFooterBtn.addEventListener('click', closeDetailModal);

            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeWorkModal();
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
                    if (modal.classList.contains('show')) {
                        closeWorkModal();
                    }
                    if (detailModal.classList.contains('show')) {
                        closeDetailModal();
                    }
                }
            });
        });

        // Modal functions
        function openWorkModal(taskId) {
            document.getElementById('workTaskId').value = taskId;
            document.getElementById('workModal').classList.add('show');
            setTimeout(() => {
                document.getElementById('screenshot').focus();
            }, 100);
        }

        function closeWorkModal() {
            document.getElementById('workModal').classList.remove('show');
            document.getElementById('workForm').reset();
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.remove('show');
        }

        function viewDetails(taskId) {
            // Fetch and show task details
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
                                <p class="text-sm font-semibold text-blue-400">IN PROGRESS</p>
                            </div>
                            <div class="glass-effect rounded-lg p-4">
                                <h4 class="text-sm font-medium mb-2" style="color: var(--text-secondary);">Priority</h4>
                                <p class="text-sm font-semibold ${priorityClass}">${task.priority.toUpperCase()}</p>
                            </div>
                        </div>
                        
                        <div class="glass-effect rounded-lg p-4">
                            <h4 class="text-sm font-medium mb-2" style="color: var(--text-secondary);">Progress</h4>
                            <div class="flex items-center space-x-3">
                                <span style="color: var(--text-primary);">{{ $task->filled_slot }}/{{ $task->total_slot }}</span>
                                <div class="flex-1 bg-gray-600 rounded-full h-3">
                                    <div class="h-3 rounded-full bg-blue-500" style="width: {{ $task->progress_percentage }}%"></div>
                                </div>
                                <span class="text-sm" style="color: var(--text-secondary);">{{ $task->progress_percentage }}%</span>
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
                
                document.getElementById('detailModal').classList.add('show');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading task details');
            });
        }

        // Form submission
        document.getElementById('workForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const taskId = document.getElementById('workTaskId').value;
            
            try {
                const response = await fetch(`/tasks/${taskId}/submit-work`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    alert(result.success || 'Work submitted successfully');
                    closeWorkModal();
                    location.reload();
                } else {
                    alert(result.error || 'An error occurred');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while submitting work');
            }
        });
    </script>
</body>
</html>
