@extends('layouts.author')

@section('title', isset($product) ? 'Редактировать мастер-класс' : 'Создать мастер-класс')

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@php
    $isCreate = !isset($product);
    $isEdit = isset($product);
@endphp

<form action="{{ $isEdit ? route('author.masterclasses.update', $product->id) : route('author.masterclasses.store') }}" 
      method="POST" 
      enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

<div class="masterclass-editor">
    <div class="masterclass-editor__container">
        {{-- Left Column: Main Form --}}
        <div class="masterclass-editor__main">
            {{-- Basic Info Section --}}
            <div class="form-section">
                <h2 class="form-section__title">Основная информация</h2>
                
                <div class="form-group">
                    <label class="form-label">Название мастер-класса *</label>
                    <input type="text" name="title" class="form-input" 
                           placeholder="Например: Вязание уютного пледа спицами" 
                           value="{{ old('title', $product->title ?? '') }}"
                           required>
                    @error('title')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Краткое описание *</label>
                    <textarea name="short_description" class="form-textarea" 
                              placeholder="Короткое описание, которое будет отображаться в карточке">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                    @error('short_description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Полное описание *</label>
                    <textarea name="description" class="form-textarea" 
                              placeholder="Подробное описание мастер-класса">{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Images Section --}}
            <div class="form-section">
                <h2 class="form-section__title">Изображения</h2>
                
                {{-- Main Image with Add Button --}}
                <div class="form-group">
                    <label class="form-label">Главное изображение *</label>
                    <div class="images-row">
                        <div class="image-upload-main">
                            <div class="image-upload-main__placeholder"></div>
                        </div>
                        <div class="gallery-item gallery-item--add">
                            <svg class="gallery-item__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            <span class="gallery-item__text">Добавить</span>
                        </div>
                    </div>
                </div>

                {{-- Gallery --}}
                <div class="form-group">
                    <div class="gallery-header">
                        <label class="form-label">Галерея изображений</label>
                        <span class="gallery-counter">3 из 8</span>
                    </div>
                    <div class="gallery-grid">
                        <div class="gallery-item">
                            <img src="https://www.figma.com/api/mcp/asset/21ea8558-e9e9-49ef-a625-5178fc2331d6" alt="Gallery 1">
                        </div>
                        <div class="gallery-item"></div>
                        <div class="gallery-item">
                            <img src="https://www.figma.com/api/mcp/asset/21ea8558-e9e9-49ef-a625-5178fc2331d6" alt="Gallery 2">
                        </div>
                        <div class="gallery-item">
                            <img src="https://www.figma.com/api/mcp/asset/b1936555-1cc6-456b-b798-5819b47f5100" alt="Add image">
                        </div>
                    </div>
                    <p class="form-hint">Добавьте от 3 до 8 изображений работ из мастер-класса</p>
                </div>
            </div>

            {{-- Materials Section --}}
            <div class="form-section">
                <h2 class="form-section__title">Материалы</h2>
                
                <div class="form-group">
                    <label class="form-label">Список материалов *</label>
                    <textarea name="materials_text" class="form-textarea" 
                              placeholder="Например: Пряжа Alize Cotton Gold (цвет белый) — 3 мотка, крючок 3 мм, наполнитель холлофайбер 200 г, бусины для глаз 8 мм — 2 шт">{{ old('materials_text', $isEdit && isset($product->materials['text']) ? $product->materials['text'] : '') }}</textarea>
                    <p class="form-hint">Перечислите все необходимые материалы для выполнения мастер-класса</p>
                    @error('materials_text')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="skills-list" id="skills-list">
                    @php
                        if ($isEdit) {
                            $skills = old('skills', $product->what_you_learn ?? []);
                        } else {
                            $skills = old('skills', []);
                        }
                    @endphp
                    
                    @if(!empty($skills))
                        @foreach($skills as $index => $skill)
                        <div class="skill-item">
                            <svg class="skill-item__icon" viewBox="0 0 16 16" fill="none">
                                <path d="M2 8L6 12L14 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>{{ $skill }}</span>
                            <input type="hidden" name="skills[]" value="{{ $skill }}">
                            <button type="button" class="skill-remove" onclick="removeSkill(this)">×</button>
                        </div>
                        @endforeach
                    @endif
                </div>

                <div class="form-group form-group--inline">
                    <input type="text" id="new-skill-input" class="form-input" placeholder="Добавить навык...">
                    <button type="button" class="btn btn--primary btn--square" onclick="addSkill()">
                        <svg class="btn__icon" viewBox="0 0 16 16" fill="none">
                            <line x1="8" y1="4" x2="8" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <line x1="4" y1="8" x2="12" y2="8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Right Column: Sidebar --}}
        <aside class="masterclass-editor__sidebar">
            {{-- Price Section --}}
            <div class="form-section form-section--compact">
                <h3 class="form-section__title form-section__title--small">Цена</h3>
                
                <div class="form-group">
                    <label class="form-label">Цена *</label>
                    <div class="input-with-suffix">
                        <input type="number" name="price" class="form-input" 
                               value="{{ old('price', $isEdit && $product->activePrice ? $product->activePrice->price : 2990) }}"
                               min="0" step="0.01" required>
                        <span class="input-suffix">₽</span>
                    </div>
                    @error('price')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Старая цена</label>
                    <div class="input-with-suffix">
                        <input type="number" name="old_price" class="form-input" 
                               value="{{ old('old_price', $isEdit && $product->activePrice ? $product->activePrice->old_price : '') }}"
                               min="0" step="0.01">
                        <span class="input-suffix">₽</span>
                    </div>
                    @error('old_price')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Скидка</label>
                    <div class="input-with-suffix">
                        <input type="number" name="discount" class="form-input" 
                               value="{{ old('discount', $isEdit && $product->activePrice ? $product->activePrice->discount_percent : '') }}"
                               min="0" max="100" readonly>
                        <span class="input-suffix">%</span>
                    </div>
                </div>
            </div>

            {{-- Category Section --}}
            <div class="form-section form-section--compact">
                <h3 class="form-section__title form-section__title--small">Категория и параметры</h3>
                
                <div class="form-group">
                    <label class="form-label">Главная категория *</label>
                    <select name="primary_category_id" class="form-select" required>
                        <option value="">Выберите категорию</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ old('primary_category_id', $isEdit ? $product->primary_category_id : '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('primary_category_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Дополнительные категории</label>
                    <div class="checkbox-group">
                        @php
                            $selectedCategories = old('additional_categories', $isEdit ? $product->categories->pluck('id')->toArray() : []);
                        @endphp
                        @foreach($categories as $category)
                        <div class="checkbox-item">
                            <input type="checkbox" 
                                   id="cat-{{ $category->id }}" 
                                   name="additional_categories[]" 
                                   value="{{ $category->id }}"
                                   class="checkbox-input"
                                   {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                            <label for="cat-{{ $category->id }}" class="checkbox-label">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Уровень сложности *</label>
                    <select name="difficulty_level_id" class="form-select">
                        <option value="">Выберите уровень</option>
                        @foreach($difficultyLevels as $level)
                            <option value="{{ $level->id }}" 
                                    {{ old('difficulty_level_id', $isEdit ? $product->difficulty_level_id : '') == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('difficulty_level_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Формат *</label>
                    <select name="format" class="form-select" required>
                        <option value="video" {{ old('format', $isEdit ? $product->format : '') == 'video' ? 'selected' : '' }}>Видео</option>
                        <option value="pdf" {{ old('format', $isEdit ? $product->format : '') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="combined" {{ old('format', $isEdit ? $product->format : '') == 'combined' ? 'selected' : '' }}>Комбинированный</option>
                    </select>
                    @error('format')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Длительность *</label>
                    <div class="form-input form-input--disabled">3 часа 40 минут</div>
                </div>
            </div>

            {{-- Badges Section --}}
            <div class="form-section form-section--compact">
                <h3 class="form-section__title form-section__title--small">Бейджи и опции</h3>
                
                <div class="form-group">
                    <label class="form-label">Бейдж</label>
                    <select name="badge" class="form-select">
                        <option value="">Нет</option>
                        <option value="new" {{ old('badge', $isEdit ? $product->badge ?? '' : '') == 'new' ? 'selected' : '' }}>Новое</option>
                        <option value="bestseller" {{ old('badge', $isEdit ? $product->badge ?? '' : '') == 'bestseller' ? 'selected' : '' }}>Бестселлер</option>
                    </select>
                </div>

                <div class="checkbox-item">
                    <input type="checkbox" id="feedback" name="has_feedback" class="checkbox-input" value="1"
                           {{ old('has_feedback', $isEdit ? $product->has_feedback ?? true : true) ? 'checked' : '' }}>
                    <label for="feedback" class="checkbox-label">С обратной связью</label>
                </div>
            </div>

            {{-- Publication Section --}}
            <div class="form-section form-section--compact form-section--highlight">
                <h3 class="form-section__title form-section__title--small">Публикация</h3>
                
                @if($isEdit)
                    <div class="status-display">
                        <span class="status-display__label">Статус:</span>
                        <span class="status-badge">{{ $product->status === 'published' ? 'Опубликован' : 'Черновик' }}</span>
                    </div>

                    <button type="submit" class="btn btn--secondary btn--full">
                        Сохранить изменения
                    </button>
                    
                    @if($product->status === 'draft')
                    <button type="button" 
                            class="btn btn--primary btn--full"
                            onclick="event.preventDefault(); document.getElementById('publish-form').submit();">
                        Опубликовать
                    </button>
                    @endif
                    
                    <button type="button" 
                            class="btn btn--danger btn--full"
                            onclick="event.preventDefault(); if(confirm('Вы уверены, что хотите удалить мастер-класс?')) { document.getElementById('delete-form').submit(); }">
                        <svg class="btn__icon" viewBox="0 0 16 16" fill="none">
                            <path d="M2 8H14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Удалить
                    </button>
                @else
                    <button type="submit" class="btn btn--primary btn--full">
                        Создать мастер-класс
                    </button>
                @endif
            </div>
        </aside>
    </div>
</div>
</form>

@if($isEdit && $product->status === 'draft')
<form id="publish-form" action="{{ route('author.masterclasses.publish', $product->id) }}" method="POST" style="display: none;">
    @csrf
</form>
@endif

@if($isEdit)
<form id="delete-form" action="{{ route('author.masterclasses.destroy', $product->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endif

@push('scripts')
<script>
function addSkill() {
    const input = document.getElementById('new-skill-input');
    const skillText = input.value.trim();
    
    if (!skillText) {
        return;
    }
    
    const skillsList = document.getElementById('skills-list');
    const skillItem = document.createElement('div');
    skillItem.className = 'skill-item';
    skillItem.innerHTML = `
        <svg class="skill-item__icon" viewBox="0 0 16 16" fill="none">
            <path d="M2 8L6 12L14 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>${skillText}</span>
        <input type="hidden" name="skills[]" value="${skillText}">
        <button type="button" class="skill-remove" onclick="removeSkill(this)">×</button>
    `;
    
    skillsList.appendChild(skillItem);
    input.value = '';
}

function removeSkill(button) {
    button.parentElement.remove();
}

// Add skill on Enter key
document.getElementById('new-skill-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        addSkill();
    }
});

// Auto-calculate discount
const priceInput = document.querySelector('input[name="price"]');
const oldPriceInput = document.querySelector('input[name="old_price"]');
const discountInput = document.querySelector('input[name="discount"]');

function calculateDiscount() {
    const price = parseFloat(priceInput.value) || 0;
    const oldPrice = parseFloat(oldPriceInput.value) || 0;
    
    if (oldPrice > 0 && price > 0 && oldPrice > price) {
        const discount = Math.round(((oldPrice - price) / oldPrice) * 100);
        discountInput.value = discount;
    } else {
        discountInput.value = '';
    }
}

priceInput.addEventListener('input', calculateDiscount);
oldPriceInput.addEventListener('input', calculateDiscount);
</script>
@endpush
@endsection

