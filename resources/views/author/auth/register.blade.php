@extends('layouts.auth')

@section('title', 'Регистрация мастера')

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
            <h1 class="auth-title">Стать автором</h1>
            <p class="auth-subtitle">Создайте аккаунт для управления мастер-классами</p>
        </div>

        <!-- Auth Card -->
        <div class="auth-card">
            <!-- Card Header -->
            <div class="auth-card-header">
                <h2 class="auth-card-title">Регистрация мастера</h2>
                <p class="auth-card-description">Заполните форму для создания вашего аккаунта</p>
            </div>

            <!-- Card Content -->
            <div class="auth-card-content">
                <!-- Registration Form -->
                <form action="{{ route('author.auth.register.submit') }}" method="POST" class="auth-form">
                    @csrf

                    <!-- First Name Field -->
                    <div class="form-group">
                        <label for="first_name" class="form-label">Имя</label>
                        <div class="form-input-wrapper">
                            <input 
                                type="text" 
                                id="first_name" 
                                name="first_name" 
                                class="form-input @error('first_name') form-input-error @enderror"
                                placeholder="Иван"
                                value="{{ old('first_name') }}"
                                required
                            >
                            <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M4 20c0-3.314 3.58-6 8-6s8 2.686 8 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        @error('first_name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Last Name Field -->
                    <div class="form-group">
                        <label for="last_name" class="form-label">Фамилия</label>
                        <div class="form-input-wrapper">
                            <input 
                                type="text" 
                                id="last_name" 
                                name="last_name" 
                                class="form-input @error('last_name') form-input-error @enderror"
                                placeholder="Петров"
                                value="{{ old('last_name') }}"
                                required
                            >
                            <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M4 20c0-3.314 3.58-6 8-6s8 2.686 8 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        @error('last_name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

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
                                placeholder="Введите пароль (минимум 8 символов)"
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

                    <!-- Password Confirmation Field -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                        <div class="form-input-wrapper">
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="form-input"
                                placeholder="Повторите пароль"
                                required
                            >
                            <button type="button" class="form-input-toggle" id="passwordToggle2">
                                <svg class="form-input-toggle-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M2 12s4.5-6 10-6 10 6 10 6-4.5 6-10 6-10-6-10-6z" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="form-checkbox">
                        <input 
                            type="checkbox" 
                            id="terms" 
                            name="terms"
                            required
                        >
                        <label for="terms" class="form-checkbox-label">
                            Я согласен с <a href="#" class="form-link">условиями использования</a> и <a href="#" class="form-link">политикой конфиденциальности</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-button">Создать аккаунт</button>
                </form>

                <!-- Sign In Link -->
                <div class="auth-footer-text">
                    <span class="auth-footer-question">Уже есть аккаунт?</span>
                    <a href="{{ route('author.auth.login') }}" class="auth-footer-link">Войти в кабинет</a>
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

document.getElementById('passwordToggle2')?.addEventListener('click', function() {
    const input = document.getElementById('password_confirmation');
    input.type = input.type === 'password' ? 'text' : 'password';
});
</script>
@endsection
