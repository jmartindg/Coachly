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

document.addEventListener('click', (e) => {
    const container = e.target.closest('[data-workout-edit-container]');
    if (!container) return;

    const viewEl = container.querySelector('[data-workout-view]');
    const editEl = container.querySelector('[data-workout-edit]');

    if (e.target.matches('[data-workout-edit-trigger]')) {
        viewEl.classList.add('hidden');
        editEl.classList.remove('hidden');
        const input = editEl.querySelector('input[name="name"]');
        if (input) {
            input.value = container.dataset.workoutName ?? input.value;
            input.focus();
        }
    } else if (e.target.matches('[data-workout-cancel]')) {
        const input = editEl.querySelector('input[name="name"]');
        if (input) input.value = container.dataset.workoutName ?? input.value;
        viewEl.classList.remove('hidden');
        editEl.classList.add('hidden');
    }
});
