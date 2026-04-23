<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Authentication - HR Portal</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen relative overflow-hidden selection:bg-indigo-500 selection:text-white">

    <div class="absolute top-0 left-0 w-full h-64 bg-indigo-600 shadow-lg" style="border-bottom-left-radius: 50% 20%; border-bottom-right-radius: 50% 20%;"></div>

    <div class="relative z-10 bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md border border-slate-100">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 mb-4 shadow-sm border border-indigo-100">
                <i class="fa-solid fa-user-shield text-3xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Admin Portal</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium">Sign in to manage the attendance system</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6 flex items-start">
                <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5 mr-3"></i>
                <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-regular fa-envelope text-slate-400"></i>
                    </div>
                    <input type="email" name="email" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 transition duration-150 text-sm font-medium" required placeholder="admin@company.com">
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1">
                    <label class="block text-sm font-bold text-slate-700">Password</label>
                    <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-500 transition">Forgot password?</a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-slate-400"></i>
                    </div>
                    <input type="password" name="password" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50 transition duration-150 text-sm font-medium" required placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition duration-150 shadow-md flex items-center justify-center mt-4">
                <i class="fa-solid fa-right-to-bracket mr-2"></i> Secure Login
            </button>
        </form>
        
        <div class="mt-8 text-center border-t border-slate-100 pt-6">
            <a href="{{ url('/') }}" class="text-sm font-bold text-slate-500 hover:text-slate-800 transition flex items-center justify-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Student Portal
            </a>
        </div>
    </div>

</body>
</html>