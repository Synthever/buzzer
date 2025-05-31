<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Validation\ValidationException;

    class LoginController extends Controller
    {
        /**
         * Where to redirect users after login.
         *
         * @var string
         */
        protected $redirectTo = '/dashboard';

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }

        /**
         * Show the application's login form.
         *
         * @return \Illuminate\View\View
         */
        public function showLoginForm()
        {
            return view('auth.login');
        }

        /**
         * Handle a login request to the application.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
         *
         * @throws \Illuminate\Validation\ValidationException
         */
        public function login(Request $request)
        {
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            $credentials = [
                'username' => $request->username,
                'password' => $request->password
            ];

            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();
                
                // Check if user is admin and redirect accordingly
                $user = Auth::user();
                if ($user->isAdmin()) {
                    return redirect()->intended('/admin/dashboard');
                }
                
                return redirect()->intended($this->redirectTo);
            }

            throw ValidationException::withMessages([
                'username' => ['These credentials do not match our records.'],
            ]);
        }

        /**
         * Log the user out of the application.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function logout(Request $request)
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect('/');
        }
    }
