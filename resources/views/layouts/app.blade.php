<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'РукоДелие') }}</title>
    
    <!-- Styles -->
    @vite(['resources/css/front/app.css', 'resources/js/front/app.js'])
    
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest"></script>
    
    @stack('styles')
</head>
<body>
    @include('front.partials.header')
    
    <main class="main-content">
        @yield('content')
    </main>
    
    @include('front.partials.footer')
    
    @stack('scripts')
</body>
</html>