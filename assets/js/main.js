/**
 * Main JavaScript file for MPE2025 theme
 */

document.addEventListener('DOMContentLoaded', function () {
    // Scroll to Top Button
    const scrollToTopBtn = document.getElementById('scroll-to-top');

    if (scrollToTopBtn) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        });

        // Scroll to top when button is clicked
        scrollToTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Mobile Menu Toggle
    const menuToggle = document.getElementById('menu-toggle');
    const siteNavigation = document.getElementById('site-navigation');
    const body = document.body;

    if (menuToggle && siteNavigation) {
        menuToggle.addEventListener('click', function () {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', !isExpanded);

            menuToggle.classList.toggle('active');
            siteNavigation.classList.toggle('active');
            body.classList.toggle('menu-open');

            // Lock body scroll
            if (body.classList.contains('menu-open')) {
                body.style.overflow = 'hidden';
            } else {
                body.style.overflow = '';
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (event) {
            if (!siteNavigation.contains(event.target) && !menuToggle.contains(event.target) && siteNavigation.classList.contains('active')) {
                menuToggle.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                siteNavigation.classList.remove('active');
                body.classList.remove('menu-open');
                body.style.overflow = '';
            }
        });

        // Close menu when clicking a link
        const menuLinks = siteNavigation.querySelectorAll('a');
        menuLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                // Don't close if it's a parent item toggle on mobile
                if (window.innerWidth <= 1024 && link.parentElement.classList.contains('menu-item-has-children')) {
                    return;
                }

                menuToggle.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                siteNavigation.classList.remove('active');
                body.classList.remove('menu-open');
                body.style.overflow = '';
            });
        });

        // Mobile Submenu Toggle
        const menuItemsWithChildren = siteNavigation.querySelectorAll('.menu-item-has-children');
        menuItemsWithChildren.forEach(function (item) {
            const link = item.querySelector('a');
            const submenu = item.querySelector('.sub-menu');

            if (link && submenu) {
                link.addEventListener('click', function (e) {
                    if (window.innerWidth <= 1024) {
                        e.preventDefault();
                        item.classList.toggle('active');
                        submenu.classList.toggle('active');
                    }
                });
            }
        });
    }
});
