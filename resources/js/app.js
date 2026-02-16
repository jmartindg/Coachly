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

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('[data-workout-style-form]');

    if (!form) {
        return;
    }

    const escapeHtml = (value) => {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
        };

        return String(value).replace(/[&<>"']/g, (char) => map[char]);
    };

    const setCardPopularState = (card, isPopular) => {
        const badge = card.querySelector('[data-preview-badge]');
        const description = card.querySelector('[data-preview-description]');
        const bullets = card.querySelector('[data-preview-bullets]');
        const hint = card.querySelector('[data-preview-hint]');

        card.classList.toggle('border-emerald-500/70', isPopular);
        card.classList.toggle('bg-slate-900/70', isPopular);
        card.classList.toggle('shadow-lg', isPopular);
        card.classList.toggle('shadow-emerald-500/20', isPopular);

        card.classList.toggle('border-slate-800', !isPopular);
        card.classList.toggle('bg-slate-900/50', !isPopular);

        if (badge) {
            badge.classList.toggle('inline-flex', isPopular);
            badge.classList.toggle('hidden', !isPopular);
        }

        if (description) {
            description.classList.toggle('text-slate-200', isPopular);
            description.classList.toggle('text-slate-300', !isPopular);
        }

        if (bullets) {
            bullets.classList.toggle('text-slate-200', isPopular);
            bullets.classList.toggle('text-slate-300', !isPopular);
        }

        if (hint) {
            hint.classList.toggle('text-slate-200', isPopular);
            hint.classList.toggle('text-slate-400', !isPopular);
        }
    };

    const updatePopularPreview = () => {
        const selectedPopular = form.querySelector('[data-style-popular-radio]:checked')?.value;
        const cards = form.querySelectorAll('[data-preview-style-id]');

        cards.forEach((card) => {
            const isPopular = card.getAttribute('data-preview-style-id') === selectedPopular;
            setCardPopularState(card, isPopular);
        });
    };

    form.addEventListener('input', (event) => {
        const input = event.target.closest('[data-style-input]');
        if (!input) {
            return;
        }

        const styleId = input.getAttribute('data-style-id');
        const field = input.getAttribute('data-style-input');
        const card = form.querySelector(`[data-preview-style-id="${styleId}"]`);

        if (!card || !field) {
            return;
        }

        if (field === 'bullets') {
            const bulletsContainer = card.querySelector('[data-preview-bullets]');
            if (!bulletsContainer) {
                return;
            }

            const bullets = input.value
                .split(/\r\n|\r|\n/)
                .map((line) => line.trim())
                .filter(Boolean);

            bulletsContainer.innerHTML = bullets
                .map((bullet) => `<li>• ${escapeHtml(bullet)}</li>`)
                .join('');
            return;
        }

        const fieldElement = card.querySelector(`[data-preview-field="${field}"]`);
        if (fieldElement) {
            fieldElement.textContent = input.value;
        }
    });

    form.addEventListener('change', (event) => {
        if (event.target.matches('[data-style-popular-radio]')) {
            updatePopularPreview();
        }
    });

    updatePopularPreview();
});
