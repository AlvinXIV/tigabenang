import { analyzeFit } from './fit-analysis';

const waitForVisible = (element) => {
    if (!element || typeof IntersectionObserver === 'undefined') {
        return Promise.resolve();
    }

    const rect = element.getBoundingClientRect();

    if (rect.bottom > 0 && rect.top < (window.innerHeight || 800) + 80) {
        return Promise.resolve();
    }

    return new Promise((resolve) => {
        const observer = new IntersectionObserver(
            (entries) => {
                if (entries.some((entry) => entry.isIntersecting)) {
                    observer.disconnect();
                    resolve();
                }
            },
            { rootMargin: '80px' },
        );

        observer.observe(element);
    });
};

const stateColors = {
    'Too Tight': '#8f4528',
    'Perfect Fit': '#2c2622',
    'Too Loose': '#7a7168',
};

const parseJsonScript = (root, selector) => {
    const node = root.querySelector(selector);
    if (!node) {
        return [];
    }

    try {
        return JSON.parse(node.textContent || '[]');
    } catch {
        return [];
    }
};

const initFitting = async () => {
    const root = document.querySelector('[data-fitting-root]');
    if (!root) {
        return;
    }

    const catalog = parseJsonScript(root, '[data-fitting-catalog]');
    const viewport = document.getElementById('fitting-viewport');
    const productSelect = root.querySelector('[data-fitting-product]');
    const nameNode = root.querySelector('[data-fitting-name]');
    const categoryNode = root.querySelector('[data-fitting-category]');
    const sizesNode = root.querySelector('[data-fitting-sizes]');
    const sizeNode = root.querySelector('[data-fitting-size]');
    const matchNode = root.querySelector('[data-fitting-match]');
    const heatmapNode = root.querySelector('[data-fitting-heatmap]');
    const heightInput = root.querySelector('[data-fitting-height]');
    const weightInput = root.querySelector('[data-fitting-weight]');
    const statusNode = root.querySelector('[data-fitting-status]');
    const tabs = root.querySelectorAll('[data-fitting-tab]');
    const panels = root.querySelectorAll('[data-fitting-panel]');

    if (!viewport || catalog.length === 0) {
        return;
    }

    await waitForVisible(viewport);

    let studio;
    try {
        const [{ createFittingScene }, { createAvatar }] = await Promise.all([
            import('../three/scene'),
            import('../three/avatar'),
        ]);
        studio = createFittingScene(viewport);
        studio.scene.add(createAvatar());
        statusNode.textContent = 'Studio ready';
    } catch {
        statusNode.textContent = '3D studio unavailable in this browser';
        return;
    }

    const findProduct = (id) => catalog.find((item) => String(item.id) === String(id));

    const renderHeatmap = (heatmap) => {
        heatmapNode.innerHTML = heatmap
            .map(
                (item) => `
                <li class="flex items-center justify-between border-b border-line py-3">
                    <span class="text-sm">${item.area}</span>
                    <span class="text-[11px] uppercase tracking-[0.16em]" style="color:${stateColors[item.state] || '#2c2622'}">${item.state}</span>
                </li>
            `,
            )
            .join('');
    };

    const updateAnalysis = (product) => {
        const result = analyzeFit({
            heightCm: heightInput.value,
            weightKg: weightInput.value,
            sizes: product?.sizes || [],
        });

        sizeNode.textContent = result.recommendedSize || '—';
        matchNode.textContent = result.overallMatch;
        renderHeatmap(result.heatmap);
        sizesNode.textContent = (product?.sizes || []).map((size) => size.name).join(' · ') || 'No sizes for this category';
    };

    const applyProduct = async (product) => {
        if (!product) {
            return;
        }

        nameNode.textContent = product.name;
        categoryNode.textContent = product.category || '';
        updateAnalysis(product);
        statusNode.textContent = product.modelUrl ? 'Loading garment' : 'Avatar only — no 3D file on this product';

        try {
            const { loadGarment } = await import('../three/garment');
            await loadGarment(product.modelUrl, studio.garmentGroup);
            statusNode.textContent = product.modelUrl ? 'Garment loaded' : 'Avatar only — no 3D file on this product';
        } catch {
            studio.garmentGroup.clear();
            statusNode.textContent = 'Could not load the 3D file. Showing the fitting figure only.';
        }
    };

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            const selected = tab.dataset.fittingTab;
            tabs.forEach((item) => {
                const active = item === tab;
                item.setAttribute('aria-selected', active ? 'true' : 'false');
                item.classList.toggle('text-terracotta', active);
                item.classList.toggle('text-muted', !active);
            });
            panels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.dataset.fittingPanel !== selected);
            });
        });
    });

    productSelect.addEventListener('change', () => {
        applyProduct(findProduct(productSelect.value));
    });

    heightInput.addEventListener('input', () => updateAnalysis(findProduct(productSelect.value)));
    weightInput.addEventListener('input', () => updateAnalysis(findProduct(productSelect.value)));

    await applyProduct(findProduct(productSelect.value) || catalog[0]);
};

document.addEventListener('DOMContentLoaded', () => {
    initFitting();
});
