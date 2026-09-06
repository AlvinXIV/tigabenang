import { analyzeFit } from './fit-analysis';
import { loadGarment, fitGarmentToAvatar, createDummyGarment } from '../three/garment';
import { createFittingScene } from '../three/scene';
import { createAvatar, updateAvatar } from '../three/avatar';


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

const PROTO_TSHIRT = {
    id: 'tshirt-preview',
    name: 'T-shirt preview',
    category: 'Prototipe',
    modelUrl: '/models/t-shirt.glb',
    sizes: [
        { name: 'S', lebar_dada: 50, panjang: 68, lebar_bahu: 43 },
        { name: 'M', lebar_dada: 53, panjang: 70, lebar_bahu: 45 },
        { name: 'L', lebar_dada: 56, panjang: 72, lebar_bahu: 47 },
        { name: 'XL', lebar_dada: 59, panjang: 74, lebar_bahu: 49 },
        { name: '2XL', lebar_dada: 62, panjang: 76, lebar_bahu: 51 },
    ],
};

const getProductSizes = (product) => {
    if (Array.isArray(product?.sizes) && product.sizes.length > 0) {
        return product.sizes;
    }
    return [
        { name: 'S', lebar_dada: 50, panjang: 68, lebar_bahu: 43 },
        { name: 'M', lebar_dada: 53, panjang: 70, lebar_bahu: 45 },
        { name: 'L', lebar_dada: 56, panjang: 72, lebar_bahu: 47 },
        { name: 'XL', lebar_dada: 59, panjang: 74, lebar_bahu: 49 },
        { name: '2XL', lebar_dada: 62, panjang: 76, lebar_bahu: 51 },
    ];
};

const PROFILE_KEY = 'clothiq-body-profile';

const clearSavedProfile = () => {
    try {
        localStorage.removeItem(PROFILE_KEY);
    } catch {}
};

const initFitting = async () => {
    const root = document.querySelector('[data-fitting-root]');
    if (!root) return;

    let catalog = parseJsonScript(root, '[data-fitting-catalog]');
    if (!Array.isArray(catalog) || catalog.length === 0) {
        catalog = [PROTO_TSHIRT];
    }
    const findProduct = (id) => {
        return catalog.find((item) => String(item.id) === String(id));
    };
    const viewport = document.getElementById('fitting-viewport');
    if (!viewport) return;

    // Elements
    const categoryFilter = root.querySelector('[data-fitting-category-filter]');
    const searchFilter = root.querySelector('[data-fitting-search-filter]');
    const productListContainer = root.querySelector('[data-fitting-product-list]');
    
    let selectedProductId = null;
    let filteredCatalog = [...catalog];

    const renderProductList = () => {
        if (!productListContainer) return;
        
        if (filteredCatalog.length === 0) {
            productListContainer.innerHTML = '<p class="col-span-full text-xs text-center text-[#667085] py-4">Tidak ada baju yang bisa dicoba di kategori ini</p>';
            return;
        }

        productListContainer.innerHTML = filteredCatalog.map(prod => {
            const isSelected = String(prod.id) === String(selectedProductId);
            const displayCat = prod.category === 'JaketWindbreaker' ? 'Jaket Windbreaker' : (prod.category || 'Katalog');
            
            return `
                <div data-product-card="${prod.id}" class="group relative cursor-pointer overflow-hidden rounded-[8px] border transition-all ${isSelected ? 'border-[#102A43] ring-1 ring-[#102A43]' : 'border-[#E2E5E9] hover:border-[#102A43]'} bg-white">
                    <div class="aspect-[4/5] w-full bg-[#F7F7F5]">
                        ${prod.imageUrl 
                            ? '<img src="' + prod.imageUrl + '" alt="' + (prod.name || '') + '" class="h-full w-full object-cover">' 
                            : '<div class="flex h-full w-full items-center justify-center"><span class="text-[10px] text-[#667085]">No Image</span></div>'
                        }
                    </div>
                    <div class="p-2">
                        <p class="truncate text-[11px] font-bold text-[#102A43] leading-tight">${prod.name}</p>
                        <p class="text-[9px] text-[#667085] truncate mt-0.5">${displayCat}</p>
                    </div>
                    ${isSelected ? '<div class="absolute right-1 top-1 rounded-full bg-[#102A43] p-0.5 text-white shadow-sm"><svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></div>' : ''}
                </div>
            `;
        }).join('');

        productListContainer.querySelectorAll('[data-product-card]').forEach(card => {
            card.addEventListener('click', () => {
                selectedProductId = card.dataset.productCard;
                renderProductList();
                const prod = findProduct(selectedProductId);
                if (applyProduct) applyProduct(prod);
            });
        });
    };

    const applyFilters = () => {
        const cat = categoryFilter?.value || '';
        const query = searchFilter?.value.toLowerCase() || '';

        filteredCatalog = catalog.filter(prod => {
            const displayCat = prod.category === 'JaketWindbreaker' ? 'Jaket Windbreaker' : (prod.category || 'Katalog');
            const matchCat = cat === '' || displayCat === cat;
            const matchQuery = query === '' || prod.name.toLowerCase().includes(query);
            return matchCat && matchQuery;
        });

        renderProductList();
    };

    if (categoryFilter) categoryFilter.addEventListener('change', applyFilters);
    if (searchFilter) searchFilter.addEventListener('input', applyFilters);
    const nameNode = root.querySelector('[data-fitting-name]');
    const categoryNode = root.querySelector('[data-fitting-category]');
    const sizeNode = root.querySelector('[data-fitting-size]');
    const matchNode = root.querySelector('[data-fitting-match]');
    const statusNode = root.querySelector('[data-fitting-status]');
    const sizeButtonsContainer = root.querySelector('[data-fitting-size-buttons]');

    // Elements for size recommendation card
    const recommendedBadge = root.querySelector('[data-fitting-recommended-badge]');
    const recommendedReason = root.querySelector('[data-fitting-recommended-reason]');
    const activeSizeLabel = root.querySelector('[data-fitting-active-size-label]');
    const activeNoteNode = root.querySelector('[data-fitting-active-note]');
    const applyRecommendedBtn = root.querySelector('[data-fitting-apply-recommended]');

    // Elements for live body panel banner (removed)

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

    // Pastikan session fitting mulai dengan variabel bersih / fresh tanpa residu input lama
    clearSavedProfile();

    // Tabs
    const tabs = root.querySelectorAll('[data-fitting-tab]');
    const panels = root.querySelectorAll('[data-fitting-panel]');

    let studio;
    let avatar = null;
    let currentGarmentWrapper = null;
    let selectedSizeName = null;
    let userManuallySelectedSize = false;
    let applyProduct = null;

    try {
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
            statusNode.textContent = 'Manekin siap';
        }

        const renderSizeButtons = (product, recommendedSize) => {
            if (!sizeButtonsContainer) return;

            const sizes = getProductSizes(product);

            if (!selectedSizeName) {
                selectedSizeName = recommendedSize || sizes[1]?.name || 'M';
            }

            sizeButtonsContainer.innerHTML = sizes.map((s) => {
                const isActive = s.name === selectedSizeName;
                const isRecommended = s.name === recommendedSize;
                return `
                    <button type="button" data-size="${s.name}"
                        class="size-pill-btn px-4 py-2 rounded-[8px] text-xs font-semibold border transition-all cursor-pointer inline-flex items-center gap-1.5 ${
                            isActive
                                ? 'bg-[#102A43] text-white border-[#102A43] shadow-sm'
                                : 'bg-white text-[#102A43] border-[#E2E5E9] hover:bg-[#F7F7F5]'
                        }">
                        <span>${s.name}</span>
                        ${isRecommended ? `<span class="text-[10px] font-medium px-1.5 py-0.5 rounded ${isActive ? 'bg-white/20 text-white' : 'bg-[#E8F3EE] text-[#3F7A62]'}">Saran</span>` : ''}
                    </button>
                `;
            }).join('');

            sizeButtonsContainer.querySelectorAll('button[data-size]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    userManuallySelectedSize = true;
                    selectedSizeName = btn.dataset.size;
                    renderSizeButtons(product, recommendedSize);
                    recalculateFit(product);
                });
            });
        };

        const recalculateFit = (product) => {
            if (!product) return;

            const p = getBodyParams();
            const productSizes = getProductSizes(product);

            const result = analyzeFit({
                heightCm: p.height,
                chestCm: p.chest,
                waistCm: p.waist,
                hipCm: p.hip,
                shoulderCm: p.shoulder,
                torsoLengthCm: p.torsoLength,
                armLengthCm: p.armLength,
                sizes: productSizes,
                selectedSizeName: selectedSizeName,
            });

            const recSize = result.recommendedSize || 'M';

            if (!selectedSizeName) {
                selectedSizeName = recSize;
            }

            // Update header size label
            if (sizeNode) {
                sizeNode.textContent = selectedSizeName;
            }

            // Update top viewport recommended size badge
            if (matchNode) {
                matchNode.textContent = recSize;
            }

            // Update recommendation card in the panel
            if (recommendedBadge) {
                recommendedBadge.textContent = 'Ukuran ' + recSize;
            }
            if (recommendedReason) {
                recommendedReason.innerHTML = result.reason || '';
            }
            if (activeSizeLabel) {
                activeSizeLabel.textContent = selectedSizeName;
            }
            if (activeNoteNode) {
                activeNoteNode.innerHTML = result.activeFitNote || '';
            }
            if (applyRecommendedBtn) {
                if (selectedSizeName === recSize) {
                    applyRecommendedBtn.style.display = 'none';
                } else {
                    applyRecommendedBtn.style.display = 'inline-block';
                    applyRecommendedBtn.textContent = `Gunakan saran ini (Ukuran ${recSize})`;
                    applyRecommendedBtn.onclick = () => {
                        userManuallySelectedSize = false;
                        selectedSizeName = recSize;
                        renderSizeButtons(product, recSize);
                        recalculateFit(product);
                    };
                }
            }

            // Update live recommendation banner in body panel (removed)

            // Find current active size spec
            const activeSizeSpec = productSizes.find((s) => s.name === selectedSizeName) || productSizes[1] || productSizes[0];

            // ── Dynamic 3D Garment Morphing & Fitting ──
            if (currentGarmentWrapper) {
                const baseSizeSpec = productSizes.find(s => s.name === 'M') 
                    || productSizes[1] 
                    || productSizes[0] 
                    || { lebar_dada: 50, panjang: 70 };

                fitGarmentToAvatar(currentGarmentWrapper, p, activeSizeSpec, null, avatar, baseSizeSpec);
            }
        };

        // ── 2. Update Body Avatar ──
        const updateBody = () => {
            if (!avatar) return;

            const p = getBodyParams();
            const newAvatar = updateAvatar(avatar, p);
            if (newAvatar) avatar = newAvatar;

            const product = findProduct(selectedProductId) || catalog[0];
            const productSizes = getProductSizes(product);

            const fit = analyzeFit({
                heightCm: p.height,
                chestCm: p.chest,
                waistCm: p.waist,
                hipCm: p.hip,
                shoulderCm: p.shoulder,
                torsoLengthCm: p.torsoLength,
                armLengthCm: p.armLength,
                sizes: productSizes,
                selectedSizeName: selectedSizeName,
            });

            // Tidak auto-ubah selectedSizeName saat mengubah slider tubuh
            // Biarkan pengguna melihat ukuran baju yang aktif saat ini, sehingga bisa dibandingkan dengan tubuh.

            renderSizeButtons(product, fit.recommendedSize);
            recalculateFit(product);

            if (statusNode) {
                statusNode.textContent = 'Ukuran tubuh diperbarui';
            }
        };

        // ── 3. Apply Product & Load 3D Garment ──
        applyProduct = async (product) => {
            if (!product) {
                console.warn('[VF] No product to apply');
                return;
            }

            console.log('[VF] Applying product:', product.name, 'modelUrl:', product.modelUrl);

            if (nameNode) nameNode.textContent = product.name;
            if (categoryNode) {
                categoryNode.textContent = product.category === 'JaketWindbreaker'
                    ? 'Jaket Windbreaker'
                    : (product.category || 'Katalog');
            }

            const p = getBodyParams();
            const fit = analyzeFit({
                heightCm: p.height,
                chestCm: p.chest,
                waistCm: p.waist,
                hipCm: p.hip,
                shoulderCm: p.shoulder,
                torsoLengthCm: p.torsoLength,
                armLengthCm: p.armLength,
                sizes: product?.sizes || [],
                selectedSizeName: selectedSizeName,
            });

            renderSizeButtons(product, fit.recommendedSize);

            if (statusNode) {
                statusNode.textContent = 'Memuat model 3D ' + (product.name || '') + '...';
                statusNode.style.color = '#1C2430';
                statusNode.style.background = 'rgba(255,255,255,0.92)';
            }

            if (!product.modelUrl) {
                console.log('[VF] No modelUrl, using procedural shirt');
                currentGarmentWrapper = createDummyGarment(studio.garmentGroup);
                recalculateFit(product);
                if (statusNode) {
                    statusNode.textContent = '✓ Model Sampel Aktif (Belum ada file GLB)';
                    statusNode.style.color = '#3F7A62';
                    statusNode.style.background = '#E8F3EE';
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
                debugOverlay.style.display = 'none';

                currentGarmentWrapper = await loadGarment(
                    product.modelUrl,
                    studio.garmentGroup,
                    (percent) => {
                        if (statusNode) statusNode.textContent = `Memuat 3D Model: ${percent}%`;
                    }
                );

                if (currentGarmentWrapper) {
                    if (statusNode) {
                        statusNode.textContent = 'Pakaian siap';
                        statusNode.style.color = '#3F7A62';
                        statusNode.style.background = '#E8F3EE';
                    }
                }
            } catch (error) {
                console.error('[VF] GLB load FAILED:', error);
                debugOverlay.style.display = 'block';
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
            input?.addEventListener('change', updateBody);
        });

        torsoTypeRadios.forEach((radio) => {
            radio.addEventListener('change', updateBody);
        });

        // ── Reset to Standard Baseline ──
        const resetBtn = root.querySelector('[data-fitting-reset-btn]');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                if (heightInput) heightInput.value = 170;
                if (chestInput) chestInput.value = 92;
                if (waistInput) waistInput.value = 76;
                if (hipInput) hipInput.value = 96;
                if (shoulderInput) shoulderInput.value = 44;
                if (armLengthInput) armLengthInput.value = 58;
                if (torsoLengthInput) torsoLengthInput.value = 44;
                for (const radio of torsoTypeRadios) {
                    radio.checked = radio.value === 'normal';
                }
                clearSavedProfile();
                userManuallySelectedSize = false;
                updateBody();
            });
        }


        // ── Debug Listeners ──
        const debugScale = document.getElementById('debug-scale');
        const debugScaleVal = document.getElementById('debug-scale-val');
        const debugY = document.getElementById('debug-y');
        const debugYVal = document.getElementById('debug-y-val');
        const debugZ = document.getElementById('debug-z');
        const debugZVal = document.getElementById('debug-z-val');

        if (debugScale && debugY && debugZ) {
            const updateDebugTransform = () => {
                if (!currentGarmentWrapper) return;
                const scale = parseFloat(debugScale.value);
                const yOffset = parseFloat(debugY.value);
                const zOffset = parseFloat(debugZ.value);
                
                debugScaleVal.textContent = scale.toFixed(2);
                debugYVal.textContent = yOffset.toFixed(2);
                debugZVal.textContent = zOffset.toFixed(2);
                
                // Re-trigger dynamic fitting to respect dynamic scaling instead of overriding absolute transforms
                const product = findProduct(selectedProductId) || catalog[0];
                recalculateFit(product);
            };

            debugScale.addEventListener('input', updateDebugTransform);
            debugY.addEventListener('input', updateDebugTransform);
            debugZ.addEventListener('input', updateDebugTransform);
        }

        // (productSelect listener removed)

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

                const product = findProduct(selectedProductId) || catalog[0];
                recalculateFit(product);
            });
        });

        // ── Initial Setup ──
        const urlParams = new URLSearchParams(window.location.search);
        const urlProductId = urlParams.get('product');
        let initialProduct = catalog.find(p => String(p.id) === String(urlProductId)) || catalog[0];
        
        selectedProductId = initialProduct ? initialProduct.id : null;
        renderProductList();
        
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