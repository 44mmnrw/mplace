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
                
                <div class="form-group">
                    <div class="gallery-header">
                        <label class="form-label">Изображения мастер-класса *</label>
                        <span class="gallery-counter" id="gallery-counter">
                            @php
                                $totalCount = $isEdit ? $product->images()->count() : 0;
                            @endphp
                            <span id="current-count">{{ $totalCount }}</span> из 8
                        </span>
                    </div>
                    <p class="form-hint" style="margin-bottom: 15px;">Перетащите файлы или нажмите "Добавить". Первое изображение — главное. Меняйте порядок перетаскиванием</p>
                    
                    <div class="gallery-grid" id="gallery-grid">
                        @if($isEdit)
                            @foreach($product->images()->orderBy('is_main', 'desc')->orderBy('sort_order')->get() as $image)
                            <div class="gallery-item" data-image-id="{{ $image->id }}" draggable="true">
                                <x-product-image :src="$image->image_url" alt="Gallery image" />
                                @if($image->is_main)
                                    <span class="image-badge">Главное</span>
                                @endif
                                <button type="button" class="image-remove" onclick="removeGalleryImage({{ $image->id }})">×</button>
                            </div>
                            @endforeach
                        @endif
                        
                        <label for="gallery-images-input" class="gallery-item gallery-item--add" style="cursor: pointer;" id="gallery-add-btn">
                            <input type="file" id="gallery-images-input" name="gallery_images[]" accept="image/jpeg,image/jpg,image/png,image/webp" multiple style="display: none;" onchange="previewGalleryImages(event)">
                            <x-icon name="icon-plus" class="gallery-item__icon" size="32" />
                            <span class="gallery-item__text">Добавить</span>
                        </label>
                    </div>
                    @error('gallery_images')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    @error('gallery_images.*')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                    
                    {{-- Hidden inputs for deleted images --}}
                    <div id="deleted-images-container"></div>
                    
                    {{-- Hidden input for images order --}}
                    <input type="hidden" name="images_order" id="images-order" value="">
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
let galleryFiles = {};
let galleryFileIdCounter = 0;
let draggedElement = null;

// Initialize drag and drop on page load
document.addEventListener('DOMContentLoaded', function() {
    initDragAndDrop();
    updateMainBadge();
});

// File upload drag and drop
function initDragAndDrop() {
    const grid = document.getElementById('gallery-grid');
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        grid.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    // Highlight drop area
    ['dragenter', 'dragover'].forEach(eventName => {
        grid.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        grid.addEventListener(eventName, unhighlight, false);
    });
    
    // Handle dropped files
    grid.addEventListener('drop', handleDrop, false);
}

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight(e) {
    // Показываем подсказку только если перетаскиваются файлы, а не элементы страницы
    if (e.dataTransfer.types.includes('Files')) {
        const grid = document.getElementById('gallery-grid');
        grid.classList.add('gallery-grid--drag-over');
    }
}

function unhighlight(e) {
    const grid = document.getElementById('gallery-grid');
    grid.classList.remove('gallery-grid--drag-over');
}

function handleDrop(e) {
    const grid = document.getElementById('gallery-grid');
    grid.classList.remove('gallery-grid--drag-over');
    
    const dt = e.dataTransfer;
    const files = dt.files;
    
    if (files.length > 0) {
        handleFiles(files);
    }
}

function handleFiles(files) {
    const fileArray = Array.from(files);
    const grid = document.getElementById('gallery-grid');
    const addButton = grid.querySelector('.gallery-item--add');
    
    fileArray.forEach((file) => {
        // Check if file is image
        if (!file.type.startsWith('image/')) {
            alert('Можно загружать только изображения');
            return;
        }
        
        // Check total limit
        const currentCount = grid.querySelectorAll('.gallery-item:not(.gallery-item--add)').length;
        if (currentCount >= 8) {
            alert('Максимум 8 изображений');
            return;
        }
        
        const fileId = galleryFileIdCounter++;
        galleryFiles[fileId] = file;
        
        const isFirst = currentCount === 0;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('div');
            preview.className = 'gallery-item gallery-item--new';
            preview.dataset.fileId = fileId;
            preview.draggable = true;
            preview.innerHTML = `
                <img src="${e.target.result}" alt="New image">
                ${isFirst ? '<span class="image-badge">Главное</span>' : ''}
                <button type="button" class="image-remove" onclick="removeNewGalleryImage(this)">×</button>
            `;
            
            // Add drag event listeners
            addDragListeners(preview);
            
            grid.insertBefore(preview, addButton);
            updateGalleryCounter();
            updateMainBadge();
        };
        reader.readAsDataURL(file);
    });
    
    updateGalleryFileInput();
}

function previewGalleryImages(event) {
    handleFiles(event.target.files);
    event.target.value = '';
}

function removeGalleryImage(imageId) {
    if (!confirm('Удалить это изображение?')) return;
    
    const container = document.getElementById('deleted-images-container');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'delete_images[]';
    input.value = imageId;
    container.appendChild(input);
    
    const item = document.querySelector(`[data-image-id="${imageId}"]`);
    if (item) {
        item.remove();
        updateGalleryCounter();
        updateMainBadge();
        updateImagesOrder();
    }
}

function removeNewGalleryImage(button) {
    const item = button.parentElement;
    const fileId = item.dataset.fileId;
    
    if (fileId !== undefined) {
        delete galleryFiles[fileId];
        updateGalleryFileInput();
    }
    
    item.remove();
    updateGalleryCounter();
    updateMainBadge();
}

// Drag and drop for reordering
function addDragListeners(element) {
    element.addEventListener('dragstart', handleDragStart);
    element.addEventListener('dragend', handleDragEnd);
    element.addEventListener('dragover', handleDragOver);
    element.addEventListener('drop', handleDropReorder);
    element.addEventListener('dragenter', handleDragEnter);
    element.addEventListener('dragleave', handleDragLeave);
}

function handleDragStart(e) {
    draggedElement = this;
    this.classList.add('dragging');
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragEnd(e) {
    this.classList.remove('dragging');
    
    const grid = document.getElementById('gallery-grid');
    grid.classList.remove('gallery-grid--drag-over');
    
    const items = document.querySelectorAll('.gallery-item:not(.gallery-item--add)');
    items.forEach(item => item.classList.remove('drag-over'));
    
    updateMainBadge();
    updateImagesOrder();
}

function handleDragOver(e) {
    if (e.preventDefault) {
        e.preventDefault();
    }
    e.dataTransfer.dropEffect = 'move';
    return false;
}

function handleDragEnter(e) {
    if (this.classList.contains('gallery-item--add')) return;
    this.classList.add('drag-over');
}

function handleDragLeave(e) {
    this.classList.remove('drag-over');
}

function handleDropReorder(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    
    const grid = document.getElementById('gallery-grid');
    grid.classList.remove('gallery-grid--drag-over');
    
    if (this.classList.contains('gallery-item--add')) return;
    
    if (draggedElement !== this) {
        const allItems = [...grid.querySelectorAll('.gallery-item:not(.gallery-item--add)')];
        const draggedIndex = allItems.indexOf(draggedElement);
        const targetIndex = allItems.indexOf(this);
        
        if (draggedIndex < targetIndex) {
            this.parentNode.insertBefore(draggedElement, this.nextSibling);
        } else {
            this.parentNode.insertBefore(draggedElement, this);
        }
    }
    
    this.classList.remove('drag-over');
    return false;
}

// Update "Главное" badge on first image
function updateMainBadge() {
    const grid = document.getElementById('gallery-grid');
    const items = grid.querySelectorAll('.gallery-item:not(.gallery-item--add)');
    
    items.forEach((item, index) => {
        const existingBadge = item.querySelector('.image-badge');
        if (existingBadge) {
            existingBadge.remove();
        }
        
        if (index === 0) {
            const badge = document.createElement('span');
            badge.className = 'image-badge';
            badge.textContent = 'Главное';
            item.insertBefore(badge, item.firstChild);
        }
    });
}

// Update hidden input with images order
function updateImagesOrder() {
    const grid = document.getElementById('gallery-grid');
    const items = grid.querySelectorAll('.gallery-item:not(.gallery-item--add)');
    const order = [];
    
    items.forEach((item) => {
        const imageId = item.dataset.imageId;
        if (imageId) {
            order.push(parseInt(imageId));
        }
    });
    
    document.getElementById('images-order').value = JSON.stringify(order);
}

// Add drag listeners to existing images on load
document.addEventListener('DOMContentLoaded', function() {
    const existingItems = document.querySelectorAll('.gallery-item[data-image-id]');
    existingItems.forEach(addDragListeners);
});

function updateGalleryFileInput() {
    const input = document.getElementById('gallery-images-input');
    const dataTransfer = new DataTransfer();
    
    // Add all files from object to DataTransfer
    Object.values(galleryFiles).forEach(file => {
        dataTransfer.items.add(file);
    });
    
    input.files = dataTransfer.files;
}

function updateGalleryCounter() {
    const grid = document.getElementById('gallery-grid');
    const count = grid.querySelectorAll('.gallery-item:not(.gallery-item--add)').length;
    document.getElementById('current-count').textContent = count;
}

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

