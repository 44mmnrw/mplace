@extends('layouts.app')

@section('title', 'Каталог мастер-классов')

@section('content')
<div class="catalog-page">
    <!-- Шапка каталога -->
    <div class="catalog-header">
        <div class="catalog-header-top">
            <div class="catalog-title-block">
                <h1 class="catalog-title">Каталог мастер-классов</h1>
                <p class="catalog-subtitle">Найдено 16 мастер-классов</p>
            </div>
            <div class="catalog-sort">
                <span class="sort-label">Сортировка:</span>
                <div class="sort-select">
                    <span>По популярности</span>
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
    <div class="catalog-content" id="catalogContent">
        <!-- Сайдбар с фильтрами -->
        <aside class="catalog-sidebar" id="filtersSidebar">
            <div class="filters-container">
                <div class="filters-header">
                    <h3>Фильтры</h3>
                </div>

                <!-- Уровень сложности -->
                <div class="filter-group">
                    <h4 class="filter-title">Уровень сложности</h4>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="level" value="beginner">
                        <span class="checkbox-custom"></span>
                        <span>Новичок</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="level" value="intermediate">
                        <span class="checkbox-custom"></span>
                        <span>Продолжающий</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="level" value="advanced">
                        <span class="checkbox-custom"></span>
                        <span>Продвинутый</span>
                    </label>
                </div>

                <!-- Формат -->
                <div class="filter-group">
                    <h4 class="filter-title">Формат</h4>
                    <div class="filter-buttons-grid">
                        <button class="filter-btn">🎥 Видео</button>
                        <button class="filter-btn">📄 PDF</button>
                        <button class="filter-btn">📦 Видео + PDF</button>
                        <button class="filter-btn">🔴 Живой онлайн</button>
                    </div>
                </div>

                <!-- Тема -->
                <div class="filter-group">
                    <h4 class="filter-title">Тема</h4>
                    <div class="filter-buttons-grid theme-grid">
                        <button class="filter-btn">🧶 Вязание</button>
                        <button class="filter-btn">🪡 Шитьё</button>
                        <button class="filter-btn">✂️ Скрапбукинг</button>
                        <button class="filter-btn">🧵 Вышивка</button>
                        <button class="filter-btn">🎨 Декор</button>
                        <button class="filter-btn">💎 Украшения</button>
                    </div>
                </div>

                <!-- Цена -->
                <div class="filter-group">
                    <h4 class="filter-title">Цена</h4>
                    <div class="price-slider">
                        <div class="slider-track"></div>
                        <input type="range" min="0" max="2000" value="0" class="slider-input slider-min">
                        <input type="range" min="0" max="2000" value="2000" class="slider-input slider-max">
                    </div>
                    <div class="price-labels">
                        <span>от 0 ₽</span>
                        <span>до 2000 ₽</span>
                    </div>
                    <div class="price-quick-buttons">
                        <button class="filter-btn">До 500 ₽</button>
                        <button class="filter-btn">500-1000 ₽</button>
                        <button class="filter-btn">1000-1500 ₽</button>
                        <button class="filter-btn">1500+ ₽</button>
                    </div>
                </div>

                <!-- Дополнительно -->
                <div class="filter-group">
                    <h4 class="filter-title">Дополнительно</h4>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="feedback" value="yes">
                        <span class="checkbox-custom"></span>
                        <span>С обратной связью</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="discount" value="yes">
                        <span class="checkbox-custom"></span>
                        <span>Со скидкой</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" name="hits" value="yes">
                        <span class="checkbox-custom"></span>
                        <span>Хиты продаж</span>
                    </label>
                </div>

                <button class="btn-reset-filters">Сбросить фильтры</button>
            </div>
        </aside>

        <!-- Карточки мастер-классов -->
        <div class="catalog-cards" id="catalogCards">
            <div class="cards-grid">
                <!-- Карточка 1 -->
                <a href="#" class="class-card-link">
                    <div class="class-card">
                        <div class="card-image">
                            <div class="card-badges">
                                <span class="badge badge-hit">Хит</span>
                                <span class="badge badge-discount">−40%</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-author">
                                <div class="author-avatar"></div>
                                <span>Мария Ковалёва</span>
                            </div>
                            <h3 class="card-title">Вяжем плюшевого мишку амигуруми</h3>
                            <div class="card-meta">
                                <span class="meta-item">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <circle cx="7" cy="7" r="6" stroke="#7A726D" stroke-width="1.5"/>
                                        <path d="M7 3.5v3.5l2.5 2.5" stroke="#7A726D" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    4 часа
                                </span>
                                <span class="meta-item">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <path d="M7 1L9 5l4 1-3 3 1 4-4-2-4 2 1-4-3-3 4-1 2-4z" stroke="#7A726D" stroke-width="1.5" stroke-linejoin="round"/>
                                    </svg>
                                    Для новичков
                                </span>
                            </div>
                            <div class="card-footer">
                                <div class="card-rating">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 1l2 4 4 1-3 3 1 4-4-2-4 2 1-4-3-3 4-1 2-4z" fill="#EF6461"/>
                                    </svg>
                                    <span class="rating-value">4.9</span>
                                    <span class="rating-count">(234)</span>
                                </div>
                                <div class="card-price">
                                    <span class="price-old">1490 ₽</span>
                                    <span class="price-current">890 ₽</span>
                                </div>
                            </div>
                            <div class="card-tags">
                                <span class="tag">С обратной связью</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Карточка 2 -->
                <a href="#" class="class-card-link">
                    <div class="class-card">
                        <div class="card-image">
                            <div class="card-badges">
                                <span class="badge badge-new">Новинка</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-author">
                                <div class="author-avatar"></div>
                                <span>Анна Петрова</span>
                            </div>
                            <h3 class="card-title">Создаём авторскую открытку с объёмными цветами</h3>
                            <div class="card-meta">
                                <span class="meta-item">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <circle cx="7" cy="7" r="6" stroke="#7A726D" stroke-width="1.5"/>
                                        <path d="M7 3.5v3.5l2.5 2.5" stroke="#7A726D" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    2.5 часа
                                </span>
                                <span class="meta-item">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <path d="M7 1L9 5l4 1-3 3 1 4-4-2-4 2 1-4-3-3 4-1 2-4z" stroke="#7A726D" stroke-width="1.5" stroke-linejoin="round"/>
                                    </svg>
                                    Средний
                                </span>
                            </div>
                            <div class="card-footer">
                                <div class="card-rating">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 1l2 4 4 1-3 3 1 4-4-2-4 2 1-4-3-3 4-1 2-4z" fill="#EF6461"/>
                                    </svg>
                                    <span class="rating-value">4.8</span>
                                    <span class="rating-count">(156)</span>
                                </div>
                                <div class="card-price">
                                    <span class="price-current">690 ₽</span>
                                </div>
                            </div>
                            <div class="card-tags">
                                <span class="tag">С обратной связью</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Карточка 3 -->
                <a href="#" class="class-card-link">
                    <div class="class-card">
                        <div class="card-image">
                            <div class="card-badges"></div>
                        </div>
                        <div class="card-content">
                            <div class="card-author">
                                <div class="author-avatar"></div>
                                <span>Елена Соколова</span>
                            </div>
                            <h3 class="card-title">Текстильная кукла-тильда: мастер-класс</h3>
                            <div class="card-meta">
                                <span class="meta-item">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <circle cx="7" cy="7" r="6" stroke="#7A726D" stroke-width="1.5"/>
                                        <path d="M7 3.5v3.5l2.5 2.5" stroke="#7A726D" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    6 часов
                                </span>
                                <span class="meta-item">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <path d="M7 1L9 5l4 1-3 3 1 4-4-2-4 2 1-4-3-3 4-1 2-4z" stroke="#7A726D" stroke-width="1.5" stroke-linejoin="round"/>
                                    </svg>
                                    Средний
                                </span>
                            </div>
                            <div class="card-footer">
                                <div class="card-rating">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 1l2 4 4 1-3 3 1 4-4-2-4 2 1-4-3-3 4-1 2-4z" fill="#EF6461"/>
                                    </svg>
                                    <span class="rating-value">5</span>
                                    <span class="rating-count">(98)</span>
                                </div>
                                <div class="card-price">
                                    <span class="price-current">1290 ₽</span>
                                </div>
                            </div>
                            <div class="card-tags">
                                <span class="tag">С обратной связью</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Карточка 4 -->
                <a href="#" class="class-card-link">
                    <div class="class-card">
                        <div class="card-image">
                            <div class="card-badges">
                                <span class="badge badge-discount">−29%</span>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-author">
                                <div class="author-avatar"></div>
                                <span>Ольга Новикова</span>
                            </div>
                            <h3 class="card-title">Объёмная вышивка лентами: картина "Пионы"</h3>
                            <div class="card-meta">
                                <span class="meta-item">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <circle cx="7" cy="7" r="6" stroke="#7A726D" stroke-width="1.5"/>
                                        <path d="M7 3.5v3.5l2.5 2.5" stroke="#7A726D" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    5 часов
                                </span>
                                <span class="meta-item">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <path d="M7 1L9 5l4 1-3 3 1 4-4-2-4 2 1-4-3-3 4-1 2-4z" stroke="#7A726D" stroke-width="1.5" stroke-linejoin="round"/>
                                    </svg>
                                    Продвинутый
                                </span>
                            </div>
                            <div class="card-footer">
                                <div class="card-rating">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 1l2 4 4 1-3 3 1 4-4-2-4 2 1-4-3-3 4-1 2-4z" fill="#EF6461"/>
                                    </svg>
                                    <span class="rating-value">4.9</span>
                                    <span class="rating-count">(187)</span>
                                </div>
                                <div class="card-price">
                                    <span class="price-old">1390 ₽</span>
                                    <span class="price-current">990 ₽</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Пагинация -->
            <div class="catalog-pagination">
                <button class="pagination-btn">Назад</button>
                <button class="pagination-btn pagination-active">1</button>
                <button class="pagination-btn">2</button>
                <button class="pagination-btn">3</button>
                <button class="pagination-btn">Далее</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleFilters');
    const sidebar = document.getElementById('filtersSidebar');
    const catalogContent = document.getElementById('catalogContent');
    
    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('active');
        catalogContent.classList.toggle('with-sidebar');
    });
});
</script>
@endsection
