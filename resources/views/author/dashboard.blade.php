@extends('layouts.author')

@section('title', 'Мои мастер-классы')

@section('content')
<div class="author-dashboard">
    {{-- Page Header --}}
    <div class="dashboard-header">
        <div class="dashboard-header__text">
            <h1 class="dashboard-header__title">Дашборд</h1>
            <p class="dashboard-header__subtitle">Управляйте продажами, мастер-классами и отслеживайте статистику</p>
        </div>       
    </div>

    {{-- Stats Cards --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card__header">
                <span class="stat-card__label">Доход</span>
                <svg class="stat-card__icon" viewBox="0 0 16 16" fill="none">
                    <path d="M8 14C11.3137 14 14 11.3137 14 8C14 4.68629 11.3137 2 8 2C4.68629 2 2 4.68629 2 8C2 11.3137 4.68629 14 8 14Z" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M8 5V8L10 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="stat-card__content">
                <div class="stat-card__value">78 100 ₽</div>
                <div class="stat-card__description">За все время</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card__header">
                <span class="stat-card__label">Продажи</span>
                <svg class="stat-card__icon" viewBox="0 0 16 16" fill="none">
                    <path d="M2 6L8 2L14 6V13C14 13.5523 13.5523 14 13 14H3C2.44772 14 2 13.5523 2 13V6Z" stroke="currentColor" stroke-width="1.5"/>
                </svg>
            </div>
            <div class="stat-card__content">
                <div class="stat-card__value">145</div>
                <div class="stat-card__description">Всего покупок</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card__header">
                <span class="stat-card__label">Просмотры</span>
                <svg class="stat-card__icon" viewBox="0 0 16 16" fill="none">
                    <path d="M1 8C1 8 3.5 3 8 3C12.5 3 15 8 15 8C15 8 12.5 13 8 13C3.5 13 1 8 1 8Z" stroke="currentColor" stroke-width="1.5"/>
                    <circle cx="8" cy="8" r="2.5" stroke="currentColor" stroke-width="1.5"/>
                </svg>
            </div>
            <div class="stat-card__content">
                <div class="stat-card__value">2 135</div>
                <div class="stat-card__description">За все время</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card__header">
                <span class="stat-card__label">Курсы</span>
                <svg class="stat-card__icon" viewBox="0 0 16 16" fill="none">
                    <rect x="2" y="3" width="12" height="10" rx="1" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M2 6H14" stroke="currentColor" stroke-width="1.5"/>
                </svg>
            </div>
            <div class="stat-card__content">
                <div class="stat-card__value">2</div>
                <div class="stat-card__description">Опубликовано из 3</div>
            </div>
        </div>
    </div>

    {{-- Quick Access Cards --}}
    <div class="quick-access">
        <h2>Быстрый доступ</h2>
        <div class="quick-access-grid">
            <a href="#" class="quick-access-card">
                <div class="quick-access-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3V21M21 3V21M3 9H21M3 15H21M7 3V21M11 3V21M15 3V21M19 3V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="quick-access-content">
                    <h3>Аналитика</h3>
                    <p>Детальная статистика продаж</p>
                </div>
            </a>

            <a href="#" class="quick-access-card">
                <div class="quick-access-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 21H4C2.9 21 2 20.1 2 19V5C2 3.9 2.9 3 4 3H20C21.1 3 22 3.9 22 5V19C22 20.1 21.1 21 20 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2 7H22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="quick-access-content">
                    <h3>Отзывы</h3>
                    <p>Модерация и ответы на отзывы</p>
                </div>
            </a>

            <a href="#" class="quick-access-card">
                <div class="quick-access-icon">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="1" fill="currentColor"/>
                        <circle cx="19" cy="12" r="1" fill="currentColor"/>
                        <circle cx="5" cy="12" r="1" fill="currentColor"/>
                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2Z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <div class="quick-access-content">
                    <h3>Настройки</h3>
                    <p>Профиль и выплаты</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

