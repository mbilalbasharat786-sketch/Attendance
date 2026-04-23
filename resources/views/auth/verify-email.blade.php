<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email - HR Portal</title>
    
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
        
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 mb-4 shadow-sm border border-indigo-100">
                <i class="fa-solid fa-envelope-circle-check text-3xl"></i>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Verify Your Email</h2>
        </div>

        <div class="mb-6 text-sm text-slate-500 text-center font-medium leading-relaxed">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg mb-6 flex items-start shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 mr-3"></i>
                <p class="text-sm text-emerald-700 font-medium">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </p>
            </div>
        @endif

        <div class="mt-8 flex flex-col space-y-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition duration-150 shadow-md flex items-center justify-center">
                    <i class="fa-solid fa-paper-plane mr-2"></i> {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center border-t border-slate-100 pt-5">
                @csrf
                <button type="submit" class="text-sm font-bold text-slate-500 hover:text-red-600 transition flex items-center justify-center w-full">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> {{ __('Log Out') }}
                </button>
            </form>
        </div>
        
    </div>

</body>
</html>
