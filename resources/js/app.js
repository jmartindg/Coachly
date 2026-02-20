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

document.addEventListener('DOMContentLoaded', () => {
    const { authUserId, unreadNotificationsCount, notificationReadUrlTemplate, notificationSoundUrl } =
        document.body.dataset;
    const badgeElements = document.querySelectorAll('[data-notification-badge]');
    const triggerElements = document.querySelectorAll('[data-notification-trigger]');
    const panelElement = document.querySelector('[data-notification-panel]');
    const listElement = panelElement?.querySelector('[data-notification-list]');
    const emptyElement = panelElement?.querySelector('[data-notification-empty]');
    const pageListElement = document.querySelector('[data-notification-page-list]');
    const pageEmptyElement = document.querySelector('[data-notification-page-empty]');
    const pagePaginationElement = document.querySelector('[data-notification-page-pagination]');

    const baseTitle = document.title;

    if (!authUserId) {
        return;
    }

    let unreadCount = Number.parseInt(unreadNotificationsCount ?? '0', 10);

    if (Number.isNaN(unreadCount) || unreadCount < 0) {
        unreadCount = 0;
    }

    const updateDocumentTitle = () => {
        if (unreadCount < 1) {
            document.title = baseTitle;
        } else {
            const prefix = unreadCount === 1 ? '1 new notification' : `${unreadCount} new notifications`;
            document.title = `${prefix} - ${baseTitle}`;
        }
    };

    const renderBadges = () => {
        badgeElements.forEach((badgeElement) => {
            badgeElement.classList.toggle('hidden', unreadCount < 1);
        });
        updateDocumentTitle();
    };

    const setTriggersExpanded = (isExpanded) => {
        triggerElements.forEach((triggerElement) => {
            triggerElement.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
        });
    };

    const openPanel = () => {
        panelElement.classList.remove('hidden');
        setTriggersExpanded(true);
    };

    const closePanel = () => {
        panelElement.classList.add('hidden');
        setTriggersExpanded(false);
    };

    const togglePanel = () => {
        if (panelElement.classList.contains('hidden')) {
            openPanel();
            return;
        }

        closePanel();
    };

    const formatTimestamp = (value) => {
        if (!value) {
            return 'Just now';
        }

        const date = new Date(value);
        if (Number.isNaN(date.getTime())) {
            return 'Just now';
        }

        return date.toLocaleString([], {
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
        });
    };

    const markNotificationElementAsRead = (notificationLink) => {
        const unreadDot = notificationLink.querySelector('[data-notification-item-unread]');
        const wasUnread = unreadDot ? !unreadDot.classList.contains('hidden') : false;

        notificationLink.classList.remove('bg-slate-800/30');
        unreadDot?.classList.add('hidden');

        return wasUnread;
    };

    const markNotificationAsRead = async (notificationId, notificationLink) => {
        if (!notificationReadUrlTemplate || !notificationId) {
            return;
        }

        const url = notificationReadUrlTemplate.replace('__ID__', notificationId);

        try {
            const response = await window.axios.post(url);
            const nextUnreadCount = response?.data?.unread_count;

            const wasUnread = markNotificationElementAsRead(notificationLink);

            if (Number.isInteger(nextUnreadCount)) {
                unreadCount = Math.max(0, nextUnreadCount);
            } else if (wasUnread && unreadCount > 0) {
                unreadCount -= 1;
            }

            renderBadges();
        } catch (error) {
            // Keep navigation flowing even if mark-read API fails.
        }
    };

    const prependNotification = (notification) => {
        if (!listElement || !emptyElement) {
            return;
        }

        if (notification?.id && listElement.querySelector(`[data-notification-link][data-notification-id="${notification.id}"]`)) {
            return;
        }

        const item = document.createElement('li');
        item.setAttribute('data-notification-item', '');

        const link = document.createElement('a');
        link.href = notification?.url ?? '#';
        link.dataset.notificationLink = '';
        if (notification?.id) {
            link.dataset.notificationId = notification.id;
        }
        link.className = 'flex items-start gap-3 px-4 py-3 transition-colors hover:bg-slate-800/60 bg-slate-800/30';

        const unreadDot = document.createElement('span');
        unreadDot.setAttribute('data-notification-item-unread', '');
        unreadDot.className = 'mt-1.5 inline-block h-2 w-2 shrink-0 rounded-full bg-emerald-400';

        const content = document.createElement('span');
        content.className = 'min-w-0 flex-1';

        const title = document.createElement('span');
        title.className = 'block text-xs font-semibold text-slate-100';
        title.textContent = notification?.title ?? 'Notification';

        const message = document.createElement('span');
        message.className = 'mt-0.5 block text-xs text-slate-400';
        message.textContent = notification?.message ?? 'You have a new update.';

        const time = document.createElement('span');
        time.className = 'mt-1 block text-[0.65rem] text-slate-500';
        time.textContent = formatTimestamp(notification?.created_at);

        content.append(title, message, time);
        link.append(unreadDot, content);
        item.append(link);

        listElement.prepend(item);
        listElement.classList.remove('hidden');
        emptyElement.classList.add('hidden');

        while (listElement.children.length > 10) {
            listElement.removeChild(listElement.lastElementChild);
        }
    };

    const prependNotificationToPage = (notification) => {
        if (!pageListElement || !pageEmptyElement) {
            return;
        }

        if (notification?.id && pageListElement.querySelector(`[data-notification-link][data-notification-id="${notification.id}"]`)) {
            return;
        }

        const item = document.createElement('li');
        item.setAttribute('data-notification-item', '');
        item.className = 'border-b border-slate-800 last:border-b-0';

        const link = document.createElement('a');
        link.href = notification?.url ?? '#';
        link.dataset.notificationLink = '';
        if (notification?.id) {
            link.dataset.notificationId = notification.id;
        }
        link.className = 'flex items-start gap-3 px-4 py-3 transition-colors hover:bg-slate-800/60 bg-slate-800/30';

        const unreadDot = document.createElement('span');
        unreadDot.setAttribute('data-notification-item-unread', '');
        unreadDot.className = 'mt-1.5 inline-block h-2 w-2 shrink-0 rounded-full bg-emerald-400';

        const content = document.createElement('span');
        content.className = 'min-w-0 flex-1';

        const title = document.createElement('span');
        title.className = 'block text-xs font-semibold text-slate-100';
        title.textContent = notification?.title ?? 'Notification';

        const message = document.createElement('span');
        message.className = 'mt-0.5 block text-xs text-slate-400';
        message.textContent = notification?.message ?? 'You have a new update.';

        const time = document.createElement('span');
        time.className = 'mt-1 block text-[0.65rem] text-slate-500';
        time.textContent = formatTimestamp(notification?.created_at);

        content.append(title, message, time);
        link.append(unreadDot, content);
        item.append(link);

        pageListElement.prepend(item);
        pageListElement.classList.remove('hidden');
        pageEmptyElement.classList.add('hidden');
        pagePaginationElement?.classList.add('hidden');
    };

    renderBadges();

    if (panelElement && triggerElements.length > 0) {
        setTriggersExpanded(false);

        triggerElements.forEach((triggerElement) => {
            triggerElement.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();
                togglePanel();
            });
        });

        document.addEventListener('click', (event) => {
            const clickedInsidePanel = panelElement.contains(event.target);
            const clickedTrigger = event.target.closest('[data-notification-trigger]');

            if (!clickedInsidePanel && !clickedTrigger) {
                closePanel();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closePanel();
            }
        });
    }

    document.addEventListener('click', async (event) => {
        const notificationLink = event.target.closest('[data-notification-link]');

        if (!notificationLink) {
            return;
        }

        const destination = notificationLink.getAttribute('href') ?? '#';
        const notificationId = notificationLink.dataset.notificationId;

        event.preventDefault();
        await markNotificationAsRead(notificationId, notificationLink);

        if (destination && destination !== '#') {
            window.location.assign(destination);
        }
    }, true);

    if (!window.Echo || badgeElements.length === 0) {
        return;
    }

    window.Echo.private(`App.Models.User.${authUserId}`).notification((notification) => {
            unreadCount += 1;
            renderBadges();
            prependNotification(notification);
            prependNotificationToPage(notification);

            if (notificationSoundUrl) {
                const audio = new Audio(notificationSoundUrl);
                audio.loop = false;
                audio.play().catch(() => {});
            }
        });
});
