@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <div class="hero-badge">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="currentColor"/>
                        </svg>
                        <span>Более 1000 мастер-классов</span>
                    </div>
                    <h1 class="hero-title">
                        Научитесь создавать красоту <span class="text-accent">своими руками</span>
                    </h1>
                    <p class="hero-description">
                        Онлайн мастер-классы по вязанию, шитью, скрапбукингу и другим видам рукоделия от опытных мастеров. Творите в удобное время!
                    </p>
                    <div class="hero-actions">
                        <a href="{{ route('catalog') }}" class="btn btn-primary">
                            Выбрать мастер-класс
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                        <a href="#how-it-works" class="btn btn-secondary">Как это работает</a>
                    </div>
                    <div class="hero-tags">
                        <p class="hero-tags-title">Популярные запросы:</p>
                        <div class="hero-tags-list">
                            <a href="#" class="tag-link">🧸 Амигуруми</a>
                            <a href="#" class="tag-link">✂️ Скрапбукинг</a>
                            <a href="#" class="tag-link">🧵 Вышивка</a>
                            <a href="#" class="tag-link">🪢 Макраме</a>
                        </div>
                    </div>
                </div>
                <div class="hero-images">
                    <div class="hero-images-col">
                        <div class="hero-image hero-image-1"></div>
                        <div class="hero-image hero-image-2"></div>
                    </div>
                    <div class="hero-images-col hero-images-col-offset">
                        <div class="hero-image hero-image-3"></div>
                        <div class="hero-image hero-image-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Today Section -->
    <section class="section section-popular">
        <div class="container">
            <div class="section-header">
                <div class="section-header-text">
                    <h2 class="section-title">Популярное сегодня</h2>
                    <p class="section-subtitle">Мастер-классы, которые выбирают чаще всего</p>
                </div>
                <a href="{{ route('catalog') }}" class="section-link">
                    Смотреть всё
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            <div class="class-cards-grid">
                @forelse($popularClasses as $product)
                <a href="{{ route('masterclass.show', $product->id) }}" class="class-card">
                    <div class="class-card-image" style="position: relative; width: 100%; aspect-ratio: 4/3; overflow: hidden; background: #edf2f5;">
                        @if($product->mainImage)
                            <x-product-image :src="$product->mainImage->image_url" :alt="$product->title" style="width: 100%; height: 100%; object-fit: cover;" />
                        @else
                            <x-product-image src="placeholder:lottie" :alt="$product->title" style="width: 100%; height: 100%;" />
                        @endif
                        <div class="class-card-badges">
                            @if($product->activePrice && $product->activePrice->old_price)
                                @php
                                    $discount = round((($product->activePrice->old_price - $product->activePrice->price) / $product->activePrice->old_price) * 100);
                                @endphp
                                <span class="badge badge-discount">−{{ $discount }}%</span>
                            @endif
                        </div>
                    </div>
                    <div class="class-card-content">
                        <div class="class-card-author">
                            <span class="author-name">{{ $product->author->name ?? 'Автор' }}</span>
                        </div>
                        <h3 class="class-card-title">{{ $product->title }}</h3>
                        <div class="class-card-meta">
                            @if($product->difficultyLevel)
                            <span class="meta-item">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M7 1v12M13 7H1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                {{ $product->difficultyLevel->name }}
                            </span>
                            @endif
                        </div>
                        <div class="class-card-footer">
                            @if($product->rating > 0)
                            <div class="class-card-rating">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <span class="rating-value">{{ number_format($product->rating, 1) }}</span>
                                <span class="rating-count">({{ $product->reviews_count }})</span>
                            </div>
                            @endif
                            @if($product->activePrice)
                            <div class="class-card-price">
                                @if($product->activePrice->old_price)
                                    <span class="price-old">{{ number_format($product->activePrice->old_price, 0, ',', ' ') }} ₽</span>
                                @endif
                                <span class="price-current">{{ number_format($product->activePrice->price, 0, ',', ' ') }} ₽</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </a>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px 20px;">
                    <p style="color: #7A726D;">Пока нет опубликованных мастер-классов</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Collections Section -->
    <section class="section section-collections">
        <div class="container">
            <h2 class="section-title">Подборки мастер-классов</h2>
            <p class="section-subtitle">Тематические коллекции для вашего вдохновения</p>
            <div class="collection-cards-grid">
                <!-- Collection Card 1 -->
                <a href="#" class="collection-card">
                    <div class="collection-card-image">
                        <img src="https://www.figma.com/api/mcp/asset/ae3ef162-b9f2-4bc1-9b49-103c35d121b2" alt="Для новичков">
                        <div class="collection-card-overlay"></div>
                    </div>
                    <div class="collection-card-content">
                        <h3 class="collection-card-title">Для новичков</h3>
                        <p class="collection-card-description">Простые проекты с подробными объяснениями</p>
                    </div>
                    <div class="collection-card-footer">
                        <span class="collection-count">3 мастер-классов</span>
                    </div>
                </a>
                <!-- Collection Card 2 -->
                <a href="#" class="collection-card">
                    <div class="collection-card-image">
                        <img src="https://www.figma.com/api/mcp/asset/8448225c-5588-4f11-9291-1a58b3c53d4f" alt="Вяжем игрушки">
                        <div class="collection-card-overlay"></div>
                    </div>
                    <div class="collection-card-content">
                        <h3 class="collection-card-title">Вяжем игрушки</h3>
                        <p class="collection-card-description">Милые амигуруми и вязаные друзья</p>
                    </div>
                    <div class="collection-card-footer">
                        <span class="collection-count">2 мастер-классов</span>
                    </div>
                </a>
                <!-- Collection Card 3 -->
                <a href="#" class="collection-card">
                    <div class="collection-card-image">
                        <img src="https://www.figma.com/api/mcp/asset/3343fdb0-0893-4a41-992e-5bde54c6db5a" alt="Украшения и аксессуары">
                        <div class="collection-card-overlay"></div>
                    </div>
                    <div class="collection-card-content">
                        <h3 class="collection-card-title">Украшения и аксессуары</h3>
                        <p class="collection-card-description">Создаём стильные украшения своими руками</p>
                    </div>
                    <div class="collection-card-footer">
                        <span class="collection-count">2 мастер-классов</span>
                    </div>
                </a>
                <!-- Collection Card 4 -->
                <a href="#" class="collection-card">
                    <div class="collection-card-image">
                        <img src="https://www.figma.com/api/mcp/asset/afdea7db-9a00-423e-a3c6-23d0e5065fa6" alt="Декор для дома">
                        <div class="collection-card-overlay"></div>
                    </div>
                    <div class="collection-card-content">
                        <h3 class="collection-card-title">Декор для дома</h3>
                        <p class="collection-card-description">Уютные вещи для создания атмосферы</p>
                    </div>
                    <div class="collection-card-footer">
                        <span class="collection-count">2 мастер-классов</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Masters Section -->
    <section class="section section-masters">
        <div class="container">
            <div class="section-header">
                <div class="section-header-text">
                    <h2 class="section-title">Наши мастерицы</h2>
                    <p class="section-subtitle">Опытные авторы, которым доверяют тысячи учеников</p>
                </div>
                <a href="{{ route('masters') }}" class="section-link">
                    Все мастера
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            <div class="master-cards-grid">
                <!-- Master Card 1 -->
                <a href="#" class="master-card">
                    <div class="master-card-avatar-wrapper">
                        <img src="https://www.figma.com/api/mcp/asset/5654ac59-0776-4cf3-93ee-2b073455fc42" alt="Мария Ковалёва" class="master-card-avatar">
                        <div class="master-card-verified">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M5 8l2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="master-card-name">Мария Ковалёва</h3>
                    <p class="master-card-specialty">Вязаные игрушки амигуруми</p>
                    <div class="master-card-stats">
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            24 МК
                        </span>
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M7 4v3h3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            3 420
                        </span>
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 1l1.5 4h4l-3 2.5 1.5 4-4-2.5-4 2.5 1.5-4-3-2.5h4L7 1z" fill="#FFC107"/>
                            </svg>
                            4.9
                        </span>
                    </div>
                </a>
                <!-- Master Card 2 -->
                <a href="#" class="master-card">
                    <div class="master-card-avatar-wrapper">
                        <img src="https://www.figma.com/api/mcp/asset/932705ce-ce4f-46fd-a389-a0d2254882fc" alt="Анна Петрова" class="master-card-avatar">
                        <div class="master-card-verified">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M5 8l2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="master-card-name">Анна Петрова</h3>
                    <p class="master-card-specialty">Скрапбукинг и открытки</p>
                    <div class="master-card-stats">
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            18 МК
                        </span>
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M7 4v3h3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            2 150
                        </span>
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 1l1.5 4h4l-3 2.5 1.5 4-4-2.5-4 2.5 1.5-4-3-2.5h4L7 1z" fill="#FFC107"/>
                            </svg>
                            4.8
                        </span>
                    </div>
                </a>
                <!-- Master Card 3 -->
                <a href="#" class="master-card">
                    <div class="master-card-avatar-wrapper">
                        <img src="https://www.figma.com/api/mcp/asset/f0b8be95-19fe-48b4-ab72-1f17ecb88c12" alt="Елена Соколова" class="master-card-avatar">
                        <div class="master-card-verified">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M5 8l2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="master-card-name">Елена Соколова</h3>
                    <p class="master-card-specialty">Текстильные куклы</p>
                    <div class="master-card-stats">
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            12 МК
                        </span>
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M7 4v3h3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            1 890
                        </span>
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 1l1.5 4h4l-3 2.5 1.5 4-4-2.5-4 2.5 1.5-4-3-2.5h4L7 1z" fill="#FFC107"/>
                            </svg>
                            5
                        </span>
                    </div>
                </a>
                <!-- Master Card 4 -->
                <a href="#" class="master-card">
                    <div class="master-card-avatar-wrapper">
                        <img src="https://www.figma.com/api/mcp/asset/e5e99aac-7b1e-43ff-af40-b9044660bf61" alt="Ольга Новикова" class="master-card-avatar">
                        <div class="master-card-verified">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M5 8l2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="master-card-name">Ольга Новикова</h3>
                    <p class="master-card-specialty">Вышивка и квиллинг</p>
                    <div class="master-card-stats">
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            15 МК
                        </span>
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 5 2.239 5 5-2.239 5-5 5z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M7 4v3h3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            1 620
                        </span>
                        <span class="master-stat">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 1l1.5 4h4l-3 2.5 1.5 4-4-2.5-4 2.5 1.5-4-3-2.5h4L7 1z" fill="#FFC107"/>
                            </svg>
                            4.7
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="section section-reviews">
        <div class="container">
            <div class="section-reviews-header">
                <h2 class="section-title">Что говорят наши ученики</h2>
                <p class="section-subtitle">Реальные отзывы и работы участников мастер-классов</p>
            </div>
            <div class="review-cards-grid">
                <!-- Review Card 1 -->
                <div class="review-card">
                    <div class="review-card-header">
                        <img src="https://www.figma.com/api/mcp/asset/bb5e173f-0e45-4be3-b40e-fd010ef131d5" alt="Светлана К." class="review-avatar">
                        <div class="review-info">
                            <h4 class="review-name">Светлана К.</h4>
                            <div class="review-rating">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                            </div>
                        </div>
                        <span class="review-date">20 января</span>
                    </div>
                    <p class="review-text">
                        Потрясающий мастер-класс! Объяснения чёткие, видео качественное. Связала своего первого мишку, и он получился как с картинки! Спасибо огромное Марии!
                    </p>
                    <div class="review-image">
                        <img src="https://www.figma.com/api/mcp/asset/577d5bc3-c89e-411d-add3-c99b7bb8edc4" alt="Работа ученика">
                    </div>
                </div>
                <!-- Review Card 2 -->
                <div class="review-card">
                    <div class="review-card-header">
                        <img src="https://www.figma.com/api/mcp/asset/997a2da8-bad8-4ac5-81c1-60438f3a7103" alt="Ирина М." class="review-avatar">
                        <div class="review-info">
                            <h4 class="review-name">Ирина М.</h4>
                            <div class="review-rating">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                            </div>
                        </div>
                        <span class="review-date">15 января</span>
                    </div>
                    <p class="review-text">
                        Я никогда не занималась скрапбукингом, но после этого МК влюбилась в это искусство! Открытка вышла восхитительной, подарила маме на день рождения.
                    </p>
                    <div class="review-image">
                        <img src="https://www.figma.com/api/mcp/asset/564269e0-b787-4910-8fed-4f6f364003d8" alt="Работа ученика">
                    </div>
                </div>
                <!-- Review Card 3 -->
                <div class="review-card">
                    <div class="review-card-header">
                        <img src="https://www.figma.com/api/mcp/asset/ea8f4dd9-c7e8-4e0c-8340-09d9a2af8820" alt="Наталья Б." class="review-avatar">
                        <div class="review-info">
                            <h4 class="review-name">Наталья Б.</h4>
                            <div class="review-rating">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="#FFC107"/>
                                </svg>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M8 1l2 5h5l-4 3 2 5-5-3-5 3 2-5-4-3h5l2-5z" fill="rgba(122, 114, 109, 0.3)"/>
                                </svg>
                            </div>
                        </div>
                        <span class="review-date">10 января</span>
                    </div>
                    <p class="review-text">
                        Очень подробный курс, но мне как новичку было немного сложно. Хотелось бы больше примеров разных вариантов оформления. В целом довольна!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section section-cta">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Готовы начать творить?</h2>
                <p class="cta-description">
                    Присоединяйтесь к сообществу творческих людей и научитесь создавать уникальные вещи своими руками
                </p>
                <div class="cta-actions">
                    <a href="{{ route('catalog') }}" class="btn btn-light">Выбрать мастер-класс</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light">Стать автором</a>
                </div>
            </div>
        </div>
    </section>
@endsection
