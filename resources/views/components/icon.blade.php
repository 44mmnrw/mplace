{{-- Компонент для использования SVG иконок из спрайта --}}
@props([
    'name' => '',
    'class' => '',
    'size' => '24',
])

<svg class="icon {{ $class }}" width="{{ $size }}" height="{{ $size }}">
    <use xlink:href="{{ asset('images/sprite.svg#' . $name) }}"></use>
</svg>
