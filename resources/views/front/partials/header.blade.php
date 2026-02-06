<!-- Header -->
<header class="header">
    <div class="container">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo-link">
            <div class="logo-icon">✿</div>
            <div class="logo-text">РукоДелие</div>
        </a>
        
        <!-- Search -->
        <div class="search-container">
            <svg class="search-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M17.5 17.5L13.875 13.875M15.8333 9.16667C15.8333 12.8486 12.8486 15.8333 9.16667 15.8333C5.48477 15.8333 2.5 12.8486 2.5 9.16667C2.5 5.48477 5.48477 2.5 9.16667 2.5C12.8486 2.5 15.8333 5.48477 15.8333 9.16667Z" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <input type="text" class="search-input" placeholder="Что вы хотите научиться делать?">
        </div>
        
        <!-- Navigation -->
        <nav class="navigation">
            <a href="{{ url('/catalog') }}" class="nav-link">Каталог</a>
            <a href="{{ url('/masters') }}" class="nav-link">Мастера</a>
            <a href="{{ url('/blog') }}" class="nav-link">Блог</a>
        </nav>
        
        <!-- Actions -->
        <div class="header-actions">
            <!-- Favorites Button -->
            <button class="icon-button" aria-label="Избранное">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M8.00001 13.8667L2.66668 8.53333C1.78168 7.64833 1.33334 6.45333 1.33334 5.2C1.33334 2.692 3.35834 0.666672 5.86668 0.666672C6.98668 0.666672 8.05334 1.08667 8.87334 1.84L8.00001 2.71333L8.87334 1.84C9.69334 1.08667 10.76 0.666672 11.88 0.666672C14.3883 0.666672 16.4133 2.692 16.4133 5.2C16.4133 6.45333 15.965 7.64833 15.08 8.53333L8.00001 13.8667ZM8.00001 13.8667L14.0067 7.86C14.715 7.15167 15.08 6.2 15.08 5.2C15.08 3.428 13.652 2 11.88 2C10.9517 2 10.0517 2.38167 9.38168 3.05167L8.00001 4.43333L6.61834 3.05167C5.94834 2.38167 5.04834 2 4.12001 2C2.34834 2 0.920008 3.428 0.920008 5.2C0.920008 6.2 1.28501 7.15167 1.99334 7.86L8.00001 13.8667Z" fill="currentColor" stroke="currentColor" stroke-width="0.5"/>
                </svg>
            </button>
            
            <!-- Cart Button -->
            <button class="icon-button" aria-label="Корзина">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M1.33334 1.33334H2.66668L3.28001 4.00001M3.28001 4.00001L4.66668 10.6667H12.6667L14.6667 4.00001H3.28001ZM5.33334 14C5.33334 14.3682 5.03487 14.6667 4.66668 14.6667C4.29849 14.6667 4.00001 14.3682 4.00001 14C4.00001 13.6318 4.29849 13.3333 4.66668 13.3333C5.03487 13.3333 5.33334 13.6318 5.33334 14ZM13.3333 14C13.3333 14.3682 13.0349 14.6667 12.6667 14.6667C12.2985 14.6667 12 14.3682 12 14C12 13.6318 12.2985 13.3333 12.6667 13.3333C13.0349 13.3333 13.3333 13.6318 13.3333 14Z" stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <!-- Auth Buttons -->
            <a href="{{ route('author.auth.login') }}" class="btn btn-secondary">Войти</a>
            <a href="{{ route('author.auth.register') }}" class="btn btn-primary">Стать автором</a>
        </div>
    </div>
</header>
