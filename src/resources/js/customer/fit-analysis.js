/**
 * DEMO FIT ANALYSIS
 *
 * Placeholder only — not physically or medically accurate.
 * Replace `analyzeFit()` with a real fitting algorithm when one exists.
 * Do not persist these values; they are frontend session state.
 */
export function analyzeFit({ heightCm, weightKg, sizes }) {
    const height = Number(heightCm) || 170;
    const weight = Number(weightKg) || 68;
    const available = Array.isArray(sizes) ? sizes : [];

    if (available.length === 0) {
        return {
            recommendedSize: null,
            overallMatch: 'Unavailable',
            heatmap: [
                { area: 'Shoulders', state: 'Perfect Fit' },
                { area: 'Chest', state: 'Perfect Fit' },
                { area: 'Waist', state: 'Perfect Fit' },
                { area: 'Sleeves', state: 'Perfect Fit' },
            ],
        };
    }

    const bmi = weight / (height / 100) ** 2;
    const estimatedChest = 48 + (bmi - 22) * 1.6 + (height - 170) * 0.06;
    const estimatedShoulder = estimatedChest * 0.82;
    const estimatedWaist = estimatedChest * 0.9;
    const estimatedSleeve = 20 + (height - 160) * 0.35;

    const scored = available.map((size) => {
        const chest = Number(size.lebar_dada) || estimatedChest;
        const delta = Math.abs(chest - estimatedChest);
        return { size, delta };
    });

    scored.sort((a, b) => a.delta - b.delta);
    const recommended = scored[0]?.size ?? available[0];

    const classify = (estimated, measured) => {
        if (measured == null) {
            return 'Perfect Fit';
        }
        const ratio = estimated / measured;
        if (ratio > 1.06) {
            return 'Too Tight';
        }
        if (ratio < 0.92) {
            return 'Too Loose';
        }
        return 'Perfect Fit';
    };

    const heatmap = [
        { area: 'Shoulders', state: classify(estimatedShoulder, Number(recommended.lebar_bahu) || null) },
        { area: 'Chest', state: classify(estimatedChest, Number(recommended.lebar_dada) || null) },
        { area: 'Waist', state: classify(estimatedWaist, Number(recommended.lebar_dada) * 0.92 || null) },
        { area: 'Sleeves', state: classify(estimatedSleeve, Number(recommended.panjang_lengan) || null) },
    ];

    const perfectCount = heatmap.filter((item) => item.state === 'Perfect Fit').length;
    const overallMatch = `${Math.round((perfectCount / heatmap.length) * 100)}%`;

    return {
        recommendedSize: recommended.name,
        overallMatch,
        heatmap,
    };
}
