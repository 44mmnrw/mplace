@extends('layouts.app')

@section('title', 'Уютные домашние носки спицами: пошаговый мастер-класс')

@section('content')
<main class="masterclass-detail">
    <div class="container">
        <!-- Breadcrumbs -->
        <nav class="breadcrumbs">
            <a href="/">Главная</a>
            <span>/</span>
            <a href="/catalog">Мастер-классы</a>
            <span>/</span>
            <a href="/catalog?category=knitting">Вязание</a>
            <span>/</span>
            <span>Уютные домашние носки спицами</span>
        </nav>

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

                <!-- Tabs -->
                <div class="masterclass-tabs">
                    <button class="tab active" data-tab="description">Описание</button>
                    <button class="tab" data-tab="materials">Материалы</button>
                    <button class="tab" data-tab="level">Уровень</button>
                </div>

                <!-- Tab Content -->
                <div class="tab-content active" id="description">
                    <h3>Описание</h3>
                    <p>Этот мастер-класс создан для всех, кто хочет освоить технику вязания уютных домашних носков. Подробные пошаговые инструкции помогут вам создать идеальную пару даже с нуля.</p>
                    <p>В мастер-классе вы узнаете о выборе пряжи, расчёте петель на любой размер, технике вязания пятки «бумеранг» и красивой отделке мыска. Все этапы сопровождаются фотографиями и схемами.</p>
                    
                    <h4>Формат обучения</h4>
                    <p>PDF-файл с инструкциями, который вы можете скачать сразу после покупки. Документ содержит 24 страницы с пошаговыми фото и схемами.</p>
                </div>

                <div class="tab-content" id="materials">
                    <h3>Материалы</h3>
                    <ul class="materials-list">
                        <li>Пряжа для носков (75% шерсть, 25% полиамид) — 100 г</li>
                        <li>Спицы чулочные №2.5 или №3 — комплект 5 шт.</li>
                        <li>Маркеры для вязания — 4 шт.</li>
                        <li>Игла для сшивания трикотажа</li>
                    </ul>
                </div>

                <div class="tab-content" id="level">
                    <h3>Уровень</h3>
                    <div class="level-badge">Начинающий</div>
                    <p class="level-subtitle">Подходит для новичков</p>
                    <p>Мастер-класс подходит для начинающих вязальщиц, которые уже освоили базовые петли: лицевые и изнаночные. Все сложные моменты подробно объясняются с фотографиями.</p>
                    
                    <h4>Что нужно уметь:</h4>
                    <ul>
                        <li>Набирать петли на спицы</li>
                        <li>Вязать лицевые и изнаночные петли</li>
                        <li>Закрывать петли</li>
                    </ul>
                </div>

                <!-- Share -->
                <div class="masterclass-share">
                    <span>Поделиться:</span>
                    <div class="share-buttons">
                        <button class="share-btn" title="VK">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M15.07 2H8.93C3.33 2 2 3.33 2 8.93v6.14C2 20.67 3.33 22 8.93 22h6.14c5.6 0 6.93-1.33 6.93-6.93V8.93C22 3.33 20.67 2 15.07 2zm3.15 14.59c-.34.87-1.23 1.55-2.29 1.76-.62.13-1.42.2-2.63.2-1.37 0-2.16-.09-2.8-.24-1.06-.25-1.92-.98-2.24-1.9-.15-.41-.19-.79-.19-1.42V11c0-.63.04-1 .19-1.41.32-.92 1.18-1.65 2.24-1.9.64-.15 1.43-.24 2.8-.24 1.21 0 2.01.07 2.63.2 1.06.21 1.95.89 2.29 1.76.12.3.16.67.16 1.41v1.98c0 .74-.04 1.11-.16 1.41z"/>
                            </svg>
                        </button>
                        <button class="share-btn" title="Telegram">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/>
                            </svg>
                        </button>
                        <button class="share-btn" title="WhatsApp">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </button>
                        <button class="share-btn" title="Pinterest">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/>
                            </svg>
                        </button>
                        <button class="share-btn share-link" title="Копировать ссылку">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>

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
                    <button class="btn-primary btn-leave-review">Оставить отзыв</button>
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
                    <p class="purchase-subtitle">Научитесь вязать тёплые и красивые носки для себя и близких. Подходит для начинающих.</p>

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

                    <a href="#" class="author-link">Магазин мастера</a>

                    <!-- Price -->
                    <div class="purchase-price">
                        <div class="price-current">400 ₽</div>
                        <div class="price-old">550 ₽</div>
                        <div class="price-discount">-27%</div>
                    </div>

                    <p class="purchase-format">Цифровой мастер-класс (PDF), мгновенная загрузка</p>

                    <!-- Buttons -->
                    <button class="btn-primary btn-buy-now">Купить в 1 клик</button>
                    <button class="btn-secondary btn-add-to-cart">В корзину</button>

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
