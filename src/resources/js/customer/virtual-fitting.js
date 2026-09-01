// alvin-tshirt-prototype-2026-08-30
import {
    loadGarment,
    fitGarmentToMannequin,
    updateGarmentFit,
    disposeGarment,
} from '../three/garment';

const PROTO_TSHIRT_URL = '/models/t-shirt.glb';
const PREVIEW_AREAS = [
    { area: 'Dada' },
    { area: 'Bahu' },
    { area: 'Pinggang' },
];

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
    let selectedSizeName = 'M';

    try {
        const [
            { createFittingScene },
            { createAvatar, updateAvatar, setCoveredTorsoVisible },
        ] = await Promise.all([
            import('../three/scene'),
            import('../three/avatar'),
        ]);

        studio = createFittingScene(viewport);
        requestAnimationFrame(() => studio?.resize?.());

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
        if (statusNode) {
            statusNode.textContent = 'Menyiapkan studio';
        }

        avatar = createAvatar(getBodyParams());
        studio.scene.add(avatar);

        if (statusNode) {
            statusNode.textContent = 'Manekin siap';
        }

        if (nameNode) {
            nameNode.textContent = 'Manekin studio';
        }

        if (categoryNode) {
            categoryNode.textContent = 'Pratinjau kaos';
        }

        const applyTorsoMask = (fitResult) => {
            if (!avatar) {
                return;
            }

            setCoveredTorsoVisible(avatar, !fitResult?.hideCoveredTorso);
        };

        const updateFitBadge = () => {
            if (!matchNode) {
                return;
            }

            matchNode.textContent = 'Pratinjau statis';
            matchNode.style.background = 'rgba(255,255,255,0.95)';
            matchNode.style.color = '#1C2430';
            matchNode.style.borderColor = '#E2E5E9';
        };

        const renderHeatmap = () => {
            if (!heatmapNode) {
                return;
            }

            heatmapNode.innerHTML = PREVIEW_AREAS.map((item) => `
                <li class="flex items-center justify-between py-1.5 border-b border-[#E2E5E9]">
                    <span class="font-medium text-xs text-[#1C2430]">${item.area}</span>
                    <span class="text-[11px] font-medium px-2 py-0.5 rounded-[8px]"
                          style="color:#667085;background:#F7F7F5;border:1px solid #E2E5E9;">
                        Pratinjau
                    </span>
                </li>
            `).join('');
        };

        const refitCurrentShirt = () => {
            if (!currentGarmentWrapper) {
                return null;
            }

            const fitResult = updateGarmentFit(
                currentGarmentWrapper,
                getBodyParams(),
                selectedSizeName,
            );

            applyTorsoMask(fitResult);

            return fitResult;
        };

        const markPrototypeReady = () => {
            if (nameNode) {
                nameNode.textContent = 'Manekin studio';
            }

            if (categoryNode) {
                categoryNode.textContent = 'Pratinjau kaos';
            }

            if (sizeNode) {
                sizeNode.textContent = selectedSizeName;
            }

            updateFitBadge();
            renderHeatmap();
        };

        const applyPrototypeShirt = async () => {
            if (statusNode) {
                statusNode.textContent = 'Memuat pakaian...';
            }

            try {
                currentGarmentWrapper = await loadGarment(
                    PROTO_TSHIRT_URL,
                    studio.garmentGroup,
                );

                if (currentGarmentWrapper) {
                    const fitResult = fitGarmentToMannequin(
                        currentGarmentWrapper,
                        getBodyParams(),
                        selectedSizeName,
                    );
                    applyTorsoMask(fitResult);
                }

                markPrototypeReady();

                if (statusNode) {
                    statusNode.textContent = 'Pakaian siap';
                }
            } catch (error) {
                console.error('[Garment] failed to load', PROTO_TSHIRT_URL, error);
                disposeGarment(studio.garmentGroup);
                currentGarmentWrapper = null;

                if (statusNode) {
                    statusNode.textContent = 'Pakaian tidak tersedia';
                }
            }
        };

        await applyPrototypeShirt();

        const resetButton = root.querySelector('[data-fitting-reset-view]');
        resetButton?.addEventListener('click', () => {
            studio.resetView?.();
        });

        const fallbackSizes = [
            { name: 'S', lebar_dada: 46, panjang: 68, lebar_bahu: 42 },
            { name: 'M', lebar_dada: 50, panjang: 70, lebar_bahu: 44 },
            { name: 'L', lebar_dada: 54, panjang: 72, lebar_bahu: 46 },
            { name: 'XL', lebar_dada: 58, panjang: 74, lebar_bahu: 48 },
            { name: 'XXL', lebar_dada: 62, panjang: 76, lebar_bahu: 50 },
        ];

        const findProduct = (id) => {
            return catalog.find((item) => String(item.id) === String(id));
        };

        const renderSizeButtons = (product) => {
            if (!sizeButtonsContainer) return;

            const sizes = product?.sizes?.length > 0
                ? product.sizes
                : fallbackSizes;

            sizeButtonsContainer.innerHTML = sizes.map((s) => {
                const isActive = s.name === selectedSizeName;
                return `
                    <button type="button" data-size="${s.name}"
                        class="size-pill-btn px-3 py-2 rounded-lg text-xs font-semibold border transition-all cursor-pointer ${
                            isActive
                                ? 'bg-[#1C2430] text-white border-[#1C2430]'
                                : 'bg-[#F7F7F5] text-[#1C2430] border-[#E2E5E9] hover:bg-[#EEEFEC]'
                        }">
                        ${s.name}
                    </button>
                `;
            }).join('');

            sizeButtonsContainer.querySelectorAll('button[data-size]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    selectedSizeName = btn.dataset.size;
                    renderSizeButtons(product);
                    recalculateFit();
                });
            });
        };

        const recalculateFit = () => {
            if (sizeNode) {
                sizeNode.textContent = selectedSizeName;
            }

            updateFitBadge();
            renderHeatmap();
            refitCurrentShirt();
        };

        // ── 2. Update Body Avatar ──
        const updateBody = () => {
            if (!avatar) return;

            const p = getBodyParams();
            const newAvatar = updateAvatar(avatar, p);
            if (newAvatar) avatar = newAvatar;

            saveProfile(p);

            const product = findProduct(productSelect?.value) || catalog[0];
            renderSizeButtons(product);
            recalculateFit();

            if (statusNode && currentGarmentWrapper) {
                statusNode.textContent = 'Pakaian siap';
            }
        };

        const applyProduct = async (product) => {
            renderSizeButtons(product);
            recalculateFit();

            if (currentGarmentWrapper && statusNode) {
                statusNode.textContent = 'Pakaian siap';
            }
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
                    item.style.color = active ? '#1C2430' : '#667085';
                    item.style.borderColor = active ? '#1C2430' : 'transparent';
                    item.style.background = active ? '#F7F7F5' : 'transparent';
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
            if (studio?.garmentGroup) {
                disposeGarment(studio.garmentGroup);
            }
            studio?.dispose();
        }, { once: true });

    } catch (error) {
        console.error('Virtual fitting studio failed:', error);
        if (statusNode) statusNode.textContent = 'Studio 3D bermasalah';
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initFitting();
    });
} else {
    initFitting();
}