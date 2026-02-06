{{-- Author Admin Header --}}
<header class="author-header">
    <div class="author-header__container">
        {{-- Left Side: Logo + Badge --}}
        <div class="author-header__left">
            <a href="{{ route('author.dashboard') }}" class="author-header__logo-link">
                <div class="author-header__logo-icon">
                    <span class="author-header__logo-emoji">✿</span>
                </div>
                <span class="author-header__logo-text">РукоДелие</span>
            </a>
            <span class="author-header__badge">Кабинет мастера</span>
        </div>

        {{-- Right Side: User Menu --}}
        <div class="author-header__right">
            @auth
                <span class="author-header__email">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
            @endauth
            
            <a href="{{ route('author.notifications') }}" class="author-header__icon-btn" title="Уведомления">
                <svg class="author-header__icon" viewBox="0 0 16 16" fill="none">
                    <path d="M8 2C6.34315 2 5 3.34315 5 5V7.58579L3.70711 8.87868C3.42111 9.16468 3.20509 9.5078 3.07612 9.88436C2.94715 10.2609 2.90866 10.6616 2.96349 11.0555C3.01833 11.4494 3.16504 11.8262 3.39289 12.1571C3.62075 12.488 3.92411 12.7643 4.27876 12.9644L4.5 13.0899V13.5C4.5 14.3284 5.17157 15 6 15H10C10.8284 15 11.5 14.3284 11.5 13.5V13.0899L11.7212 12.9644C12.0759 12.7643 12.3793 12.488 12.6071 12.1571C12.835 11.8262 12.9817 11.4494 13.0365 11.0555C13.0913 10.6616 13.0528 10.2609 12.9239 9.88436C12.7949 9.5078 12.5789 9.16468 12.2929 8.87868L11 7.58579V5C11 3.34315 9.65685 2 8 2Z" fill="currentColor"/>
                </svg>
            </a>
            
            <button class="author-header__icon-btn author-header__menu-btn" type="button" title="Меню">
                <svg class="author-header__icon" viewBox="0 0 16 16" fill="none">
                    <path d="M2 4.5C2 4.22386 2.22386 4 2.5 4H13.5C13.7761 4 14 4.22386 14 4.5C14 4.77614 13.7761 5 13.5 5H2.5C2.22386 5 2 4.77614 2 4.5Z" fill="currentColor"/>
                    <path d="M2 8C2 7.72386 2.22386 7.5 2.5 7.5H13.5C13.7761 7.5 14 7.72386 14 8C14 8.27614 13.7761 8.5 13.5 8.5H2.5C2.22386 8.5 2 8.27614 2 8Z" fill="currentColor"/>
                    <path d="M2.5 11C2.22386 11 2 11.2239 2 11.5C2 11.7761 2.22386 12 2.5 12H13.5C13.7761 12 14 11.7761 14 11.5C14 11.2239 13.7761 11 13.5 11H2.5Z" fill="currentColor"/>
                </svg>
            </button>
        </div>
    </div>
</header>
