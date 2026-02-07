{{-- Компонент для отображения изображения с поддержкой Lottie-заглушки --}}
@props([
    'src' => '',
    'alt' => 'Image',
    'class' => '',
])

@php
    $isPlaceholder = str_starts_with($src, 'placeholder:');
    $isEmpty = empty($src);
    $isFullUrl = str_starts_with($src, 'http://') || str_starts_with($src, 'https://');
    $imageSrc = ($isEmpty || $isPlaceholder) ? '' : ($isFullUrl ? $src : asset('storage/' . $src));
@endphp

@if($isEmpty || $isPlaceholder)
    <lottie-player 
        src="{{ asset('images/lottie/wired-outline-54-photo-hover-pinch.json') }}"
        background="transparent"
        speed="1"
        class="{{ $class }}"
        loop
        autoplay
        style="width: 100%; height: 100%;"
    ></lottie-player>
@else
    <img src="{{ $imageSrc }}" alt="{{ $alt }}" class="{{ $class }}">
@endif
