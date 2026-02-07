@extends('layouts.app')

@section('title', $product->title)

@section('content')
<main class="masterclass-detail">
    <div class="container">
        <!-- Breadcrumbs with Share -->
        <div class="breadcrumbs-wrapper">
            <nav class="breadcrumbs">
                <a href="{{ route('home') }}">Главная</a>
                <span>/</span>
                <a href="{{ route('catalog') }}">Мастер-классы</a>
                @if($product->primaryCategory)
                <span>/</span>
                <a href="{{ route('catalog', ['category' => $product->primaryCategory->slug]) }}">{{ $product->primaryCategory->name }}</a>
                @endif
                <span>/</span>
                <span>{{ $product->title }}</span>
            </nav>
            <span class="share-label">Поделиться</span>
        </div>

        <!-- Main Content Grid -->
        <div class="masterclass-grid">
            <!-- Left Column: Gallery + Content -->
            <div class="masterclass-main">
                <!-- Gallery -->
                <div class="masterclass-gallery">
                    <div class="gallery-main">
                        @if($product->mainImage)
                            <x-product-image :src="$product->mainImage->getThumbnailUrl('large')" :alt="$product->title" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;" />
                        @else
                            <x-product-image src="placeholder:lottie" :alt="$product->title" style="width: 100%; height: 100%;" />
                        @endif
                    </div>
                    @if($product->images->count() > 0)
                    <div class="gallery-thumbs">
                        @foreach($product->images as $index => $image)
                        <a href="{{ asset('storage/' . $image->getThumbnailUrl('thumb')) }}" class="thumb {{ $index === 0 ? 'active' : '' }}" data-full-src="{{ asset('storage/' . $image->getThumbnailUrl('large')) }}" data-medium-src="{{ asset('storage/' . $image->getThumbnailUrl('medium')) }}" target="_blank" rel="noopener">
                            <x-product-image :src="$image->getThumbnailUrl('thumb')" :alt="$product->title . ' - превью ' . ($index + 1)" style="width: 100%; height: 100%; object-fit: cover;" />
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Description Section -->
                <section class="masterclass-description">
                    <h2>Описание</h2>
                    {!! nl2br(e($product->description)) !!}
                    
                    @if($product->requirements)
                    <h3>Формат обучения</h3>
                    <p>{{ $product->requirements }}</p>
                    @endif
                </section>

                <!-- Materials Section -->
                @if($product->materials)
                <section class="masterclass-materials">
                    <h2>Необходимые материалы</h2>
                    <div class="materials-grid">
                        @foreach(explode("\n", $product->materials) as $material)
                            @if(trim($material))
                            <div class="material-item">
                                <svg class="material-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.5"/>
                                    <circle cx="10" cy="10" r="3" fill="currentColor"/>
                                </svg>
                                <span>{{ trim($material) }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="materials-tip">
                        <p><span class="tip-icon">💡</span> <strong>Совет:</strong> Все материалы можно приобрести в магазинах для рукоделия или заказать онлайн. Список с рекомендациями доступен после покупки мастер-класса.</p>
                    </div>
                </section>
                @endif

                <!-- Other Classes by Author -->
                @if($authorClasses->count() > 0)
                <section class="author-classes">
                    <h2>Другие мастер-классы автора</h2>
                    <div class="author-classes-grid">
                        @foreach($authorClasses as $class)
                        <a href="{{ route('masterclass.show', $class->id) }}" class="author-class-card">
                            <div class="class-image">
                                @if($class->mainImage)
                                    <x-product-image :src="$class->mainImage->getThumbnailUrl('medium')" :alt="$class->title" style="width: 100%; height: 100%; object-fit: cover;" />
                                @else
                                    <x-product-image src="placeholder:lottie" :alt="$class->title" style="width: 100%; height: 100%;" />
                                @endif
                            </div>
                            <div class="class-info">
                                <h3>{{ $class->title }}</h3>
                                @if($class->activePrice)
                                <p class="price">{{ number_format($class->activePrice->price, 0, ',', ' ') }} ₽</p>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                </section>
                @endif

                <!-- Reviews -->
                <section class="masterclass-reviews">
                    <div class="reviews-header">
                        <h2>Отзывы о мастер-классе</h2>
                        <div class="reviews-rating">
                            <span class="rating-value">{{ number_format($product->rating, 1) }}</span>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                @endfor
                            </div>
                            <span class="reviews-count">{{ $product->reviews_count }} {{ trans_choice('отзыв|отзыва|отзывов', $product->reviews_count) }}</span>
                        </div>
                    </div>

                    <div class="reviews-list">
                        @foreach($product->reviews as $review)
                        <div class="review-card">
                            <div class="review-header">
                                <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->first_name) }}" alt="{{ $review->user->first_name }}" class="review-avatar">
                                <div class="review-author">
                                    <h4>{{ $review->user->first_name }} {{ mb_substr($review->user->last_name, 0, 1) }}.</h4>
                                    <div class="review-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke-width="{{ $i <= $review->rating ? 0 : 2 }}"/>
                                        </svg>
                                        @endfor
                                    </div>
                                </div>
                                <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="review-text">{{ $review->review_text }}</p>
                        </div>
                        @endforeach
                    </div>

                    @if($product->reviews_count > 5)
                    <button class="btn-show-more">Показать ещё</button>
                    @endif
                    <button class="btn btn-primary btn-leave-review">Оставить отзыв</button>
                </section>

                <!-- Similar Classes -->
                @if($similarClasses->count() > 0)
                <section class="similar-classes">
                    <h2>Похожие мастер-классы</h2>
                    <div class="similar-classes-grid">
                        @foreach($similarClasses as $similar)
                        <a href="{{ route('masterclass.show', $similar->id) }}" class="class-card">
                            <div class="class-card-image">
                                @if($similar->mainImage)
                                    <x-product-image :src="$similar->mainImage->getThumbnailUrl('medium')" :alt="$similar->title" style="width: 100%; height: 100%; object-fit: cover;" />
                                @else
                                    <x-product-image src="placeholder:lottie" :alt="$similar->title" style="width: 100%; height: 100%;" />
                                @endif
                            </div>
                            <div class="class-card-content">
                                <h3>{{ $similar->title }}</h3>
                                <div class="class-card-author">
                                    <img src="{{ $similar->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($similar->author->display_name) }}" alt="{{ $similar->author->display_name }}">
                                    <span>{{ $similar->author->display_name }}</span>
                                </div>
                                <div class="class-card-meta">
                                    @if($similar->activePrice)
                                    <span class="price">{{ number_format($similar->activePrice->price, 0, ',', ' ') }} ₽</span>
                                    @endif
                                    @if($similar->rating > 0)
                                    <div class="rating">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <span>{{ number_format($similar->rating, 1) }} ({{ $similar->reviews_count }})</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </section>
                @endif
            </div>

            <!-- Right Column: Purchase Card -->
            <aside class="purchase-card">
                <div class="purchase-card-sticky">
                    <!-- Title -->
                    <h1 class="purchase-title">{{ $product->title }}</h1>
                    
                    <!-- Rating -->
                    <div class="purchase-rating">
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="rating-value">{{ number_format($product->rating, 1) }}</span>
                        <span class="rating-count">· {{ $product->reviews_count }} {{ trans_choice('отзыв|отзыва|отзывов', $product->reviews_count) }}</span>
                    </div>

                    <p class="Научите">{{ $product->short_description ?? Str::limit($product->description, 100) }}</p>

                    <!-- Difficulty Level -->
                    @if($product->difficultyLevel)
                    <div class="difficulty-level">
                        <div class="difficulty-header">
                            <div class="difficulty-title">                                
                                <span>Уровень сложности</span>
                            </div>
                            <span class="difficulty-badge">{{ $product->difficultyLevel->name }}</span>
                        </div>
                        <div class="difficulty-progress">
                            @php
                                $levelMap = ['beginner' => 1, 'intermediate' => 3, 'advanced' => 5];
                                $activeLevel = $levelMap[$product->difficultyLevel->slug] ?? 3;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <div class="difficulty-bar {{ $i <= $activeLevel ? 'active' : '' }}"></div>
                            @endfor
                        </div>
                        <p class="difficulty-description">{{ $product->difficultyLevel->description ?? 'Для тех, кто уже имеет базовый опыт в рукоделии' }}</p>
                    </div>
                    @endif

                    <!-- Author -->
                    @if($product->author)
                    <div class="purchase-author">
                        <img src="{{ $product->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($product->author->display_name) }}" alt="{{ $product->author->display_name }}" class="author-avatar">
                        <div class="author-info">
                            <h3>{{ $product->author->display_name }}</h3>
                            <div class="author-badges">
                                @if($product->author->is_verified)
                                <span class="badge badge-top">Топ-мастер</span>
                                @endif
                                <span class="badge">Мастер</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Price -->
                    @if($product->activePrice)
                    <div class="purchase-price">
                        <div class="price-current">{{ number_format($product->activePrice->price, 0, ',', ' ') }} ₽</div>
                        @if($product->activePrice->old_price)
                            @php
                                $discount = round((($product->activePrice->old_price - $product->activePrice->price) / $product->activePrice->old_price) * 100);
                            @endphp
                            <div class="price-old">{{ number_format($product->activePrice->old_price, 0, ',', ' ') }} ₽</div>
                            <div class="price-discount">-{{ $discount }}%</div>
                        @endif
                    </div>
                    @endif

                    <p class="purchase-format">{{ $product->product_format ?? 'Цифровой мастер-класс (PDF), мгновенная загрузка' }}</p>

                    <!-- Buttons -->
                    <button class="btn btn-primary">Купить в 1 клик</button>
                    <button class="btn btn-secondary">В корзину</button>

                    <!-- Features -->
                    <div class="purchase-features">
                        <div class="feature">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M9 11l3 3L22 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Защита покупки маркетплейсом</span>
                        </div>
                        <div class="feature">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-width="2"/>
                                <path d="M7 11V7a5 5 0 0110 0v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Безопасная оплата</span>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>
@endsection
