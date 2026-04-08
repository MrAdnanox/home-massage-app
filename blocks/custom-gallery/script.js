document.addEventListener('DOMContentLoaded', function () {
    initCustomGalleries();
});

function initCustomGalleries() {
    var galleries = document.querySelectorAll('.custom-gallery-block');

    galleries.forEach(function (gallery) {
        // Elements
        var links = gallery.querySelectorAll('.gallery-link');
        var lightbox = gallery.querySelector('.custom-gallery-lightbox');
        var lightboxImg = lightbox.querySelector('.lightbox-image');
        var lightboxCaption = lightbox.querySelector('.lightbox-caption');
        var closeBtn = lightbox.querySelector('.lightbox-close');
        var prevBtn = lightbox.querySelector('.lightbox-nav.prev');
        var nextBtn = lightbox.querySelector('.lightbox-nav.next');
        var overlay = lightbox.querySelector('.lightbox-overlay');
        var loader = lightbox.querySelector('.lightbox-loader');

        // State
        var currentIndex = 0;
        var totalImages = links.length;
        var imagesData = [];

        // Collect data
        links.forEach(function (link, index) {
            var dataScript = link.parentElement.querySelector('.img-data');
            if (dataScript) {
                try {
                    imagesData.push(JSON.parse(dataScript.textContent));
                } catch (e) {
                    // Fallback if JSON fails
                    imagesData.push({
                        src: link.getAttribute('href'),
                        alt: link.querySelector('img').alt || '',
                        caption: ''
                    });
                }
            }
        });

        // Functions
        function openLightbox(index) {
            currentIndex = index;
            updateLightboxContent();

            lightbox.setAttribute('aria-hidden', 'false');
            // Small timeout to allow display:flex to apply before opacity transition
            setTimeout(function () {
                lightbox.classList.add('is-open');
            }, 10);

            document.body.style.overflow = 'hidden';
            document.addEventListener('keydown', handleGlobalKeys);
        }

        function closeLightbox() {
            lightbox.classList.remove('is-open');
            setTimeout(function () {
                lightbox.setAttribute('aria-hidden', 'true');
                lightboxImg.src = '';
            }, 300); // Match CSS transition

            document.body.style.overflow = '';
            document.removeEventListener('keydown', handleGlobalKeys);
        }

        function updateLightboxContent() {
            // Show loader
            loader.style.display = 'block';
            lightboxImg.style.opacity = '0.5';

            var data = imagesData[currentIndex];

            // Preload image
            var tmpImg = new Image();
            tmpImg.onload = function () {
                lightboxImg.src = data.src;
                lightboxImg.alt = data.alt;
                loader.style.display = 'none';
                lightboxImg.style.opacity = '1';

                if (data.caption && data.caption.trim() !== '') {
                    lightboxCaption.textContent = data.caption;
                    lightboxCaption.style.display = 'block';
                } else {
                    lightboxCaption.style.display = 'none';
                }
            };
            tmpImg.src = data.src;
        }

        function showNext() {
            currentIndex = (currentIndex + 1) % totalImages;
            updateLightboxContent();
        }

        function showPrev() {
            currentIndex = (currentIndex - 1 + totalImages) % totalImages;
            updateLightboxContent();
        }

        function handleGlobalKeys(e) {
            if (!lightbox.classList.contains('is-open')) return;

            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') showNext();
            if (e.key === 'ArrowLeft') showPrev();
        }

        // Event Listeners
        links.forEach(function (link, index) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                openLightbox(index);
            });
        });

        closeBtn.addEventListener('click', function (e) { e.preventDefault(); closeLightbox(); });
        overlay.addEventListener('click', function (e) { e.preventDefault(); closeLightbox(); });

        nextBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            showNext();
        });

        prevBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            showPrev();
        });
    });
}
