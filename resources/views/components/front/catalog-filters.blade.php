@props(['difficultyLevels' => collect()])

<aside class="catalog-sidebar" id="filtersSidebar">
    <form id="filterForm" method="GET" action="{{ route('catalog') }}">
    <div class="filters-container">
        <div class="filters-header">
            <h3>Фильтры</h3>
        </div>

        <!-- Уровень сложности -->
        @if($difficultyLevels->count() > 0)
        <div class="filter-group">
            <h4 class="filter-title">Уровень сложности</h4>
            @foreach($difficultyLevels as $level)
            <label class="filter-checkbox">
                <input type="checkbox" name="level[]" value="{{ $level->slug }}" 
                       {{ in_array($level->slug, request('level', [])) ? 'checked' : '' }}>
                <span class="checkbox-custom"></span>
                <span>{{ $level->name }}</span>
            </label>
            @endforeach
        </div>
        @endif

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
                <input type="checkbox" name="discount" value="yes" {{ request('discount') == 'yes' ? 'checked' : '' }}>
                <span class="checkbox-custom"></span>
                <span>Со скидкой</span>
            </label>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 12px;">Применить</button>
        <a href="{{ route('catalog') }}" class="btn-reset-filters">Сбросить фильтры</a>
    </div>
    </form>
</aside>
