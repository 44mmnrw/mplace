@extends('layouts.author')

@section('title', 'Мастер-классы')

@section('content')
<div class="author-dashboard">
    {{-- Page Header --}}
    <div class="dashboard-header">
        <div class="dashboard-header__text">
            <h1 class="dashboard-header__title">Мои мастер-классы</h1>
            <p class="dashboard-header__subtitle">Управляйте мастер-классами и отслеживайте статистику</p>
        </div>
        <a href="{{ route('author.masterclasses.create') }}" class="btn btn-primary">
            <svg class="btn__icon" viewBox="0 0 16 16" fill="none">
                <path d="M8 3.5V12.5M3.5 8H12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            Создать мастер-класс
        </a>
    </div>

    {{-- Masterclass List --}}
    <div class="masterclass-list">
        <div class="list-header">
            <div class="list-filters">
                <select class="filter-select">
                    <option>Все статусы</option>
                    <option>Опубликованные</option>
                    <option>Черновики</option>
                    <option>Архивированные</option>
                </select>
                <input type="text" class="filter-input" placeholder="Поиск...">
            </div>
        </div>

        <div class="masterclass-table">
            @if($products->count() > 0)
            <table>
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Статус</th>
                    <th>Продажи</th>
                    <th>Доход</th>
                    <th>Просмотры</th>
                    <th>Рейтинг</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="masterclass-row">
                    <td>
                        <div class="masterclass-info">
                            <div class="masterclass-thumb-wrapper">
                                @if($product->mainImage)
                                    <x-product-image :src="$product->mainImage->image_url" :alt="$product->title" class="masterclass-thumb" />
                                @else
                                    <x-product-image src="placeholder:lottie" alt="Изображение" class="masterclass-thumb" />
                                @endif
                            </div>
                            <div>
                                <div class="masterclass-name">{{ $product->title }}</div>
                                <div class="masterclass-category">{{ $product->primaryCategory->name ?? 'Категория не указана' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($product->status === 'published')
                        <span class="badge badge-success">Опубликован</span>
                        @elseif($product->status === 'draft')
                        <span class="badge badge-draft">Черновик</span>
                        @elseif($product->status === 'archived')
                        <span class="badge badge-archived">Архивирован</span>
                        @endif
                    </td>
                    <td>{{ $product->sales_count ?? 0 }}</td>
                    <td>
                        @if($product->activePrice && $product->sales_count > 0)
                            {{ number_format($product->activePrice->price * $product->sales_count, 0, ',', ' ') }} ₽
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $product->views_count ?? 0 }}</td>
                    <td>
                        @if($product->rating > 0)
                        <div class="rating-cell">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <span>{{ number_format($product->rating, 1) }}</span>
                        </div>
                        @else
                        <span>-</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('author.masterclasses.edit', $product->id) }}" class="btn-icon" title="Редактировать">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('author.masterclasses.destroy', $product->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Удалить" onclick="return confirm('Вы уверены?')">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        <line x1="10" y1="11" x2="10" y2="17"/>
                                        <line x1="14" y1="11" x2="14" y2="17"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
            @else
            <div style="padding: 40px; text-align: center; color: #999;">
                <p>У вас пока нет мастер-классов</p>
                <a href="{{ route('author.masterclasses.create') }}" class="btn btn-primary" style="margin-top: 20px;">
                    Создать первый мастер-класс
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
