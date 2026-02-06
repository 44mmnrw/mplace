@extends('layouts.auth')

@section('title', 'Вход для мастеров')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <!-- Logo -->
        <div class="auth-header">
            <div class="auth-icon-wrapper">
                <svg class="auth-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="11" stroke="currentColor" stroke-width="1.5"/>
                    <circle cx="12" cy="8" r="2" fill="currentColor"/>
                    <path d="M10 15c0-1.1.9-2 2-2s2 .9 2 2v2c0 .55.45 1 1 1h2M8 18c-.55 0-1 .45-1 1s.45 1 1 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <!-- Titles -->
            <h1 class="auth-title">Кабинет мастера</h1>
            <p class="auth-subtitle">Войдите, чтобы управлять своими мастер-классами</p>
        </div>

        <!-- Auth Card -->
        <div class="auth-card">
            <!-- Card Header -->
            <div class="auth-card-header">
                <h2 class="auth-card-title">Вход для мастеров</h2>
                <p class="auth-card-description">Введите ваш email для доступа к кабинету</p>
            </div>

            <!-- Card Content -->
            <div class="auth-card-content">
                <!-- Login Form -->
                <form action="{{ route('author.auth.login') }}" method="POST" class="auth-form">
                    @csrf

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="form-input-wrapper">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input @error('email') form-input-error @enderror"
                                placeholder="master@example.com"
                                value="{{ old('email') }}"
                                required
                            >
                            <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16c1.1 0 2 .9 2 2v10c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V8c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M20 8l-8 5-8-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">Пароль</label>
                        <div class="form-input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-input @error('password') form-input-error @enderror"
                                placeholder="Введите пароль"
                                required
                            >
                            <button type="button" class="form-input-toggle" id="passwordToggle">
                                <svg class="form-input-toggle-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M2 12s4.5-6 10-6 10 6 10 6-4.5 6-10 6-10-6-10-6z" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Checkbox -->
                    <div class="form-checkbox">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label for="remember" class="form-checkbox-label">Запомнить меня</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-button">Войти в кабинет</button>
                </form>

                <!-- Sign Up Link -->
                <div class="auth-footer-text">
                    <span class="auth-footer-question">Ещё не мастер?</span>
                    <a href="{{ route('author.auth.register') }}" class="auth-footer-link">Стать автором мастер-классов</a>
                </div>
            </div>
        </div>

        <!-- Back Link -->
        <div class="auth-back-link">
            <a href="{{ route('home') }}">← Вернуться на главную</a>
        </div>
    </div>
</div>

<script>
document.getElementById('passwordToggle')?.addEventListener('click', function() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
});
</script>
@endsection
