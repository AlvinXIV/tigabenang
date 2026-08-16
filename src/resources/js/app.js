const shouldSkipPrefetch = (anchor) => {
    if (!anchor || anchor.target === '_blank' || anchor.hasAttribute('download')) {
        return true;
    }

    let url;

    try {
        url = new URL(anchor.href, window.location.href);
    } catch {
        return true;
    }

    if (url.origin !== window.location.origin) {
        return true;
    }

    if (url.pathname === '/virtual-fitting' || url.pathname.startsWith('/virtual-fitting/')) {
        return true;
    }

    if (url.pathname === window.location.pathname && url.search === window.location.search) {
        return true;
    }

    return false;
};

const initHoverPrefetch = () => {
    const prefetched = new Set();

    const prefetch = (href) => {
        if (!href || prefetched.has(href)) {
            return;
        }

        prefetched.add(href);

        const link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = href;
        link.as = 'document';
        document.head.appendChild(link);
    };

    document.addEventListener(
        'pointerenter',
        (event) => {
            const anchor = event.target.closest?.('a[href]');

            if (!anchor || shouldSkipPrefetch(anchor)) {
                return;
            }

            prefetch(anchor.href);
        },
        true,
    );

    if (typeof IntersectionObserver === 'undefined') {
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                const anchor = entry.target;

                observer.unobserve(anchor);

                if (!shouldSkipPrefetch(anchor)) {
                    prefetch(anchor.href);
                }
            });
        },
        { rootMargin: '0px' },
    );

    document.querySelectorAll('header a[href], footer a[href]').forEach((anchor) => {
        if (!shouldSkipPrefetch(anchor)) {
            observer.observe(anchor);
        }
    });
};

const initMobileNav = () => {
    const toggle = document.querySelector('[data-nav-toggle]');
    const panel = document.querySelector('[data-nav-panel]');

    if (!toggle || !panel) {
        return;
    }

    const setOpen = (open) => {
        panel.classList.toggle('hidden', !open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.classList.toggle('overflow-hidden', open);
    };

    toggle.addEventListener('click', () => {
        const isOpen = toggle.getAttribute('aria-expanded') === 'true';
        setOpen(!isOpen);
    });

    panel.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setOpen(false);
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initMobileNav();
    initHoverPrefetch();
});
