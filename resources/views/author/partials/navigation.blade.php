{{-- Author Navigation --}}
<nav class="author-nav">
    <div class="author-nav__container">
        <a href="{{ route('author.dashboard') }}" class="author-nav__item @if(Route::is('author.dashboard')) active @endif">
            <svg class="author-nav__icon" viewBox="0 0 16 16" fill="none">
                <rect x="2" y="3" width="12" height="10" rx="1" stroke="currentColor" stroke-width="1.5"/>
                <path d="M2 6H14" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            <span>Дашборд</span>
        </a>

        <a href="{{ route('author.masterclasses.index') }}" class="author-nav__item @if(Route::is('author.masterclasses.*')) active @endif">
            <svg class="author-nav__icon" viewBox="0 0 16 16" fill="none">
                <rect x="3" y="4" width="10" height="8" rx="1" stroke="currentColor" stroke-width="1.5"/>
                <path d="M3 7H13" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            <span>Мастер-классы</span>
        </a>

        <a href="#" class="author-nav__item">
            <svg class="author-nav__icon" viewBox="0 0 16 16" fill="none">
                <circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1.5"/>
                <path d="M8 5V8L10 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <span>Витрина</span>
        </a>

        <a href="#" class="author-nav__item">
            <svg class="author-nav__icon" viewBox="0 0 16 16" fill="none">
                <path d="M2 3H14C14.55 3 15 3.45 15 4V12C15 12.55 14.55 13 14 13H2C1.45 13 1 12.55 1 12V4C1 3.45 1.45 3 2 3Z" stroke="currentColor" stroke-width="1.5"/>
                <path d="M1 5H15" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            <span>Вышивка</span>
        </a>

        <a href="#" class="author-nav__item">
            <svg class="author-nav__icon" viewBox="0 0 16 16" fill="none">
                <path d="M8 2L10.5 7H15L11.5 10L13 15L8 12L3 15L4.5 10L1 7H5.5L8 2Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
            </svg>
            <span>Скрапбукинг</span>
        </a>

        <a href="#" class="author-nav__item">
            <svg class="author-nav__icon" viewBox="0 0 16 16" fill="none">
                <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.5"/>
                <path d="M8 5V8M8 11V12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <span>Декор</span>
        </a>

        <a href="#" class="author-nav__item">
            <svg class="author-nav__icon" viewBox="0 0 16 16" fill="none">
                <path d="M3 2H13C14.1 2 15 2.9 15 4V12C15 13.1 14.1 14 13 14H3C1.9 14 1 13.1 1 12V4C1 2.9 1.9 2 3 2Z" stroke="currentColor" stroke-width="1.5"/>
                <path d="M5 7L8 10L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Украшения</span>
        </a>

        <a href="#" class="author-nav__item">
            <svg class="author-nav__icon" viewBox="0 0 16 16" fill="none">
                <path d="M2.5 3H13.5C14.3284 3 15 3.67157 15 4.5V11.5C15 12.3284 14.3284 13 13.5 13H2.5C1.67157 13 1 12.3284 1 11.5V4.5C1 3.67157 1.67157 3 2.5 3Z" stroke="currentColor" stroke-width="1.5"/>
                <path d="M3 5.5H13" stroke="currentColor" stroke-width="1.5"/>
            </svg>
            <span>Популярное</span>
        </a>
    </div>
</nav>

