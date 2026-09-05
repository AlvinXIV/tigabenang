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
 * @param {string} area - Area pengukuran (Dada, Panjang, dll)
 * @returns {'Kekecilan'|'Sangat Pas'|'Kebesaran'}
 */
function classify(customerValue, garmentValue, area) {
    if (garmentValue == null || garmentValue <= 0) {
        return 'Sangat Pas';
    }

    const ratio = customerValue / garmentValue;
    
    let maxRatio = 1.05;
    let minRatio = 0.85;

    // Untuk lingkar (Dada, Pinggang, Pinggul), butuh ruang gerak (ease).
    // Baju yang ukurannya sama dengan badan (ratio 1.0) sudah pasti ketat/kekecilan.
    if (area === 'Dada' || area === 'Pinggang' || area === 'Pinggul') {
        maxRatio = 0.98;
        minRatio = 0.82;
    }

    if (ratio > maxRatio) {
        return 'Kekecilan';
    }

    if (ratio < minRatio) {
        return 'Kebesaran';
    }

    return 'Sangat Pas';
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
    selectedSizeName,
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
            overallMatch: 'Tidak Tersedia',
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

    // Find target size for heatmap (use selected size if provided, otherwise recommended)
    const targetSize = selectedSizeName
        ? (available.find(s => s.name === selectedSizeName) || recommended)
        : recommended;

    // ─────────────────────────────────────────────────────────
    // GARMENT MEASUREMENTS
    // ─────────────────────────────────────────────────────────

    const garmentChest =
        Number(targetSize.lebar_dada) || null;

    const garmentShoulder =
        Number(targetSize.lebar_bahu) || null;

    const garmentSleeve =
        Number(targetSize.panjang_lengan) ||
        null;

    const garmentLength =
        Number(targetSize.panjang) || null;

    // Estimasi waist dan hip dari chest width (potongan lurus seperti Jersey/Kaos)
    const garmentWaist = garmentChest
        ? garmentChest * 1.0
        : null;

    const garmentHip = garmentChest
        ? garmentChest * 1.0
        : null;

    // ─────────────────────────────────────────────────────────
    // HEATMAP
    // ─────────────────────────────────────────────────────────

    const heatmap = [
        {
            area: 'Dada',
            state: classify(halfChest, garmentChest, 'Dada'),
        },
        {
            area: 'Bahu',
            state: classify(halfShoulder, garmentShoulder, 'Bahu'),
        },
        {
            area: 'Pinggang',
            state: classify(halfWaist, garmentWaist, 'Pinggang'),
        },
        {
            area: 'Pinggul',
            state: classify(halfHip, garmentHip, 'Pinggul'),
        },
        {
            area: 'Lengan',
            state: classify(estSleeve, garmentSleeve, 'Lengan'),
        },
        {
            area: 'Panjang',
            state: classify(estLength, garmentLength, 'Panjang'),
        },
    ];

    // ─────────────────────────────────────────────────────────
    // OVERALL MATCH
    // ─────────────────────────────────────────────────────────

    const tightCount = heatmap.filter(
        (i) => i.state === 'Kekecilan',
    ).length;

    const looseCount = heatmap.filter(
        (i) => i.state === 'Kebesaran',
    ).length;

    const perfectCount = heatmap.filter(
        (i) => i.state === 'Sangat Pas',
    ).length;

    let overallMatch;

    if (perfectCount >= 4) {
        overallMatch = 'Sangat Pas';
    } else if (tightCount >= 3) {
        overallMatch = 'Kekecilan';
    } else if (looseCount >= 3) {
        overallMatch = 'Kebesaran';
    } else {
        overallMatch = `${Math.round((perfectCount / heatmap.length) * 100)}% Kecocokan`;
    }

    return {
        recommendedSize:
            recommended.name ?? null,
        overallMatch,
        heatmap,
    };
}
