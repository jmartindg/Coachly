import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('[data-mobile-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');

    if (!toggle || !menu) {
        return;
    }

    const openMenu = () => {
        menu.classList.remove('hidden');
        menu.classList.add('!flex');
        toggle.setAttribute('aria-expanded', 'true');
    };

    const closeMenu = () => {
        menu.classList.add('hidden');
        menu.classList.remove('!flex');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
        const isOpen = menu.classList.contains('!flex') && !menu.classList.contains('hidden');

        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // Reset menu state when viewport is resized to desktop (lg: 1024px)
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            menu.classList.remove('hidden', '!flex');
            toggle.setAttribute('aria-expanded', 'false');
        } else {
            closeMenu();
        }
    });
});
