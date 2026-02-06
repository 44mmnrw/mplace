@extends('layouts.app')

@section('title', 'Уютные домашние носки спицами: пошаговый мастер-класс')

@section('content')
<main class="masterclass-detail">
    <div class="container">
        <!-- Breadcrumbs with Share -->
        <div class="breadcrumbs-wrapper">
            <nav class="breadcrumbs">
                <a href="/">Главная</a>
                <span>/</span>
                <a href="/catalog">Мастер-классы</a>
                <span>/</span>
                <a href="/catalog?category=knitting">Вязание</a>
                <span>/</span>
                <span>Уютные домашние носки спицами</span>
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
                        <img src="https://images.unsplash.com/photo-1582131503261-fca1d1c0589f?w=800&h=600&fit=crop" alt="Мастер-класс">
                    </div>
                    <div class="gallery-thumbs">
                        <button class="thumb active">
                            <img src="https://images.unsplash.com/photo-1582131503261-fca1d1c0589f?w=100&h=100&fit=crop" alt="Превью 1">
                        </button>
                        <button class="thumb">
                            <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=100&h=100&fit=crop" alt="Превью 2">
                        </button>
                        <button class="thumb">
                            <img src="https://images.unsplash.com/photo-1558618047-f4b511ab5f6d?w=100&h=100&fit=crop" alt="Превью 3">
                        </button>
                        <button class="thumb">
                            <img src="https://images.unsplash.com/photo-1452860606245-08befc0ff44b?w=100&h=100&fit=crop" alt="Превью 4">
                        </button>
                        <button class="thumb">
                            <img src="https://images.unsplash.com/photo-1582131503261-fca1d1c0589f?w=100&h=100&fit=crop" alt="Превью 5">
                        </button>
                    </div>
                </div>

                <!-- Description Section -->
                <section class="masterclass-description">
                    <h2>Описание</h2>
                    <p>Этот мастер-класс создан для всех, кто хочет освоить технику вязания уютных домашних носков. Подробные пошаговые инструкции помогут вам создать идеальную пару даже с нуля.</p>
                    <p>В мастер-классе вы узнаете о выборе пряжи, расчёте петель на любой размер, технике вязания пятки «бумеранг» и красивой отделке мыска. Все этапы сопровождаются фотографиями и схемами.</p>
                    
                    <h3>Формат обучения</h3>
                    <p>PDF-файл с инструкциями, который вы можете скачать сразу после покупки. Документ содержит 24 страницы с пошаговыми фото и схемами.</p>
                </section>

                <!-- Materials Section -->
                <section class="masterclass-materials">
                    <h2>Необходимые материалы</h2>
                    <div class="materials-grid">
                        <div class="material-item">
                            <svg class="material-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.5"/>
                                <circle cx="10" cy="10" r="3" fill="currentColor"/>
                            </svg>
                            <span>Пряжа для носков (75% шерсть, 25% полиамид) — 100 г</span>
                        </div>
                        <div class="material-item">
                            <svg class="material-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.5"/>
                                <circle cx="10" cy="10" r="3" fill="currentColor"/>
                            </svg>
                            <span>Спицы чулочные №2.5 или №3</span>
                        </div>
                        <div class="material-item">
                            <svg class="material-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.5"/>
                                <circle cx="10" cy="10" r="3" fill="currentColor"/>
                            </svg>
                            <span>Маркеры для вязания</span>
                        </div>
                        <div class="material-item">
                            <svg class="material-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.5"/>
                                <circle cx="10" cy="10" r="3" fill="currentColor"/>
                            </svg>
                            <span>Игла для сшивания трикотажа</span>
                        </div>
                        <div class="material-item">
                            <svg class="material-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.5"/>
                                <circle cx="10" cy="10" r="3" fill="currentColor"/>
                            </svg>
                            <span>Ножницы</span>
                        </div>
                        <div class="material-item">
                            <svg class="material-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="7" stroke="currentColor" stroke-width="1.5"/>
                                <circle cx="10" cy="10" r="3" fill="currentColor"/>
                            </svg>
                            <span>Сантиметровая лента</span>
                        </div>
                    </div>
                    <div class="materials-tip">
                        <p><span class="tip-icon">💡</span> <strong>Совет:</strong> Все материалы можно приобрести в магазинах для рукоделия или заказать онлайн. Список с рекомендациями доступен после покупки мастер-класса.</p>
                    </div>
                </section>

                <!-- Other Classes by Author -->
                <section class="author-classes">
                    <h2>Другие мастер-классы автора</h2>
                    <div class="author-classes-grid">
                        <a href="#" class="author-class-card">
                            <div class="class-image">
                                <img src="https://images.unsplash.com/photo-1452860606245-08befc0ff44b?w=300&h=200&fit=crop" alt="Варежки с узором">
                            </div>
                            <div class="class-info">
                                <h3>Варежки с узором</h3>
                                <p class="price">350 ₽</p>
                            </div>
                        </a>
                        <a href="#" class="author-class-card">
                            <div class="class-image">
                                <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=300&h=200&fit=crop" alt="Шапка с помпоном">
                            </div>
                            <div class="class-info">
                                <h3>Шапка с помпоном</h3>
                                <p class="price">450 ₽</p>
                            </div>
                        </a>
                        <a href="#" class="author-class-card">
                            <div class="class-image">
                                <img src="https://images.unsplash.com/photo-1558618047-f4b511ab5f6d?w=300&h=200&fit=crop" alt="Снуд в два оборота">
                            </div>
                            <div class="class-info">
                                <h3>Снуд в два оборота</h3>
                                <p class="price">280 ₽</p>
                            </div>
                        </a>
                        <a href="#" class="author-class-card">
                            <div class="class-image">
                                <img src="https://images.unsplash.com/photo-1582131503261-fca1d1c0589f?w=300&h=200&fit=crop" alt="Детские пинетки">
                            </div>
                            <div class="class-info">
                                <h3>Детские пинетки</h3>
                                <p class="price">250 ₽</p>
                            </div>
                        </a>
                    </div>
                </section>

                <!-- Reviews -->
                <section class="masterclass-reviews">
                    <div class="reviews-header">
                        <h2>Отзывы о мастер-классе</h2>
                        <div class="reviews-rating">
                            <span class="rating-value">4.9</span>
                            <div class="stars">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <span class="reviews-count">146 отзывов</span>
                        </div>
                    </div>

                    <div class="reviews-list">
                        <div class="review-card">
                            <div class="review-header">
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=48&h=48&fit=crop&crop=face" alt="Елена К." class="review-avatar">
                                <div class="review-author">
                                    <h4>Елена К.</h4>
                                    <div class="review-stars">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <span class="review-date">15 января</span>
                            </div>
                            <p class="review-text">Отличный мастер-класс! Всё очень подробно объяснено, даже я, новичок в вязании, смогла связать свои первые носки. Спасибо мастеру!</p>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=48&h=48&fit=crop&crop=face" alt="Анна М." class="review-avatar">
                                <div class="review-author">
                                    <h4>Анна М.</h4>
                                    <div class="review-stars">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <span class="review-date">10 января</span>
                            </div>
                            <p class="review-text">Прекрасная инструкция, много фотографий. Пятку освоила с первого раза благодаря понятным схемам.</p>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=48&h=48&fit=crop&crop=face" alt="Ольга В." class="review-avatar">
                                <div class="review-author">
                                    <h4>Ольга В.</h4>
                                    <div class="review-stars">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke-width="2"/>
                                        </svg>
                                    </div>
                                </div>
                                <span class="review-date">5 января</span>
                            </div>
                            <p class="review-text">Хороший мастер-класс, всё понятно. Немного не хватило информации о выборе пряжи, но в целом довольна.</p>
                        </div>
                    </div>

                    <button class="btn-show-more">Показать ещё</button>
                    <button class="btn btn-primary btn-leave-review">Оставить отзыв</button>
                </section>

                <!-- Similar Classes -->
                <section class="similar-classes">
                    <h2>Похожие мастер-классы</h2>
                    <div class="similar-classes-grid">
                        <a href="#" class="class-card">
                            <div class="class-card-image">
                                <img src="https://images.unsplash.com/photo-1582131503261-fca1d1c0589f?w=400&h=300&fit=crop" alt="Вязаный плед">
                            </div>
                            <div class="class-card-content">
                                <h3>Вязаный плед для дома: узор «косы»</h3>
                                <div class="class-card-author">
                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=24&h=24&fit=crop&crop=face" alt="Анна Смирнова">
                                    <span>Анна Смирнова</span>
                                </div>
                                <div class="class-card-meta">
                                    <span class="price">650 ₽</span>
                                    <div class="rating">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <span>4.8 (89)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="class-card">
                            <div class="class-card-image">
                                <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=300&fit=crop" alt="Свитер оверсайз">
                            </div>
                            <div class="class-card-content">
                                <h3>Свитер оверсайз: от замера до готового изделия</h3>
                                <div class="class-card-author">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=24&h=24&fit=crop&crop=face" alt="Екатерина Петрова">
                                    <span>Екатерина Петрова</span>
                                </div>
                                <div class="class-card-meta">
                                    <span class="price">890 ₽</span>
                                    <div class="rating">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <span>5.0 (203)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="class-card">
                            <div class="class-card-image">
                                <img src="https://images.unsplash.com/photo-1558618047-f4b511ab5f6d?w=400&h=300&fit=crop" alt="Детский комбинезон">
                            </div>
                            <div class="class-card-content">
                                <h3>Детский комбинезон спицами</h3>
                                <div class="class-card-author">
                                    <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=24&h=24&fit=crop&crop=face" alt="Мария Иванова">
                                    <span>Мария Иванова</span>
                                </div>
                                <div class="class-card-meta">
                                    <span class="price">520 ₽</span>
                                    <div class="rating">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <span>4.9 (67)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="class-card">
                            <div class="class-card-image">
                                <img src="https://images.unsplash.com/photo-1452860606245-08befc0ff44b?w=400&h=300&fit=crop" alt="Ажурная шаль">
                            </div>
                            <div class="class-card-content">
                                <h3>Ажурная шаль для начинающих</h3>
                                <div class="class-card-author">
                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=24&h=24&fit=crop&crop=face" alt="Ольга Козлова">
                                    <span>Ольга Козлова</span>
                                </div>
                                <div class="class-card-meta">
                                    <span class="price">380 ₽</span>
                                    <div class="rating">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                        <span>4.7 (112)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </section>
            </div>

            <!-- Right Column: Purchase Card -->
            <aside class="purchase-card">
                <div class="purchase-card-sticky">
                    <!-- Title -->
                    <h1 class="purchase-title">Уютные домашние носки спицами: пошаговый мастер-класс</h1>
                    
                    <!-- Rating -->
                    <div class="purchase-rating">
                        <div class="stars">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <span class="rating-value">5.0</span>
                        <span class="rating-count">· 146 отзывов</span>
                    </div>

                    <p class="Научите">Научитесь вязать тёплые и красивые носки для себя и близких. Подходит для начинающих.</p>

                    <!-- Difficulty Level -->
                    <div class="difficulty-level">
                        <div class="difficulty-header">
                            <div class="difficulty-title">                                
                                <span>Уровень сложности</span>
                            </div>
                            <span class="difficulty-badge">Средний</span>
                        </div>
                        <div class="difficulty-progress">
                            <div class="difficulty-bar active"></div>
                            <div class="difficulty-bar active"></div>
                            <div class="difficulty-bar active"></div>
                            <div class="difficulty-bar"></div>
                            <div class="difficulty-bar"></div>
                        </div>
                        <p class="difficulty-description">Для тех, кто уже имеет базовый опыт в рукоделии</p>
                    </div>

                    <!-- Author -->
                    <div class="purchase-author">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop&crop=face" alt="Мария Иванова" class="author-avatar">
                        <div class="author-info">
                            <h3>Мария Иванова</h3>
                            <div class="author-badges">
                                <span class="badge badge-top">Топ-мастер</span>
                                <span class="badge">Мастер</span>
                            </div>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="purchase-price">
                        <div class="price-current">400 ₽</div>
                        <div class="price-old">550 ₽</div>
                        <div class="price-discount">-27%</div>
                    </div>

                    <p class="purchase-format">Цифровой мастер-класс (PDF), мгновенная загрузка</p>

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
