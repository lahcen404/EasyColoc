<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EasyColoc') }}</title>
    <!-- Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-brand-soft text-brand-dark">

    <!-- 1. Global Header  -->
    @include('partials.header')

    <!-- 2. Main Content Wrapper -->
    <div class="min-h-screen flex flex-col">
        <main class="flex-1 py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Flash Notifications (Success/Error) -->
                @if(session('success'))
                    <div class="mb-8 p-4 bg-emerald-50 border-l-4 border-emerald-400 text-emerald-800 rounded-r-xl shadow-sm flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        <span class="text-xs font-black uppercase tracking-wide">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-8 p-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-xl shadow-sm flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                        <span class="text-xs font-black uppercase tracking-wide">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Dynamic Page Content -->
                @yield('content')

            </div>
        </main>

        <!-- 3. Global Footer -->
        @include('partials.footer')
    </div>
</body>
</html>
