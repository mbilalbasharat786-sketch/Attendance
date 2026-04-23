<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - HR Portal</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen relative overflow-hidden selection:bg-indigo-500 selection:text-white py-10">

    <div class="absolute top-0 left-0 w-full h-72 bg-indigo-600 shadow-lg" style="border-bottom-left-radius: 50% 15%; border-bottom-right-radius: 50% 15%;"></div>

    <div class="relative z-10 bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md border border-slate-100">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 mb-4 shadow-sm border border-indigo-100">
                <i class="fa-solid fa-user-plus text-3xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Create an Account</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium">Join the portal to manage your attendance and tasks</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1" for="name">Full Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-regular fa-user text-slate-400"></i>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 transition duration-150 text-sm font-medium" placeholder="John Doe">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-600 font-semibold" />
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1" for="email">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-regular fa-envelope text-slate-400"></i>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 transition duration-150 text-sm font-medium" placeholder="student@example.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600 font-semibold" />
            </div>

            <div class="grid grid-cols-1 gap-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1" for="password">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-slate-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 transition duration-150 text-sm font-medium" placeholder="••••••••">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600 font-semibold" />
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1" for="password_confirmation">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-shield-halved text-slate-400"></i>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 transition duration-150 text-sm font-medium" placeholder="••••••••">
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-600 font-semibold" />
                </div>
            </div>

            <div class="flex items-center justify-between mt-6 pt-4 border-t border-slate-100">
                <a href="{{ route('login') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition underline hover:no-underline">
                    Already registered?
                </a>
                <button type="submit" class="bg-indigo-600 text-white font-bold py-2.5 px-6 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition duration-150 shadow-md flex items-center">
                    <i class="fa-solid fa-user-check mr-2"></i> Register Now
                </button>
            </div>
        </form>
        
    </div>

</body>
</html>
