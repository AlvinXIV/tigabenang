import { analyzeFit } from './fit-analysis';
import { loadGarment, fitGarmentToAvatar, createDummyGarment } from '../three/garment';

const stateColors = {
    'Too Tight': '#DC2626',
    'Perfect Fit': '#059669',
    'Too Loose': '#2563EB',
};

const parseJsonScript = (root, selector) => {
    const node = root.querySelector(selector);
    if (!node) return [];
    try {
        return JSON.parse(node.textContent || '[]');
    } catch {
        return [];
    }
};

const numberValue = (input, fallback = 0) => {
    const value = Number(input?.value);
    return Number.isFinite(value) ? value : fallback;
};

const PROFILE_KEY = 'clothiq-body-profile';

const loadSavedProfile = () => {
    try {
        return JSON.parse(localStorage.getItem(PROFILE_KEY));
    } catch {
        return null;
    }
};

const saveProfile = (inputs) => {
    try {
        localStorage.setItem(PROFILE_KEY, JSON.stringify(inputs));
    } catch {}
};

const initFitting = async () => {
    const root = document.querySelector('[data-fitting-root]');
    if (!root) return;

    const catalog = parseJsonScript(root, '[data-fitting-catalog]');
    const viewport = document.getElementById('fitting-viewport');
    if (!viewport) return;

    // Elements
    const productSelect = root.querySelector('[data-fitting-product]');
    const nameNode = root.querySelector('[data-fitting-name]');
    const categoryNode = root.querySelector('[data-fitting-category]');
    const sizeNode = root.querySelector('[data-fitting-size]');
    const matchNode = root.querySelector('[data-fitting-match]');
    const heatmapNode = root.querySelector('[data-fitting-heatmap]');
    const statusNode = root.querySelector('[data-fitting-status]');
    const sizeButtonsContainer = root.querySelector('[data-fitting-size-buttons]');

    // Body inputs
    const heightInput = root.querySelector('[data-fitting-height]');
    const chestInput = root.querySelector('[data-fitting-chest]');
    const waistInput = root.querySelector('[data-fitting-waist]');
    const hipInput = root.querySelector('[data-fitting-hip]');
    const shoulderInput = root.querySelector('[data-fitting-shoulder]');
    const armLengthInput = root.querySelector('[data-fitting-arm-length]');
    const torsoLengthInput = root.querySelector('[data-fitting-torso-length]');
    const torsoTypeRadios = root.querySelectorAll('[data-fitting-torso-type]');

    const getTorsoType = () => {
        for (const radio of torsoTypeRadios) {
            if (radio.checked) return radio.value;
        }
        return 'normal';
    };

    // Restore saved measurements
    const saved = loadSavedProfile();
    if (saved) {
        if (heightInput && saved.height != null) heightInput.value = saved.height;
        if (chestInput && saved.chest != null) chestInput.value = saved.chest;
        if (waistInput && saved.waist != null) waistInput.value = saved.waist;
        if (hipInput && saved.hip != null) hipInput.value = saved.hip;
        if (shoulderInput && saved.shoulder != null) shoulderInput.value = saved.shoulder;
        if (armLengthInput && saved.armLength != null) armLengthInput.value = saved.armLength;
        if (torsoLengthInput && saved.torsoLength != null) torsoLengthInput.value = saved.torsoLength;
        if (saved.torsoType) {
            for (const radio of torsoTypeRadios) {
                radio.checked = radio.value === saved.torsoType;
            }
        }
    }

    // Tabs
    const tabs = root.querySelectorAll('[data-fitting-tab]');
    const panels = root.querySelectorAll('[data-fitting-panel]');

    let studio;
    let avatar = null;
    let currentGarmentWrapper = null;
    let selectedSizeName = null;

    try {
        const [
            { createFittingScene },
            { createAvatar, updateAvatar },
        ] = await Promise.all([
            import('../three/scene'),
            import('../three/avatar'),
        ]);

        studio = createFittingScene(viewport);

        const getBodyParams = () => ({
            height: numberValue(heightInput, 170),
            chest: numberValue(chestInput, 92),
            waist: numberValue(waistInput, 76),
            hip: numberValue(hipInput, 96),
            shoulder: numberValue(shoulderInput, 44),
            armLength: numberValue(armLengthInput, 58),
            torsoLength: numberValue(torsoLengthInput, 44),
            torsoType: getTorsoType(),
        });

        // ── 1. Create Initial Avatar ──
        avatar = createAvatar(getBodyParams());
        studio.scene.add(avatar);

        if (statusNode) {
            statusNode.textContent = 'Virtual studio ready';
        }

        const findProduct = (id) => {
            return catalog.find((item) => String(item.id) === String(id));
        };

        const renderHeatmap = (heatmap) => {
            if (!heatmapNode) return;
            heatmapNode.innerHTML = heatmap.map((item) => `
                <li class="flex items-center justify-between py-1.5 border-b border-[#DCD6D0]/60">
                    <span class="font-bold text-xs text-[#172A39]">${item.area}</span>
                    <span class="text-[11px] font-black uppercase tracking-wider px-2 py-0.5 rounded-full"
                          style="color:${stateColors[item.state] || '#172A39'};background:${item.state === 'Too Tight' ? '#FEE2E2' : (item.state === 'Too Loose' ? '#DBEAFE' : '#D1FAE5')};">
                        ${item.state}
                    </span>
                </li>
            `).join('');
        };

        const updateFitBadge = (matchText) => {
            if (!matchNode) return;
            matchNode.textContent = matchText;
            if (matchText === 'Too Tight') {
                matchNode.style.background = '#FEE2E2';
                matchNode.style.color = '#991B1B';
                matchNode.style.borderColor = '#FCA5A5';
            } else if (matchText === 'Too Loose') {
                matchNode.style.background = '#DBEAFE';
                matchNode.style.color = '#1E40AF';
                matchNode.style.borderColor = '#93C5FD';
            } else {
                matchNode.style.background = '#D1FAE5';
                matchNode.style.color = '#065F46';
                matchNode.style.borderColor = '#6EE7B7';
            }
        };

        const renderSizeButtons = (product, recommendedSize) => {
            if (!sizeButtonsContainer) return;

            const sizes = product?.sizes?.length > 0
                ? product.sizes
                : [
                    { name: 'S', lebar_dada: 46, panjang: 68, lebar_bahu: 42 },
                    { name: 'M', lebar_dada: 50, panjang: 70, lebar_bahu: 44 },
                    { name: 'L', lebar_dada: 54, panjang: 72, lebar_bahu: 46 },
                    { name: 'XL', lebar_dada: 58, panjang: 74, lebar_bahu: 48 },
                    { name: 'XXL', lebar_dada: 62, panjang: 76, lebar_bahu: 50 },
                ];

            if (!selectedSizeName) {
                selectedSizeName = recommendedSize || sizes[1]?.name || 'M';
            }

            sizeButtonsContainer.innerHTML = sizes.map((s) => {
                const isActive = s.name === selectedSizeName;
                return `
                    <button type="button" data-size="${s.name}"
                        class="size-pill-btn px-4 py-2 rounded-xl text-xs font-black border transition-all cursor-pointer ${
                            isActive
                                ? 'bg-[#172A39] text-white border-[#172A39] shadow-md'
                                : 'bg-[#FAF8F5] text-[#172A39] border-[#DCD6D0] hover:bg-[#EAE2D8]'
                        }">
                        ${s.name}
                    </button>
                `;
            }).join('');

            sizeButtonsContainer.querySelectorAll('button[data-size]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    selectedSizeName = btn.dataset.size;
                    renderSizeButtons(product, recommendedSize);
                    recalculateFit(product);
                });
            });
        };

        const recalculateFit = (product) => {
            if (!product) return;

            const p = getBodyParams();
            const result = analyzeFit({
                heightCm: p.height,
                chestCm: p.chest,
                waistCm: p.waist,
                hipCm: p.hip,
                shoulderCm: p.shoulder,
                sizes: product?.sizes || [],
            });

            if (sizeNode) {
                sizeNode.textContent = selectedSizeName || result.recommendedSize || 'M';
            }

            // Find current active size spec
            const activeSizeSpec = product?.sizes?.find((s) => s.name === selectedSizeName) || {
                S: { lebar_dada: 46, panjang: 68, lebar_bahu: 42 },
                M: { lebar_dada: 50, panjang: 70, lebar_bahu: 44 },
                L: { lebar_dada: 54, panjang: 72, lebar_bahu: 46 },
                XL: { lebar_dada: 58, panjang: 74, lebar_bahu: 48 },
                XXL: { lebar_dada: 62, panjang: 76, lebar_bahu: 50 },
            }[selectedSizeName || 'M'];

            // Calculate fit classification for this specific size
            const customerHalfChest = p.chest / 2;
            const garmentHalfChest = activeSizeSpec?.lebar_dada || 50;
            const ratio = customerHalfChest / garmentHalfChest;

            let currentMatchText = 'Perfect Fit';
            if (ratio > 1.05) currentMatchText = 'Too Tight';
            else if (ratio < 0.92) currentMatchText = 'Too Loose';

            updateFitBadge(currentMatchText);
            renderHeatmap(result.heatmap || []);

            // ── Dynamic 3D Garment Morphing & Fitting ──
            if (currentGarmentWrapper) {
                fitGarmentToAvatar(currentGarmentWrapper, p, activeSizeSpec, currentMatchText);
            }
        };

        // ── 2. Update Body Avatar ──
        const updateBody = () => {
            if (!avatar) return;

            const p = getBodyParams();
            const newAvatar = updateAvatar(avatar, p);
            if (newAvatar) avatar = newAvatar;

            saveProfile(p);

            const product = findProduct(productSelect?.value) || catalog[0];
            recalculateFit(product);

            if (statusNode) {
                statusNode.textContent = 'Body profile updated';
            }
        };

        // ── 3. Apply Product & Load 3D Garment ──
        const applyProduct = async (product) => {
            if (!product) {
                console.warn('[VF] No product to apply');
                return;
            }

            console.log('[VF] Applying product:', product.name, 'modelUrl:', product.modelUrl);

            if (nameNode) nameNode.textContent = product.name;
            if (categoryNode) categoryNode.textContent = product.category || 'Katalog';

            renderSizeButtons(product, selectedSizeName);

            if (statusNode) {
                statusNode.textContent = 'Memuat model 3D ' + (product.name || '') + '...';
                statusNode.style.color = '#172A39';
                statusNode.style.background = 'rgba(255,255,255,0.92)';
            }

            if (!product.modelUrl) {
                console.log('[VF] No modelUrl, using procedural shirt');
                currentGarmentWrapper = createDummyGarment(studio.garmentGroup);
                recalculateFit(product);
                if (statusNode) {
                    statusNode.textContent = '✓ Model Sampel Aktif (Belum ada file GLB)';
                    statusNode.style.color = '#065F46';
                    statusNode.style.background = '#D1FAE5';
                }
                return;
            }

            // Debug overlay element
            let debugOverlay = document.getElementById('debug-glb-error');
            if (!debugOverlay) {
                debugOverlay = document.createElement('div');
                debugOverlay.id = 'debug-glb-error';
                debugOverlay.style.position = 'fixed';
                debugOverlay.style.top = '10px';
                debugOverlay.style.left = '50%';
                debugOverlay.style.transform = 'translateX(-50%)';
                debugOverlay.style.background = 'rgba(255,0,0,0.9)';
                debugOverlay.style.color = '#fff';
                debugOverlay.style.padding = '10px 20px';
                debugOverlay.style.borderRadius = '8px';
                debugOverlay.style.zIndex = '2147483647';
                debugOverlay.style.fontFamily = 'monospace';
                debugOverlay.style.fontSize = '16px';
                debugOverlay.style.textAlign = 'center';
                document.body.appendChild(debugOverlay);
            }

            try {
                console.log('[VF] Starting GLB load from URL:', product.modelUrl);
                debugOverlay.textContent = 'Memuat model... URL: ' + product.modelUrl;
                debugOverlay.style.background = 'rgba(255,165,0,0.9)'; // Orange

                currentGarmentWrapper = await loadGarment(
                    product.modelUrl,
                    studio.garmentGroup,
                    (percent) => {
                        if (statusNode) statusNode.textContent = `Memuat 3D Model: ${percent}%`;
                        debugOverlay.textContent = `Loading ${percent}%... URL: ` + product.modelUrl;
                    }
                );

                if (currentGarmentWrapper) {
                    debugOverlay.innerHTML = `Sukses memuat GLB!<br/>URL: ${product.modelUrl}`;
                    debugOverlay.style.background = 'rgba(0,128,0,0.9)'; // Green
                    if (statusNode) {
                        statusNode.textContent = '✓ 3D Baju Terpasang: ' + (product.name || '');
                        statusNode.style.color = '#065F46';
                        statusNode.style.background = '#D1FAE5';
                    }
                }
            } catch (error) {
                console.error('[VF] GLB load FAILED:', error);
                debugOverlay.innerHTML = `ERROR MEMUAT GLB!<br/>URL: ${product.modelUrl}<br/>Error: ${error.message || error}`;
                debugOverlay.style.background = 'rgba(255,0,0,0.9)'; // Red

                currentGarmentWrapper = createDummyGarment(studio.garmentGroup);
                if (statusNode) {
                    statusNode.textContent = '⚠️ GLB Gagal: ' + (error.message || 'Menggunakan model sampel');
                    statusNode.style.color = '#991B1B';
                    statusNode.style.background = '#FEE2E2';
                }
            }
            recalculateFit(product);
        };

        // ── Input Listeners ──
        [
            heightInput, chestInput, waistInput, hipInput,
            shoulderInput, armLengthInput, torsoLengthInput,
        ].forEach((input) => {
            input?.addEventListener('input', updateBody);
        });

        torsoTypeRadios.forEach((radio) => {
            radio.addEventListener('change', updateBody);
        });

        if (productSelect) {
            productSelect.addEventListener('change', () => {
                const prod = findProduct(productSelect.value);
                applyProduct(prod);
            });
        }

        // ── Tabs Switching ──
        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                const selected = tab.dataset.fittingTab;
                tabs.forEach((item) => {
                    const active = item === tab;
                    item.setAttribute('aria-selected', active ? 'true' : 'false');
                    item.style.color = active ? '#172A39' : '#6E7575';
                    item.style.borderColor = active ? '#172A39' : 'transparent';
                    item.style.background = active ? '#FAF8F5' : 'transparent';
                });

                panels.forEach((panel) => {
                    panel.classList.toggle('hidden', panel.dataset.fittingPanel !== selected);
                });
            });
        });

        // ── Initial Setup ──
        const initialProduct = productSelect ? (findProduct(productSelect.value) || catalog[0]) : catalog[0];
        await applyProduct(initialProduct);

        window.addEventListener('beforeunload', () => {
            studio?.dispose();
        }, { once: true });

    } catch (error) {
        console.error('Virtual fitting studio failed:', error);
        if (statusNode) statusNode.textContent = '3D studio error';
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initFitting();
    });
} else {
    initFitting();
}