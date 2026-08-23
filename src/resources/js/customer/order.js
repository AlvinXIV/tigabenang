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
    const oldState = readJson(form, '[data-order-old]', { materials: [], sizes: [] });
    const productSelect = form.querySelector('[data-order-product]');
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

    const findProduct = (id) => catalog.find((item) => String(item.id) === String(id));

    const currentQtyMap = () => {
        const map = { ...preferredQty };
        sizesRoot.querySelectorAll('[data-ukuran-id]').forEach((row) => {
            map[row.dataset.ukuranId] = row.querySelector('input[type="number"]')?.value ?? 0;
        });
        return map;
    };

    const renderMaterials = (product) => {
        const selected = preferredMaterials.size
            ? preferredMaterials
            : new Set(Array.from(form.querySelectorAll('input[name="materials[]"]:checked')).map((input) => input.value));

        materialsRoot.innerHTML = product.materials
            .map((material) => {
                const checked = selected.has(String(material.id));
                return `
                    <label class="flex items-center gap-3 border border-line px-4 py-3 text-sm">
                        <input type="checkbox" name="materials[]" value="${material.id}" class="accent-terracotta" ${checked ? 'checked' : ''}>
                        <span>${material.name}</span>
                    </label>
                `;
            })
            .join('');

        if (!materialsRoot.querySelector('input:checked') && product.materials[0]) {
            materialsRoot.querySelector('input[type="checkbox"]').checked = true;
        }
    };

    const renderSizes = (product) => {
        const qty = currentQtyMap();
        sizesRoot.innerHTML = product.sizes
            .map(
                (size, index) => `
                <div class="flex items-center justify-between gap-4 py-4" data-ukuran-id="${size.id}">
                    <input type="hidden" name="sizes[${index}][ukuran_id]" value="${size.id}">
                    <label class="text-sm tracking-[0.12em]" for="qty-${size.id}">${size.name}</label>
                    <input
                        id="qty-${size.id}"
                        type="number"
                        min="0"
                        step="1"
                        inputmode="numeric"
                        data-order-qty
                        name="sizes[${index}][kuantitas]"
                        value="${qty[String(size.id)] ?? 0}"
                        class="w-24 border-b border-line bg-transparent py-2 text-right"
                    >
                </div>
            `,
            )
            .join('');
    };

    const updateTotal = () => {
        if (typeof window.updateOrderEstimate === 'function') {
            window.updateOrderEstimate();
            return;
        }

        const product = findProduct(productSelect.value);
        if (!product || !totalNode) {
            return;
        }

        const quantity = [...form.querySelectorAll('[data-order-qty], input[name*="[kuantitas]"]')].reduce(
            (sum, input) => sum + Math.max(0, Number(input.value) || 0),
            0,
        );

        totalNode.textContent = formatRupiah(product.price * quantity);
    };

    const render = () => {
        const product = findProduct(productSelect.value);
        if (!product) {
            return;
        }

        renderMaterials(product);
        renderSizes(product);
        updateTotal();
    };

    productSelect.addEventListener('change', () => {
        preferredMaterials = new Set();
        render();
    });

    form.addEventListener('input', updateTotal);
    form.addEventListener('change', (event) => {
        if (event.target.matches('[data-order-qty], input[name*="[kuantitas]"], [data-order-product]')) {
            updateTotal();
        }
    });

    render();

    window.FitVendorOrder = {
        change(productId) {
            if (String(productSelect.value) !== String(productId)) {
                productSelect.value = productId;
            }

            preferredMaterials = new Set();
            render();

            return true;
        },
    };
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initOrderForm);
} else {
    initOrderForm();
}
