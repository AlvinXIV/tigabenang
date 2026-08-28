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
                    <label style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem 1rem;background:#FFFFFF;border:1.5px solid ${checked ? '#FC563C' : '#DCD6D0'};border-radius:0.625rem;font-size:0.875rem;font-weight:600;color:#172A39;cursor:pointer;transition:all 0.15s;">
                        <input type="checkbox" name="materials[]" value="${material.id}" style="accent-color:#FC563C;width:1rem;height:1rem;" ${checked ? 'checked' : ''}>
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
                <div
                    class="request-size-row"
                    data-ukuran-id="${size.id}"
                    style="display:flex;align-items:center;justify-content:space-between;gap:1.5rem;min-height:5.25rem;padding:1.25rem 1.75rem;background:#FFFFFF;${index < product.sizes.length - 1 ? 'border-bottom:1px solid #DCD6D0;' : ''}"
                >
                    <input type="hidden" name="sizes[${index}][ukuran_id]" value="${size.id}">
                    <label style="font-size:0.9375rem;font-weight:700;color:#172A39;cursor:pointer;" for="qty-${size.id}">${size.name}</label>
                    <input
                        id="qty-${size.id}"
                        type="number"
                        min="0"
                        step="1"
                        inputmode="numeric"
                        data-order-qty
                        name="sizes[${index}][kuantitas]"
                        value="${qty[String(size.id)] ?? 0}"
                        style="width:6.5rem;min-height:2.75rem;border:1.5px solid #DCD6D0;border-radius:0.625rem;background:#F6F4F1;padding:0.625rem 0.875rem;font-size:0.9375rem;font-weight:700;color:#172A39;text-align:right;outline:none;"
                        onfocus="this.style.borderColor='#FC563C';this.style.background='#FFFFFF';"
                        onblur="this.style.borderColor='#DCD6D0';this.style.background='#F6F4F1';"
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
