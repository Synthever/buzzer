<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - BuzzIn</title>

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
        
        /* Remove initial transforms for smoother animations */
        .register-form {
            opacity: 0;
        }
        
        .form-field {
            opacity: 0;
        }
        
        .register-button {
            opacity: 0;
        }
        
        .nav-item {
            opacity: 0;
        }
        
        .nav-buttons {
            opacity: 0;
        }
        
        .form-title {
            opacity: 0;
        }
        
        .form-subtitle {
            opacity: 0;
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
                
                <!-- Navigation Links -->
                <div class="flex items-center space-x-4 nav-buttons">
                    <a href="{{ route('home') }}" class="hover:text-blue-400 transition duration-300" style="color: var(--text-secondary);">
                        Home
                    </a>
                    <a href="{{ route('login') }}" class="glass-effect hover:bg-slate-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Register Section -->
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden py-12">
        <!-- Floating Elements Background -->
        <div class="floating-elements">
            <div class="floating-circle" style="width: 120px; height: 120px; top: 12%; left: 8%;"></div>
            <div class="floating-circle" style="width: 180px; height: 180px; top: 75%; left: 88%;"></div>
            <div class="floating-circle" style="width: 90px; height: 90px; top: 20%; left: 85%;"></div>
        </div>

        <!-- Register Form Container -->
        <div class="max-w-md w-full mx-6 relative z-10">
            <div class="register-form glass-effect rounded-2xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="form-title text-3xl font-bold mb-2" style="color: var(--text-primary);">Join BuzzIn</h2>
                    <p class="form-subtitle" style="color: var(--text-secondary);">Create your account to get started</p>
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name Field -->
                    <div class="mb-6 form-field">
                        <label for="name" class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                            Full Name
                        </label>
                        <input id="name" type="text" 
                            class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200 @error('name') ring-2 ring-red-500 @enderror" 
                            style="color: var(--text-primary);"
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autocomplete="name" 
                            autofocus
                            placeholder="Enter your full name">
                        @error('name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username Field -->
                    <div class="mb-6 form-field">
                        <label for="username" class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                            Username
                        </label>
                        <input id="username" type="text" 
                            class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200 @error('username') ring-2 ring-red-500 @enderror" 
                            style="color: var(--text-primary);"
                            name="username" 
                            value="{{ old('username') }}" 
                            required 
                            autocomplete="username"
                            placeholder="Choose a username">
                        @error('username')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-6 form-field">
                        <label for="email" class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                            Email Address
                        </label>
                        <input id="email" type="email" 
                            class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200 @error('email') ring-2 ring-red-500 @enderror" 
                            style="color: var(--text-primary);"
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email"
                            placeholder="Enter your email address">
                        @error('email')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-6 form-field">
                        <label for="password" class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                            Password
                        </label>
                        <input id="password" type="password" 
                            class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200 @error('password') ring-2 ring-red-500 @enderror" 
                            style="color: var(--text-primary);"
                            name="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="Create a password">
                        @error('password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-6 form-field">
                        <label for="password_confirmation" class="block text-sm font-medium mb-2" style="color: var(--text-primary);">
                            Confirm Password
                        </label>
                        <input id="password_confirmation" type="password" 
                            class="w-full px-4 py-3 rounded-lg glass-effect focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200" 
                            style="color: var(--text-primary);"
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Confirm your password">
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-6">
                        <button type="submit" 
                                class="register-button w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Create Account
                        </button>
                    </div>

                    <!-- Links -->
                    <div class="text-center form-field">
                        <div class="text-sm" style="color: var(--text-secondary);">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium transition-colors duration-200">
                                Sign in here
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Improved smooth intro animation
        document.addEventListener('DOMContentLoaded', function() {
            // Create main timeline
            const mainTimeline = anime.timeline({
                easing: 'easeOutCubic',
                autoplay: true
            });

            // Start with floating elements
            mainTimeline.add({
                targets: '.floating-elements',
                opacity: [0, 1],
                duration: 800,
                easing: 'easeInOutQuad'
            })
            
            // Navigation animation
            .add({
                targets: '.nav-item',
                opacity: [0, 1],
                translateX: [-30, 0],
                duration: 600,
                easing: 'easeOutExpo'
            }, 200)
            
            .add({
                targets: '.nav-buttons a',
                opacity: [0, 1],
                translateY: [-20, 0],
                delay: anime.stagger(100),
                duration: 500,
                easing: 'easeOutExpo'
            }, 300)
            
            // Main form container
            .add({
                targets: '.register-form',
                opacity: [0, 1],
                translateY: [40, 0],
                scale: [0.9, 1],
                duration: 800,
                easing: 'easeOutBack'
            }, 400)
            
            // Form header
            .add({
                targets: '.form-title',
                opacity: [0, 1],
                translateY: [20, 0],
                duration: 600,
                easing: 'easeOutExpo'
            }, 600)
            
            .add({
                targets: '.form-subtitle',
                opacity: [0, 1],
                translateY: [15, 0],
                duration: 500,
                easing: 'easeOutExpo'
            }, 700)
            
            // Form fields with stagger (slower for more fields)
            .add({
                targets: '.form-field',
                opacity: [0, 1],
                translateY: [20, 0],
                delay: anime.stagger(100),
                duration: 600,
                easing: 'easeOutExpo'
            }, 800)
            
            // Submit button
            .add({
                targets: '.register-button',
                opacity: [0, 1],
                scale: [0.8, 1],
                duration: 500,
                easing: 'easeOutBack'
            }, 1200);

            // Continuous floating circles animation
            anime({
                targets: '.floating-circle',
                translateY: [
                    { value: -12, duration: 3500 },
                    { value: 12, duration: 3500 }
                ],
                translateX: [
                    { value: 8, duration: 3000 },
                    { value: -8, duration: 3000 }
                ],
                rotate: [
                    { value: 360, duration: 10000 }
                ],
                loop: true,
                direction: 'alternate',
                easing: 'easeInOutSine',
                delay: anime.stagger(600)
            });
        });

        // Input focus animations
        document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]').forEach(input => {
            input.addEventListener('focus', () => {
                anime({
                    targets: input,
                    scale: [1, 1.02],
                    duration: 200,
                    easing: 'easeOutCubic'
                });
            });
            
            input.addEventListener('blur', () => {
                anime({
                    targets: input,
                    scale: [1.02, 1],
                    duration: 200,
                    easing: 'easeOutCubic'
                });
            });
        });

        // Button hover animations
        document.querySelector('.register-button').addEventListener('mouseenter', function() {
            anime({
                targets: this,
                scale: [1, 1.05],
                duration: 200,
                easing: 'easeOutCubic'
            });
        });

        document.querySelector('.register-button').addEventListener('mouseleave', function() {
            anime({
                targets: this,
                scale: [1.05, 1],
                duration: 200,
                easing: 'easeOutCubic'
            });
        });
    </script>
</body>
</html>
