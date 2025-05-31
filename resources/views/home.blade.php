<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BuzzIn</title>

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
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.3), rgba(99, 102, 241, 0.2));
        }
        
        .hero-text {
            opacity: 0;
            transform: translateY(50px);
        }
        
        .feature-card {
            opacity: 0;
            transform: translateY(30px);
        }
    </style>
</head>
<body style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);">
    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-slate-800 to-slate-900 shadow-xl relative z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center nav-item">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">B</span>
                        </div>
                        <span class="ml-3 text-xl font-semibold" style="color: var(--text-primary);">BuzzIn</span>
                    </a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4 nav-buttons">
                    @guest
                        <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="glass-effect hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                            Register
                        </a>
                    @else
                        <a href="{{ route('home.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="glass-effect hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                                Logout
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Floating Elements Background -->
        <div class="floating-elements">
            <div class="floating-circle" style="width: 200px; height: 200px; top: 10%; left: 10%;"></div>
            <div class="floating-circle" style="width: 300px; height: 300px; top: 50%; left: 80%;"></div>
            <div class="floating-circle" style="width: 150px; height: 150px; top: 80%; left: 20%;"></div>
            <div class="floating-circle" style="width: 100px; height: 100px; top: 20%; left: 70%;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center relative z-10">
            <div class="hero-element">
                <div class="inline-flex items-center px-4 py-2 rounded-full glass-effect mb-8">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                    <span class="text-sm font-medium" style="color: var(--text-secondary);">Now Available</span>
                </div>
            </div>

            <h1 class="hero-element text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-blue-400 via-purple-500 to-blue-600 bg-clip-text text-transparent">
                Build faster with<br>BuzzIn
            </h1>

            <p class="hero-element text-xl md:text-2xl mb-12 max-w-3xl mx-auto" style="color: var(--text-secondary);">
                The ultimate task management platform that helps teams collaborate, track progress, and deliver projects faster than ever before.
            </p>

            @guest
                <div class="hero-element flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                        Start for free
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 glass-effect hover:bg-slate-700 font-semibold rounded-lg transition-all duration-200 transform hover:scale-105" style="color: var(--text-primary);">
                        Sign in
                    </a>
                </div>
            @else
                <div class="hero-element">
                    <a href="{{ route('home.dashboard') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 inline-block">
                        Go to Dashboard
                    </a>
                </div>
            @endguest
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24" style="background: var(--bg-secondary);">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-bold mb-6" style="color: var(--text-primary);">
                    Everything you need
                </h2>
                <p class="text-xl max-w-3xl mx-auto" style="color: var(--text-secondary);">
                    Powerful features designed to streamline your workflow and boost productivity.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card p-8 rounded-2xl glass-effect hover:bg-slate-700 transition-all duration-300 transform hover:scale-105">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4" style="color: var(--text-primary);">Smart Task Management</h3>
                    <p style="color: var(--text-secondary);">Organize and prioritize tasks with intelligent automation and intuitive workflows.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card p-8 rounded-2xl glass-effect hover:bg-slate-700 transition-all duration-300 transform hover:scale-105">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4" style="color: var(--text-primary);">Team Collaboration</h3>
                    <p style="color: var(--text-secondary);">Work seamlessly with your team through real-time updates and shared workspaces.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card p-8 rounded-2xl glass-effect hover:bg-slate-700 transition-all duration-300 transform hover:scale-105">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4" style="color: var(--text-primary);">Advanced Analytics</h3>
                    <p style="color: var(--text-secondary);">Track progress and performance with detailed insights and customizable reports.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12" style="background: var(--bg-tertiary); border-top: 1px solid var(--border);">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <p style="color: var(--text-secondary);">&copy; {{ date('Y') }} BuzzIn. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Hero animations
        anime({
            targets: '.hero-element',
            opacity: [0, 1],
            translateY: [30, 0],
            delay: anime.stagger(200, {start: 500}),
            duration: 1000,
            easing: 'easeOutCubic'
        });

        // Feature cards animation
        anime({
            targets: '.feature-card',
            opacity: [0, 1],
            translateY: [50, 0],
            delay: anime.stagger(100),
            duration: 800,
            easing: 'easeOutCubic'
        });

        // Floating circles animation
        anime({
            targets: '.floating-circle',
            translateY: [
                { value: -30, duration: 4000 },
                { value: 30, duration: 4000 }
            ],
            translateX: [
                { value: 20, duration: 3000 },
                { value: -20, duration: 3000 }
            ],
            rotate: [
                { value: 360, duration: 8000 }
            ],
            loop: true,
            direction: 'alternate',
            easing: 'easeInOutSine',
            delay: anime.stagger(1000)
        });

        // Global modal closing functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Function to close all modals
            window.closeAllModals = function() {
                const modals = document.querySelectorAll('.modal-overlay, [class*="modal"]');
                modals.forEach(modal => {
                    modal.classList.remove('active');
                    modal.style.display = 'none';
                });
            };

            // Global escape key handler for all modals
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAllModals();
                }
            });

            // Global click outside modal handler
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal-overlay') || 
                    e.target.closest('[class*="modal-overlay"]')) {
                    if (e.target === e.currentTarget) {
                        closeAllModals();
                    }
                }
            });

            // Close button handler for all modals
            document.addEventListener('click', function(e) {
                if (e.target.matches('[class*="close"], [id*="close"], [data-close="modal"]') ||
                    e.target.closest('[class*="close"], [id*="close"], [data-close="modal"]')) {
                    closeAllModals();
                }
            });
        });
    </script>
</body>
</html>
