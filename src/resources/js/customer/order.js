const formatRupiah = (value) =>
    `Rp ${Math.round(Number(value) || 0).toLocaleString('id-ID')}`;

const readJson = (root, selector, fallback) => {
    const node = root.querySelector(selector);
    if (!node) {
        return fallback;
    }

    try {
        return JSON.parse(node.textContent || 'null') ?? fallback;
    } catch {
        return fallback;
    }
};

const initOrderForm = () => {
    const form = document.querySelector('[data-order-form]');
    if (!form || form.dataset.orderBound === 'true') {
        return;
    }

    form.dataset.orderBound = 'true';

    const catalog = readJson(form, '[data-order-catalog]', []);
    const categories = readJson(form, '[data-order-categories]', []);
    const oldState = readJson(form, '[data-order-old]', { materials: [], sizes: [] });
    const categorySelect = form.querySelector('[data-order-category]');
    const productSelect = form.querySelector('[data-order-product]');
    const unitPriceNode = document.getElementById('category-unit-price');
    const materialsRoot = form.querySelector('[data-order-materials]');
    const sizesRoot = form.querySelector('[data-order-sizes]');
    const totalNode = form.querySelector('[data-order-total]');

    let preferredMaterials = new Set((oldState.materials || []).map(String));
    const preferredQty = {};
    (oldState.sizes || []).forEach((row) => {
        if (row?.ukuran_id != null) {
            preferredQty[String(row.ukuran_id)] = row.kuantitas ?? 0;
        }
    });

    const findCategory = (id) => categories.find((item) => String(item.id) === String(id));

    const activeCategory = () => findCategory(categorySelect?.value) ?? categories[0];

    const categoryPrice = () => {
        const fromOption = Number(categorySelect?.selectedOptions?.[0]?.dataset?.price);
        if (Number.isFinite(fromOption) && fromOption >= 0) {
            return fromOption;
        }
        return Number(activeCategory()?.price) || 0;
    };

    const currentQtyMap = () => {
        const map = { ...preferredQty };
        sizesRoot?.querySelectorAll('[data-ukuran-id]').forEach((row) => {
            map[row.dataset.ukuranId] = row.querySelector('input[type="number"]')?.value ?? 0;
        });
        return map;
    };

    const renderMaterials = (category) => {
        if (!materialsRoot) {
            return;
        }

        const materials = category?.materials ?? [];

        if (!materials.length) {
            materialsRoot.innerHTML = '';
            return;
        }

        const selected = preferredMaterials.size
            ? preferredMaterials
            : new Set(Array.from(form.querySelectorAll('input[name="materials[]"]:checked')).map((input) => input.value));

        materialsRoot.innerHTML = materials
            .map((material) => {
                const checked = selected.has(String(material.id));
                return `
                    <label style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem 1rem;background:#FFFFFF;border:1px solid ${checked ? '#1C2430' : '#E2E5E9'};border-radius:10px;font-size:0.875rem;font-weight:600;color:#1C2430;cursor:pointer;transition:all 0.15s;">
                        <input type="checkbox" name="materials[]" value="${material.id}" style="accent-color:#1C2430;width:1rem;height:1rem;" ${checked ? 'checked' : ''}>
                        <span>${material.name}</span>
                    </label>
                `;
            })
            .join('');

        if (!materialsRoot.querySelector('input:checked')) {
            const first = materialsRoot.querySelector('input[type="checkbox"]');
            if (first) {
                first.checked = true;
            }
        }
    };

    const renderSizes = (sizes) => {
        if (!sizesRoot) {
            return;
        }

        const qty = currentQtyMap();
        const rows = sizes ?? [];

        if (!rows.length) {
            sizesRoot.innerHTML = '<p style="padding:1rem 1.25rem;font-size:0.875rem;color:#667085;">Ukuran untuk kategori ini belum diatur.</p>';
            return;
        }

        sizesRoot.innerHTML = rows
            .map(
                (size, index) => `
                <div
                    class="request-size-row"
                    data-ukuran-id="${size.id}"
                    style="display:flex;align-items:center;justify-content:space-between;height:68px;min-height:68px;padding:0 16px;background:#FFFFFF;${index < rows.length - 1 ? 'border-bottom:1px solid #E2E5E9;' : ''}"
                >
                    <input type="hidden" name="sizes[${index}][ukuran_id]" value="${size.id}">
                    <label style="font-size:0.9375rem;font-weight:600;color:#1C2430;cursor:pointer;" for="qty-${size.id}">${size.name}</label>
                    <input
                        id="qty-${size.id}"
                        type="number"
                        min="0"
                        step="1"
                        inputmode="numeric"
                        data-order-qty
                        name="sizes[${index}][kuantitas]"
                        value="${qty[String(size.id)] ?? 0}"
                        style="width:96px;height:42px;min-height:42px;border:1px solid #E2E5E9;border-radius:8px;background:#FFFFFF;padding:0 0.5rem;font-size:0.9375rem;font-weight:600;color:#1C2430;text-align:center;outline:none;"
                        onfocus="this.style.borderColor='#1C2430';this.style.background='#FFFFFF';"
                        onblur="this.style.borderColor='#E2E5E9';this.style.background='#FFFFFF';"
                    >
                </div>
            `,
            )
            .join('');
    };

    const updateTotal = () => {
        const price = categoryPrice();

        if (unitPriceNode) {
            unitPriceNode.textContent = formatRupiah(price);
        }

        if (!totalNode) {
            return;
        }

        const quantity = [...form.querySelectorAll('[data-order-qty], input[name*="[kuantitas]"]')].reduce(
            (sum, input) => sum + Math.max(0, Number(input.value) || 0),
            0,
        );

        totalNode.textContent = formatRupiah(price * quantity);
    };

    const render = () => {
        const category = activeCategory();

        if (productSelect && category) {
            const prodId = categorySelect?.selectedOptions?.[0]?.dataset?.productId || category.product_id || '';
            if (prodId) {
                productSelect.value = String(prodId);
            }
        }

        if (unitPriceNode) {
            unitPriceNode.textContent = formatRupiah(categoryPrice());
        }

        renderSizes(category?.sizes);
        renderMaterials(category);
        updateTotal();
    };

    categorySelect?.addEventListener('change', () => {
        preferredMaterials = new Set();
        render();
    });

    form.addEventListener('input', updateTotal);
    form.addEventListener('change', (event) => {
        if (event.target.matches('[data-order-qty], input[name*="[kuantitas]"]')) {
            updateTotal();
        }
    });

    form.addEventListener('submit', () => {
        const category = activeCategory();
        if (productSelect && (!productSelect.value || productSelect.value === '')) {
            const prodId = categorySelect?.selectedOptions?.[0]?.dataset?.productId || category?.product_id || '';
            if (prodId) {
                productSelect.value = String(prodId);
            }
        }
    });

    render();

    window.FitVendorOrder = {
        change(categoryIdOrProductId) {
            const category = categories.find((item) =>
                String(item.id) === String(categoryIdOrProductId) ||
                String(item.product_id) === String(categoryIdOrProductId)
            );

            if (categorySelect && category) {
                categorySelect.value = String(category.id);
            }

            preferredMaterials = new Set();
            render();

            return Boolean(category);
        },
    };
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initOrderForm);
} else {
    initOrderForm();
}
