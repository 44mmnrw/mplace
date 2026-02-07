import '../shared/bootstrap';

// Gallery image switching with thumbnail support
document.addEventListener('DOMContentLoaded', () => {
    const galleryMain = document.querySelector('.gallery-main');
    const thumbnails = document.querySelectorAll('.gallery-thumbs .thumb');

    if (!galleryMain || thumbnails.length === 0) return;

    thumbnails.forEach((thumb) => {
        thumb.addEventListener('click', (e) => {
            // Только левой кнопкой - предотвращаем переход по ссылке
            if (e.button === 0) {
                e.preventDefault();
            } else {
                // Правая кнопка или другое - разрешаем переход (открыть в новой вкладке)
                return;
            }

            // Get full-resolution image URL from data attribute
            let srcToSet = thumb.getAttribute('data-full-src');
            
            if (!srcToSet) {
                const thumbImg = thumb.querySelector('img');
                if (!thumbImg) return;
                srcToSet = thumbImg.getAttribute('src');
            }

            if (!srcToSet) return;

            // Find or create img in main gallery
            let mainImg = galleryMain.querySelector('img');
            if (!mainImg) {
                // If no img found, remove any existing lottie or other elements and create img
                galleryMain.innerHTML = '';
                mainImg = document.createElement('img');
                mainImg.style.width = '100%';
                mainImg.style.height = '100%';
                mainImg.style.objectFit = 'cover';
                mainImg.style.borderRadius = '12px';
                galleryMain.appendChild(mainImg);
            }

            // Update main image with full-resolution version
            mainImg.setAttribute('src', srcToSet);
            mainImg.setAttribute('alt', thumb.getAttribute('aria-label') || 'Gallery image');

            // Update active state
            thumbnails.forEach((t) => t.classList.remove('active'));
            thumb.classList.add('active');
        });
    });
});

