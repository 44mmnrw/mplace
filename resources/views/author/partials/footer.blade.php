{{-- Author Admin Footer --}}
<footer class="author-footer">
    <div class="author-footer__container">
        {{-- Left Side: Logo + Copyright --}}
        <div class="author-footer__left">
            <div class="author-footer__logo-icon">
                <span class="author-footer__logo-emoji">✿</span>
            </div>
            <p class="author-footer__copyright">© 2026 РукоДелие. Все права защищены.</p>
        </div>

        {{-- Right Side: Links --}}
        <nav class="author-footer__nav">
            <a href="{{ route('front.about') ?? '#' }}" class="author-footer__link">О платформе</a>
            <a href="{{ route('front.terms') ?? '#' }}" class="author-footer__link">Условия использования</a>
            <a href="{{ route('front.privacy') ?? '#' }}" class="author-footer__link">Политика конфиденциальности</a>
            <a href="{{ route('front.help') ?? '#' }}" class="author-footer__link">Помощь</a>
        </nav>
    </div>
</footer>
