<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Attendance Portal') }} - Corporate System</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* System-wide premium font configuration */
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    
    <body class="font-sans antialiased text-slate-800 bg-slate-50 selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen flex flex-col">
            
            <div class="sticky top-0 z-50">
                @include('layouts.navigation')
            </div>

            @isset($header)
                <header class="bg-white border-b border-slate-200 shadow-sm">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        <div class="text-xl font-semibold text-slate-800 tracking-tight">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <main class="flex-grow">
                <div class="py-8">
                    {{ $slot }}
                </div>
            </main>
            
            <footer class="bg-white border-t border-slate-200 mt-auto">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-sm text-slate-500 font-medium">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Attendance System') }}. Design & Development by Muhammad Bilal.
                </div>
            </footer>
            
        </div>
    </body>
</html>
