@extends('layouts.app')

@section('title', 'Каталог мастер-классов')

@section('content')
<div class="catalog-page">
    <!-- Шапка каталога -->
    <div class="catalog-header">
        <div class="catalog-header-top">
            <div class="catalog-title-block">
                <h1 class="catalog-title">Каталог мастер-классов</h1>
                <p class="catalog-subtitle">Найдено {{ $products->total() }} {{ trans_choice('мастер-класс|мастер-класса|мастер-классов', $products->total()) }}</p>
            </div>
            <div class="catalog-sort">
                <span class="sort-label">Сортировка:</span>
                <div class="sort-select">
                    <select name="sort" onchange="this.form.submit()" form="filterForm">
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>По популярности</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Дешевле</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Дороже</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>По рейтингу</option>
                    </select>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M4 6L8 10L12 6" stroke="#3D3935" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="catalog-controls">
            <button class="btn-filters" id="toggleFilters">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M2 4h12M4 8h8M6 12h4" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Фильтры
            </button>
        </div>
    </div>

    <!-- Основной контент: сайдбар + карточки -->
    <div class="catalog-content">
        <!-- Сайдбар с фильтрами -->
        <x-front.catalog-filters :difficultyLevels="$difficultyLevels" />

        <!-- Карточки мастер-классов -->
        <div class="catalog-cards" id="catalogCards">
            <div class="cards-grid">
                @forelse($products as $product)
                <a href="{{ route('masterclass.show', $product->id) }}" class="class-card-link">
                    <div class="class-card">
                        <div class="card-image" style="position: relative; width: 100%; aspect-ratio: 4/3; overflow: hidden; border-radius: 12px; background: #edf2f5;">
                            @if($product->mainImage)
                                <x-product-image :src="$product->mainImage->image_url" :alt="$product->title" style="width: 100%; height: 100%; object-fit: cover;" />
                            @else
                                <x-product-image src="placeholder:lottie" :alt="$product->title" style="width: 100%; height: 100%;" />
                            @endif
                            <div class="card-badges">
                                @if($product->activePrice && $product->activePrice->old_price)
                                    @php
                                        $discount = round((($product->activePrice->old_price - $product->activePrice->price) / $product->activePrice->old_price) * 100);
                                    @endphp
                                    <span class="badge badge-discount">−{{ $discount }}%</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-author">
                                <div class="author-avatar"></div>
                                <span>{{ $product->author->name ?? 'Автор' }}</span>
                            </div>
                            <h3 class="card-title">{{ $product->title }}</h3>
                            <div class="card-meta">
                                @if($product->difficultyLevel)
                                <span class="meta-item">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <path d="M7 1L9 5l4 1-3 3 1 4-4-2-4 2 1-4-3-3 4-1 2-4z" stroke="#7A726D" stroke-width="1.5" stroke-linejoin="round"/>
                                    </svg>
                                    {{ $product->difficultyLevel->name }}
                                </span>
                                @endif
                            </div>
                            <div class="card-footer">
                                @if($product->rating > 0)
                                <div class="card-rating">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 1l2 4 4 1-3 3 1 4-4-2-4 2 1-4-3-3 4-1 2-4z" fill="#EF6461"/>
                                    </svg>
                                    <span class="rating-value">{{ number_format($product->rating, 1) }}</span>
                                    <span class="rating-count">({{ $product->reviews_count }})</span>
                                </div>
                                @endif
                                @if($product->activePrice)
                                <div class="card-price">
                                    @if($product->activePrice->old_price)
                                        <span class="price-old">{{ number_format($product->activePrice->old_price, 0, ',', ' ') }} ₽</span>
                                    @endif
                                    <span class="price-current">{{ number_format($product->activePrice->price, 0, ',', ' ') }} ₽</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                    <h3 style="color: #7A726D; margin-bottom: 12px;">Мастер-классы не найдены</h3>
                    <p style="color: #9ca3af;">Попробуйте изменить параметры фильтрации</p>
                </div>
                @endforelse
            </div>

            <!-- Пагинация -->
            @if($products->hasPages())
            <div class="catalog-pagination">
                @if($products->onFirstPage())
                    <button class="pagination-btn" disabled>Назад</button>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="pagination-btn">Назад</a>
                @endif

                @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="pagination-btn {{ $page == $products->currentPage() ? 'pagination-active' : '' }}">{{ $page }}</a>
                @endforeach

                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="pagination-btn">Далее</a>
                @else
                    <button class="pagination-btn" disabled>Далее</button>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleFilters');
    const sidebar = document.getElementById('filtersSidebar');
    const catalogContent = document.querySelector('.catalog-content');
    
    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('active');
        catalogContent.classList.toggle('with-sidebar');
    });
});
</script>
@endsection
