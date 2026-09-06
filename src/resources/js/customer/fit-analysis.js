/**
 * FIT ANALYSIS: SIZE RECOMMENDATION ALGORITHM
 *
 * Menghitung dan memberikan saran ukuran terbaik untuk customer berdasarkan
 * perbandingan ukuran tubuh (tinggi, lingkar dada, lingkar pinggang, lebar bahu, panjang torso)
 * dengan size chart produk yang tersedia.
 */

/**
 * Disclaimer yang harus ditampilkan bersama hasil analisis.
 */
export const FIT_DISCLAIMER =
    'Demo estimate — replaceable algorithm, not a physical measurement.';

/**
 * Analisis saran ukuran antara body measurements customer dan size chart garment.
 *
 * @param {object} params
 * @param {number|string} params.heightCm       – Tinggi badan (cm)
 * @param {number|string} params.chestCm        – Lingkar dada (cm)
 * @param {number|string} params.waistCm        – Lingkar pinggang (cm)
 * @param {number|string} params.hipCm          – Lingkar pinggul (cm)
 * @param {number|string} params.shoulderCm     – Lebar bahu (cm)
 * @param {number|string} params.torsoLengthCm  – Panjang torso (bahu ke pinggang, cm)
 * @param {number|string} params.armLengthCm    – Panjang lengan (cm)
 * @param {Array}         params.sizes          – Array size chart [{name, lebar_dada, panjang, lebar_bahu, panjang_lengan}]
 * @param {string|null}   params.selectedSizeName – Ukuran yang sedang dipilih pengguna
 * @returns {{recommendedSize: string|null, reason: string}}
 */
export function analyzeFit({
    heightCm,
    chestCm,
    waistCm,
    hipCm,
    shoulderCm,
    torsoLengthCm,
    armLengthCm,
    sizes,
    selectedSizeName,
}) {
    const height = Number(heightCm) || 170;
    const chest = Number(chestCm) || 92;
    const waist = Number(waistCm) || 76;
    const hip = Number(hipCm) || 96;
    const shoulder = Number(shoulderCm) || 44;
    const torso = Number(torsoLengthCm) || 44;
    const arm = Number(armLengthCm) || 58;

    const available = Array.isArray(sizes) ? sizes : [];

    if (available.length === 0) {
        return {
            recommendedSize: null,
            reason: 'Ukuran belum tersedia untuk pakaian ini.',
        };
    }

    const halfChest = chest / 2;
    const halfWaist = waist / 2;
    const halfHip = hip / 2;

    // Target panjang pakaian ideal berdasarkan tinggi & torso (menutup panggul dengan pas)
    const targetLength = Math.max(height * 0.41, torso + 24);

    // Hitung skor kesesuaian setiap ukuran baju secara proporsional dan responsif
    const scored = available.map((size) => {
        const gChest = Number(size.lebar_dada) || 50;
        const gLength = Number(size.panjang) || 70;
        const gShoulder = Number(size.lebar_bahu) || 44;

        let penalty = 0;

        // 1. Evaluasi lingkar dada (Kenyamanan kelonggaran dada ideal: 5.5 - 6 cm datar / 11 - 12 cm lingkar)
        const ease = gChest - halfChest;
        if (ease < 0) {
            penalty += 150 + Math.abs(ease) * 50; // Baju lebih kecil dari badan (sesak fisik)
        } else if (ease < 2.5) {
            penalty += 45 + (2.5 - ease) * 30; // Terlalu ketat / ketat menempel
        } else {
            // Deviasi dari kelonggaran kenyamanan normal (6 cm)
            penalty += Math.abs(ease - 6) * 5;
        }

        // 2. Evaluasi lingkar pinggang & pinggul (mencegah sempit di perut / panggul bawah)
        if (halfWaist > gChest) {
            penalty += (halfWaist - gChest) * 40;
        }
        if (halfHip > gChest + 2) {
            penalty += (halfHip - (gChest + 2)) * 30;
        }

        // 3. Evaluasi panjang pakaian & torso (mencegah baju cingkrang atau tenggelam)
        const lenDiff = gLength - targetLength;
        penalty += Math.abs(lenDiff) * 3;
        if (lenDiff < -2) {
            penalty += Math.abs(lenDiff + 2) * 12; // Cingkrang (terlalu pendek)
        } else if (lenDiff > 4) {
            penalty += Math.pow(lenDiff - 4, 1.8) * 10; // Terlalu panjang / kedodoran di badan
        }

        // 4. Evaluasi lebar bahu
        const shDiff = gShoulder - shoulder;
        if (shDiff < 0) {
            // Bahu sempit (fisik menembus). Penalti harus sangat besar agar sistem memaksa upsize
            penalty += 150 + Math.abs(shDiff) * 30; 
        } else if (shDiff > 4) {
            penalty += (shDiff - 4) * 3; // Bahu terlalu turun
        }

        // 5. Evaluasi panjang lengan (jika spesifikasi baju mencantumkan lengan)
        if (size.panjang_lengan && arm > Number(size.panjang_lengan)) {
            penalty += (arm - Number(size.panjang_lengan)) * 6;
        }

        return { size, penalty };
    });

    scored.sort((a, b) => a.penalty - b.penalty);
    const recommended = scored[0]?.size ?? available[0];

    // Penjelasan profesional dan komprehensif berdasarkan keseluruhan input tubuh customer
    let reason = '';
    const recName = recommended.name ?? 'M';

    if (shoulder >= 52) {
        reason = `Ukuran <strong>${recName}</strong> direkomendasikan karena Anda memiliki bahu yang bidang (<strong>${shoulder} cm</strong>), sehingga membutuhkan ukuran yang lebih besar agar bagian bahu tidak sempit atau menembus.`;
    } else if (height >= 185) {
        reason = `Ukuran <strong>${recName}</strong> direkomendasikan berdasarkan tinggi badan (<strong>${height} cm</strong>) dan lingkar dada (<strong>${chest} cm</strong>) agar panjang baju proporsional menutup pinggul dan tidak cingkrang, sekaligus tetap nyaman di bahu dan dada.`;
    } else if (chest >= 105 || waist >= 95) {
        reason = `Ukuran <strong>${recName}</strong> direkomendasikan berdasarkan lingkar dada (<strong>${chest} cm</strong>) dan lingkar pinggang (<strong>${waist} cm</strong>) untuk memberikan ruang gerak leluasa dan nyaman tanpa terasa sesak.`;
    } else if (height <= 165 && chest <= 88) {
        reason = `Ukuran <strong>${recName}</strong> direkomendasikan untuk postur tubuh Anda (Tinggi: <strong>${height} cm</strong>, Dada: <strong>${chest} cm</strong>) agar potongan pakaian jatuh rapi tanpa kedodoran di bahu maupun badan.`;
    } else {
        reason = `Ukuran <strong>${recName}</strong> direkomendasikan berdasarkan analisis proporsi tubuh Anda (Tinggi: <strong>${height} cm</strong>, Dada: <strong>${chest} cm</strong>, Bahu: <strong>${shoulder} cm</strong>) untuk menghasilkan keseimbangan paling pas dan proporsional.`;
    }

    // Analisis perbandingan ukuran aktif yang sedang dicoba customer dengan saran ideal
    const sizeOrder = available.map((s) => s.name);
    const recIndex = sizeOrder.indexOf(recommended.name);
    const activeIndex = sizeOrder.indexOf(selectedSizeName);

    let activeFitNote = '';
    let activeFitStatus = 'ideal';

    if (activeIndex !== -1 && recIndex !== -1) {
        if (activeIndex === recIndex) {
            activeFitStatus = 'ideal';
            activeFitNote = `Ukuran aktif <strong>${selectedSizeName}</strong> adalah saran terbaik yang paling proporsional untuk postur tubuh Anda.`;
        } else if (activeIndex < recIndex) {
            activeFitStatus = 'smaller';
            activeFitNote = `Ukuran aktif <strong>${selectedSizeName}</strong> lebih kecil dari rekomendasi ideal Anda (<strong>${recommended.name}</strong>). Potongan baju akan terasa lebih pas / ketat di badan.`;
        } else {
            activeFitStatus = 'larger';
            activeFitNote = `Ukuran aktif <strong>${selectedSizeName}</strong> lebih besar dari rekomendasi ideal Anda (<strong>${recommended.name}</strong>). Memberikan potongan lebih santai dan longgar (loose-fit / oversized).`;
        }
    }

    return {
        recommendedSize: recommended.name ?? 'M',
        reason,
        activeFitStatus,
        activeFitNote,
    };
}
