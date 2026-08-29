import { analyzeFit } from './fit-analysis';

const waitForVisible = (element) => {
    if (!element || typeof IntersectionObserver === 'undefined') {
        return Promise.resolve();
    }

    const rect = element.getBoundingClientRect();

    if (
        rect.bottom > 0 &&
        rect.top < (window.innerHeight || 800) + 80
    ) {
        return Promise.resolve();
    }

    return new Promise((resolve) => {
        const observer = new IntersectionObserver(
            (entries) => {
                if (
                    entries.some(
                        (entry) => entry.isIntersecting
                    )
                ) {
                    observer.disconnect();
                    resolve();
                }
            },
            {
                rootMargin: '80px',
            },
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
        return JSON.parse(
            node.textContent || '[]',
        );
    } catch {
        return [];
    }
};

const numberValue = (input, fallback = 0) => {
    const value = Number(input?.value);

    return Number.isFinite(value)
        ? value
        : fallback;
};

const PROFILE_KEY =
    'fitvendor-body-profile';

const loadSavedProfile = () => {
    try {
        return JSON.parse(
            localStorage.getItem(
                PROFILE_KEY,
            ),
        );
    } catch {
        return null;
    }
};

const saveProfile = (inputs) => {
    try {
        localStorage.setItem(
            PROFILE_KEY,
            JSON.stringify(inputs),
        );
    } catch {
        // localStorage unavailable
    }
};

const initFitting = async () => {
    const root =
        document.querySelector(
            '[data-fitting-root]',
        );

    if (!root) {
        return;
    }

    // =========================================================
    // CATALOG
    // =========================================================

    const catalog = parseJsonScript(
        root,
        '[data-fitting-catalog]',
    );

    // =========================================================
    // THREE.JS VIEWPORT
    // =========================================================

    const viewport =
        document.getElementById(
            'fitting-viewport',
        );

    // =========================================================
    // PRODUCT
    // =========================================================

    const productSelect =
        root.querySelector(
            '[data-fitting-product]',
        );

    const nameNode =
        root.querySelector(
            '[data-fitting-name]',
        );

    const categoryNode =
        root.querySelector(
            '[data-fitting-category]',
        );

    const sizesNode =
        root.querySelector(
            '[data-fitting-sizes]',
        );

    // =========================================================
    // FIT ANALYSIS
    // =========================================================

    const sizeNode =
        root.querySelector(
            '[data-fitting-size]',
        );

    const matchNode =
        root.querySelector(
            '[data-fitting-match]',
        );

    const heatmapNode =
        root.querySelector(
            '[data-fitting-heatmap]',
        );

    // =========================================================
    // BODY INPUTS
    // =========================================================

    const heightInput =
        root.querySelector(
            '[data-fitting-height]',
        );

    const chestInput =
        root.querySelector(
            '[data-fitting-chest]',
        );

    const waistInput =
        root.querySelector(
            '[data-fitting-waist]',
        );

    const hipInput =
        root.querySelector(
            '[data-fitting-hip]',
        );

    const shoulderInput =
        root.querySelector(
            '[data-fitting-shoulder]',
        );

    const armLengthInput =
        root.querySelector(
            '[data-fitting-arm-length]',
        );

    const torsoLengthInput =
        root.querySelector(
            '[data-fitting-torso-length]',
        );

    const torsoTypeRadios =
        root.querySelectorAll(
            '[data-fitting-torso-type]',
        );

    // =========================================================
    // HELPER: GET TORSO TYPE
    // =========================================================

    const getTorsoType = () => {
        for (const radio of torsoTypeRadios) {
            if (radio.checked) {
                return radio.value;
            }
        }

        return 'normal';
    };

    // =========================================================
    // RESTORE SAVED MEASUREMENTS
    // =========================================================

    const saved = loadSavedProfile();

    if (saved) {
        if (heightInput && saved.height != null)
            heightInput.value = saved.height;
        if (chestInput && saved.chest != null)
            chestInput.value = saved.chest;
        if (waistInput && saved.waist != null)
            waistInput.value = saved.waist;
        if (hipInput && saved.hip != null)
            hipInput.value = saved.hip;
        if (shoulderInput && saved.shoulder != null)
            shoulderInput.value = saved.shoulder;
        if (armLengthInput && saved.armLength != null)
            armLengthInput.value = saved.armLength;
        if (torsoLengthInput && saved.torsoLength != null)
            torsoLengthInput.value = saved.torsoLength;

        if (saved.torsoType) {
            for (const radio of torsoTypeRadios) {
                radio.checked =
                    radio.value ===
                    saved.torsoType;
            }
        }
    }

    // =========================================================
    // STATUS
    // =========================================================

    const statusNode =
        root.querySelector(
            '[data-fitting-status]',
        );

    // =========================================================
    // TABS
    // =========================================================

    const tabs =
        root.querySelectorAll(
            '[data-fitting-tab]',
        );

    const panels =
        root.querySelectorAll(
            '[data-fitting-panel]',
        );

    // =========================================================
    // VALIDATION
    // =========================================================

    if (!viewport) {
        return;
    }

    await waitForVisible(viewport);

    // =========================================================
    // THREE.JS
    // =========================================================

    let studio;
    let avatar = null;

    try {
        const [
            { createFittingScene },
            { createAvatar, updateAvatar },
        ] = await Promise.all([
            import('../three/scene'),
            import('../three/avatar'),
        ]);

        studio =
            createFittingScene(viewport);

        // =====================================================
        // COLLECT BODY PARAMS
        // =====================================================

        const getBodyParams = () => ({
            height: numberValue(
                heightInput,
                170,
            ),

            chest: numberValue(
                chestInput,
                92,
            ),

            waist: numberValue(
                waistInput,
                76,
            ),

            hip: numberValue(
                hipInput,
                96,
            ),

            shoulder: numberValue(
                shoulderInput,
                44,
            ),

            armLength: numberValue(
                armLengthInput,
                58,
            ),

            torsoLength: numberValue(
                torsoLengthInput,
                44,
            ),

            torsoType: getTorsoType(),
        });

        // =====================================================
        // CREATE INITIAL AVATAR
        // =====================================================

        avatar = createAvatar(
            getBodyParams(),
        );

        studio.scene.add(avatar);

        statusNode.textContent =
            'Virtual fitting ready';

        // =====================================================
        // BODY UPDATE FUNCTION
        // =====================================================

        const updateBody = () => {
            if (!avatar) {
                return;
            }

            const newAvatar =
                updateAvatar(
                    avatar,
                    getBodyParams(),
                );

            if (newAvatar) {
                avatar = newAvatar;
            }

            statusNode.textContent =
                'Body profile updated';
        };

        // =====================================================
        // SAVE HELPER
        // =====================================================

        const doSave = () => {
            const p = getBodyParams();

            saveProfile(p);
        };

        // =====================================================
        // INPUT EVENTS
        // =====================================================

        const bodyInputs = [
            heightInput,
            chestInput,
            waistInput,
            hipInput,
            shoulderInput,
            armLengthInput,
            torsoLengthInput,
        ];

        bodyInputs.forEach((input) => {
            if (!input) {
                return;
            }

            input.addEventListener(
                'input',
                () => {
                    updateBody();

                    doSave();

                    updateAnalysis(
                        findProduct(
                            productSelect?.value,
                        ),
                    );
                },
            );
        });

        // Torso type radios
        torsoTypeRadios.forEach(
            (radio) => {
                radio.addEventListener(
                    'change',
                    () => {
                        updateBody();

                        doSave();

                        updateAnalysis(
                            findProduct(
                                productSelect?.value,
                            ),
                        );
                    },
                );
            },
        );

        // =====================================================
        // PRODUCT HELPER
        // =====================================================

        const findProduct = (id) => {
            return catalog.find(
                (item) =>
                    String(item.id) ===
                    String(id),
            );
        };

        // =====================================================
        // HEATMAP
        // =====================================================

        const renderHeatmap = (
            heatmap,
        ) => {
            if (!heatmapNode) {
                return;
            }

            heatmapNode.innerHTML =
                heatmap
                    .map(
                        (item) => `
                            <li class="flex items-center justify-between border-b border-line py-3">
                                <span class="text-sm">
                                    ${item.area}
                                </span>

                                <span
                                    class="text-[11px] uppercase tracking-[0.16em]"
                                    style="color:${
                                        stateColors[
                                            item.state
                                        ] ||
                                        '#2c2622'
                                    }"
                                >
                                    ${item.state}
                                </span>
                            </li>
                        `,
                    )
                    .join('');
        };

        // =====================================================
        // FIT ANALYSIS
        // =====================================================

        const updateAnalysis = (
            product,
        ) => {
            if (!sizeNode || !matchNode) {
                return;
            }

            // Kalau belum ada produk,
            // jangan lakukan analisis.
            if (!product) {
                sizeNode.textContent =
                    '—';

                matchNode.textContent =
                    '—';

                if (heatmapNode) {
                    heatmapNode.innerHTML =
                        '';
                }

                return;
            }

            const p = getBodyParams();

            const result =
                analyzeFit({
                    heightCm: p.height,

                    chestCm: p.chest,

                    waistCm: p.waist,

                    hipCm: p.hip,

                    shoulderCm:
                        p.shoulder,

                    sizes:
                        product?.sizes ||
                        [],
                });

            sizeNode.textContent =
                result.recommendedSize ||
                '—';

            matchNode.textContent =
                result.overallMatch ||
                '—';

            renderHeatmap(
                result.heatmap ||
                [],
            );

            if (sizesNode) {
                sizesNode.textContent =
                    (
                        product?.sizes ||
                        []
                    )
                        .map(
                            (size) =>
                                size.name,
                        )
                        .join(' · ') ||
                    'No sizes for this category';
            }
        };

        // =====================================================
        // GARMENT
        // =====================================================

        const applyProduct = async (
            product,
        ) => {
            if (!product) {
                return;
            }

            if (nameNode) {
                nameNode.textContent =
                    product.name;
            }

            if (categoryNode) {
                categoryNode.textContent =
                    product.category ||
                    '';
            }

            updateAnalysis(
                product,
            );

            // =================================================
            // NO GARMENT
            // =================================================

            if (!product.modelUrl) {
                studio.garmentGroup.clear();

                statusNode.textContent =
                    'Virtual body ready — no garment selected';

                return;
            }

            // =================================================
            // LOAD GARMENT
            // =================================================

            statusNode.textContent =
                'Loading garment...';

            try {
                const {
                    loadGarment,
                } = await import(
                    '../three/garment'
                );

                await loadGarment(
                    product.modelUrl,
                    studio.garmentGroup,
                );

                statusNode.textContent =
                    'Virtual fitting ready';
            } catch (error) {
                console.error(
                    'Failed to load garment:',
                    error,
                );

                studio.garmentGroup.clear();

                statusNode.textContent =
                    'Could not load the 3D garment';
            }
        };

        // =====================================================
        // PRODUCT SELECT
        // =====================================================

        if (productSelect) {
            productSelect.addEventListener(
                'change',
                () => {
                    const product =
                        findProduct(
                            productSelect.value,
                        );

                    applyProduct(
                        product,
                    );
                },
            );
        }

        // =====================================================
        // TABS
        // =====================================================

        tabs.forEach((tab) => {
            tab.addEventListener(
                'click',
                () => {
                    const selected =
                        tab.dataset
                            .fittingTab;

                    tabs.forEach(
                        (item) => {
                            const active =
                                item ===
                                tab;

                            item.setAttribute(
                                'aria-selected',
                                active
                                    ? 'true'
                                    : 'false',
                            );

                            item.classList.toggle(
                                'text-terracotta',
                                active,
                            );

                            item.classList.toggle(
                                'text-muted',
                                !active,
                            );
                        },
                    );

                    panels.forEach(
                        (panel) => {
                            panel.classList.toggle(
                                'hidden',
                                panel.dataset
                                    .fittingPanel !==
                                    selected,
                            );
                        },
                    );
                },
            );
        });

        // =====================================================
        // INITIAL PRODUCT
        // =====================================================

        const initialProduct =
            productSelect
                ? findProduct(
                      productSelect.value,
                  ) || catalog[0]
                : null;

        await applyProduct(
            initialProduct,
        );

        // =====================================================
        // CLEANUP
        // =====================================================

        window.addEventListener(
            'beforeunload',
            () => {
                studio?.dispose();
            },
            {
                once: true,
            },
        );
    } catch (error) {
        console.error(
            'Virtual fitting initialization failed:',
            error,
        );

        if (statusNode) {
            statusNode.textContent =
                '3D studio unavailable';
        }
    }
};

document.addEventListener(
    'DOMContentLoaded',
    () => {
        initFitting();
    },
);