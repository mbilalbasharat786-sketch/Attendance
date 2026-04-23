<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Login - HR Portal</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen relative overflow-hidden selection:bg-indigo-500 selection:text-white">

    <div class="absolute top-0 left-0 w-full h-64 bg-indigo-600 shadow-lg" style="border-bottom-left-radius: 50% 20%; border-bottom-right-radius: 50% 20%;"></div>

    <div class="relative z-10 bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md border border-slate-100 mt-10 mb-10">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 mb-4 shadow-sm border border-indigo-100">
                <i class="fa-solid fa-user-graduate text-3xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Student Portal</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium">Sign in to access your dashboard & tasks</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1" for="email">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-regular fa-envelope text-slate-400"></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 transition duration-150 text-sm font-medium" placeholder="student@example.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600 font-semibold" />
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-sm font-bold text-slate-700" for="password">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-500 transition">Forgot password?</a>
                    @endif
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-400"></i>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 transition duration-150 text-sm font-medium" placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600 font-semibold" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 bg-slate-50 w-4 h-4" name="remember">
                    <span class="ms-2 text-sm font-medium text-slate-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition duration-150 shadow-md flex items-center justify-center mt-2">
                <i class="fa-solid fa-right-to-bracket mr-2"></i> Log in
            </button>
        </form>
        
        @if (Route::has('register'))
            <div class="mt-8 text-center border-t border-slate-100 pt-6">
                <p class="text-sm text-slate-500 font-medium">New to the system? 
                    <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition">Create an account</a>
                </p>
            </div>
        @endif
    </div>

</body>
</html>
