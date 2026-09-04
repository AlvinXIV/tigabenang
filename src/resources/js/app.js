import Alpine from 'alpinejs';

// Expose Alpine to window for inline scripts, blade views, and Livewire 3
window.Alpine = Alpine;

// If Livewire is loaded on the page, Livewire starts Alpine automatically.
// Otherwise (for pages without Livewire), start Alpine once DOM is ready.
document.addEventListener('DOMContentLoaded', () => {
    if (!window.Livewire && !window.__alpine_started) {
        window.__alpine_started = true;
        Alpine.start();
    }
});

// Lazy-load Chart.js on demand
window.loadChart = async () => {
    if (!window.Chart) {
        const { default: Chart } = await import('chart.js/auto');
        window.Chart = Chart;
    }
    return window.Chart;
};

// Automatically load Chart.js only when a chart element is present
if (typeof document !== 'undefined' && document.querySelector('canvas[data-chart], [data-chart]')) {
    window.loadChart().then((Chart) => {
        window.dispatchEvent(new CustomEvent('chartjs-loaded', { detail: Chart }));
    });
}

// Lazy-load @google/model-viewer only when <model-viewer> element is in the DOM
if (typeof document !== 'undefined' && document.querySelector('model-viewer')) {
    import('@google/model-viewer');
}

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

    // Exclude admin panel routes from hover prefetching to avoid saturating PHP-FPM workers
    if (url.pathname === '/admin' || url.pathname.startsWith('/admin/')) {
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
