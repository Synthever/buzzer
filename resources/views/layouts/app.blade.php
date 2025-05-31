<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="theme-dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BuzzIn')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Anime.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    
    <style>
        :root {
            --bg-primary: #0a0a0a;
            --bg-secondary: #111111;
            --bg-tertiary: #1a1a1a;
            --text-primary: #ffffff;
            --text-secondary: #a3a3a3;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            --border: #2a2a2a;
        }

        .theme-light {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --accent: #3b82f6;
            --accent-hover: #2563eb;
            --border: #e2e8f0;
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
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.1), rgba(99, 102, 241, 0.05));
        }

        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .theme-light .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .nav-item {
            opacity: 0;
            transform: translateY(-20px);
        }

        .hero-element {
            opacity: 0;
            transform: translateY(30px);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }
    </style>
</head>
<body style="background-color: var(--bg-primary); color: var(--text-primary);" class="transition-colors duration-300">
    <!-- Navigation Bar -->
    <nav class="fixed top-0 w-full z-50 glass-effect">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center nav-item">
                    <a href="{{ route('home') }}" class="flex items-center group">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">B</span>
                        </div>
                        <span class="ml-3 text-xl font-semibold" style="color: var(--text-primary);">BuzzIn</span>
                    </a>
                </div>

                <!-- Center Navigation Links -->
                <div class="hidden md:flex items-center space-x-8 nav-item">
                    <a href="{{ route('home') }}" class="text-sm font-medium hover:text-blue-400 transition-colors duration-200" style="color: var(--text-secondary);">
                        Home
                    </a>
                    @auth
                        <a href="{{ route('tasks.index') }}" class="text-sm font-medium hover:text-blue-400 transition-colors duration-200" style="color: var(--text-secondary);">
                            Tasks
                        </a>
                    @endauth
                    <a href="#" class="text-sm font-medium hover:text-blue-400 transition-colors duration-200" style="color: var(--text-secondary);">
                        Features
                    </a>
                    <a href="#" class="text-sm font-medium hover:text-blue-400 transition-colors duration-200" style="color: var(--text-secondary);">
                        About
                    </a>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-4 nav-item">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg hover:bg-gray-800 theme-light:hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-5 h-5 text-gray-400 theme-toggle-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        <svg class="w-5 h-5 text-gray-400 theme-toggle-light hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </button>

                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-blue-400 transition-colors duration-200" style="color: var(--text-secondary);">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            Get Started
                        </a>
                    @else
                        <div class="relative group">
                            <button class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-800 theme-light:hover:bg-gray-200 transition-colors duration-200">
                                <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full"></div>
                                <span class="text-sm font-medium" style="color: var(--text-primary);">{{ Auth::user()->name }}</span>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 glass-effect rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <div class="py-2">
                                    <a href="{{ route('home.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-800 theme-light:hover:bg-gray-200 transition-colors duration-200" style="color: var(--text-secondary);">Dashboard</a>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-800 theme-light:hover:bg-gray-200 transition-colors duration-200" style="color: var(--text-secondary);">Sign Out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        const darkIcon = document.querySelector('.theme-toggle-dark');
        const lightIcon = document.querySelector('.theme-toggle-light');

        // Check for saved theme preference or default to 'dark'
        const currentTheme = localStorage.getItem('theme') || 'dark';
        html.className = `theme-${currentTheme}`;
        updateThemeIcons(currentTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.className.includes('theme-dark') ? 'dark' : 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.className = `theme-${newTheme}`;
            localStorage.setItem('theme', newTheme);
            updateThemeIcons(newTheme);
        });

        function updateThemeIcons(theme) {
            if (theme === 'dark') {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            } else {
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
            }
        }

        // Navigation Animation
        anime({
            targets: '.nav-item',
            opacity: [0, 1],
            translateY: [-20, 0],
            delay: anime.stagger(100),
            duration: 800,
            easing: 'easeOutCubic'
        });
    </script>
</body>
</html>
