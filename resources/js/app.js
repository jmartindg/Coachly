import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('[data-mobile-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');

    if (!toggle || !menu) {
        return;
    }

    const openMenu = () => {
        menu.classList.remove('hidden');
        menu.classList.add('flex');
        toggle.setAttribute('aria-expanded', 'true');
    };

    const closeMenu = () => {
        menu.classList.add('hidden');
        menu.classList.remove('flex');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
        const isOpen = menu.classList.contains('flex') && !menu.classList.contains('hidden');

        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // Close the menu if the viewport is resized to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            closeMenu();
        }
    });
});
