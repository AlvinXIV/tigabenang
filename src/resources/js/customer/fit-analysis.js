/**
 * DEMO FIT ANALYSIS
 *
 * Placeholder only — not physically or medically accurate.
 * Replace `analyzeFit()` with a real fitting algorithm when one exists.
 * Do not persist these values; they are frontend session state.
 */

/**
 * Disclaimer yang harus ditampilkan bersama hasil analisis.
 */
export const FIT_DISCLAIMER =
    'Demo estimate — replaceable algorithm, not a physical measurement.';

/**
 * Klasifikasi fit berdasarkan rasio customer/garment.
 *
 * @param {number} customerValue – Ukuran customer
 * @param {number|null} garmentValue – Ukuran garment
 * @returns {'Too Tight'|'Perfect Fit'|'Too Loose'}
 */
function classify(customerValue, garmentValue) {
    if (garmentValue == null || garmentValue <= 0) {
        return 'Perfect Fit';
    }

    const ratio = customerValue / garmentValue;

    if (ratio > 1.06) {
        return 'Too Tight';
    }

    if (ratio < 0.92) {
        return 'Too Loose';
    }

    return 'Perfect Fit';
}

/**
 * Analisis fit antara body measurements customer dan size chart garment.
 *
 * @param {object} params
 * @param {number|string} params.heightCm    – Tinggi badan (cm)
 * @param {number|string} params.chestCm     – Lingkar dada (cm)
 * @param {number|string} params.waistCm     – Lingkar pinggang (cm)
 * @param {number|string} params.hipCm       – Lingkar pinggul (cm)
 * @param {number|string} params.shoulderCm  – Lebar bahu (cm)
 * @param {Array}         params.sizes       – Array size chart [{name, lebar_dada, panjang, lebar_bahu, panjang_lengan}]
 * @returns {{recommendedSize: string|null, overallMatch: string, heatmap: Array}}
 */
export function analyzeFit({
    heightCm,
    chestCm,
    waistCm,
    hipCm,
    shoulderCm,
    sizes,
}) {
    const height = Number(heightCm) || 170;
    const chest = Number(chestCm) || 92;
    const waist = Number(waistCm) || 76;
    const hip = Number(hipCm) || 96;
    const shoulder = Number(shoulderCm) || 44;

    const available = Array.isArray(sizes)
        ? sizes
        : [];

    // ─────────────────────────────────────────────────────────
    // NO SIZES AVAILABLE
    // ─────────────────────────────────────────────────────────

    if (available.length === 0) {
        return {
            recommendedSize: null,
            overallMatch: 'Unavailable',
            heatmap: [],
        };
    }

    // ─────────────────────────────────────────────────────────
    // CUSTOMER MEASUREMENTS (half = flat equivalent)
    // ─────────────────────────────────────────────────────────

    const halfChest = chest / 2;
    const halfWaist = waist / 2;
    const halfHip = hip / 2;

    // Use actual shoulder half-width.
    const halfShoulder = shoulder / 2;

    const estSleeve =
        20 + (height - 160) * 0.35;

    // Estimasi panjang garment yang diinginkan.
    const estLength = height * 0.40;

    // ─────────────────────────────────────────────────────────
    // FIND BEST MATCHING SIZE (by chest width)
    // ─────────────────────────────────────────────────────────

    const scored = available.map(
        (size) => {
            const garmentChest =
                Number(size.lebar_dada) || null;

            if (garmentChest === null) {
                return { size, delta: 999 };
            }

            const delta = Math.abs(
                garmentChest - halfChest,
            );

            return { size, delta };
        },
    );

    scored.sort(
        (a, b) => a.delta - b.delta,
    );

    const recommended =
        scored[0]?.size ?? available[0];

    // ─────────────────────────────────────────────────────────
    // GARMENT MEASUREMENTS
    // ─────────────────────────────────────────────────────────

    const garmentChest =
        Number(recommended.lebar_dada) || null;

    const garmentShoulder =
        Number(recommended.lebar_bahu) || null;

    const garmentSleeve =
        Number(recommended.panjang_lengan) ||
        null;

    const garmentLength =
        Number(recommended.panjang) || null;

    // Estimasi waist dan hip dari chest width.
    const garmentWaist = garmentChest
        ? garmentChest * 0.88
        : null;

    const garmentHip = garmentChest
        ? garmentChest * 1.02
        : null;

    // ─────────────────────────────────────────────────────────
    // HEATMAP
    // ─────────────────────────────────────────────────────────

    const heatmap = [
        {
            area: 'Chest',
            state: classify(
                halfChest,
                garmentChest,
            ),
        },
        {
            area: 'Shoulder',
            state: classify(
                halfShoulder,
                garmentShoulder,
            ),
        },
        {
            area: 'Waist',
            state: classify(
                halfWaist,
                garmentWaist,
            ),
        },
        {
            area: 'Hip',
            state: classify(
                halfHip,
                garmentHip,
            ),
        },
        {
            area: 'Sleeve',
            state: classify(
                estSleeve,
                garmentSleeve,
            ),
        },
        {
            area: 'Length',
            state: classify(
                estLength,
                garmentLength,
            ),
        },
    ];

    // ─────────────────────────────────────────────────────────
    // OVERALL MATCH
    // ─────────────────────────────────────────────────────────

    const tightCount = heatmap.filter(
        (i) => i.state === 'Too Tight',
    ).length;

    const looseCount = heatmap.filter(
        (i) => i.state === 'Too Loose',
    ).length;

    const perfectCount = heatmap.filter(
        (i) => i.state === 'Perfect Fit',
    ).length;

    let overallMatch;

    if (perfectCount >= 4) {
        overallMatch = 'Perfect Fit';
    } else if (tightCount >= 3) {
        overallMatch = 'Too Tight';
    } else if (looseCount >= 3) {
        overallMatch = 'Too Loose';
    } else {
        overallMatch = `${Math.round((perfectCount / heatmap.length) * 100)}% Match`;
    }

    return {
        recommendedSize:
            recommended.name ?? null,
        overallMatch,
        heatmap,
    };
}
