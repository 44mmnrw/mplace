<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Кабинет мастера') - {{ config('app.name', 'РукоДелие') }}</title>
    
    <!-- Styles -->
    @vite(['resources/css/author/app.css', 'resources/js/author/app.js'])
    
    @stack('styles')
</head>
<body class="author-layout">
    @include('author.partials.header')
    @include('author.partials.navigation')
    
    <main class="author-layout__main">
        @yield('content')
    </main>
    
    @include('author.partials.footer')
    
    @stack('scripts')
</body>
</html>
