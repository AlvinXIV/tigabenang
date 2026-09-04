import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import * as THREE from 'three';

const loader = new GLTFLoader();
const garmentCache = new WeakMap();

/**
 * Memuat model 3D GLB dan memasangkannya langsung ke badan avatar
 * dengan penyesuaian posisi, rotasi, dan skala yang langsung pas.
 */
export async function loadGarment(url, targetGroup, onProgress = null) {
    targetGroup.clear();

    if (!url) {
        console.warn('[Garment] URL model 3D kosong');
        return null;
    }

    console.log('[Garment] Memuat GLB dari:', url);

    const gltf = await new Promise((resolve, reject) => {
        loader.load(
            url,
            (gltfData) => resolve(gltfData),
            (xhr) => {
                if (xhr.lengthComputable && onProgress) {
                    const percent = Math.round((xhr.loaded / xhr.total) * 100);
                    onProgress(percent);
                }
            },
            (error) => reject(error)
        );
    });

    const model = gltf.scene;

    // Auto-scale jika model diekspor dalam milimeter (ukuran sangat besar)
    const initialBox = new THREE.Box3().setFromObject(model);
    const initialSize = initialBox.getSize(new THREE.Vector3());
    
    if (initialSize.y > 100) {
        console.log('[Garment] Model sangat besar (kemungkinan milimeter), mengaplikasikan scale 0.001');
        model.scale.set(0.001, 0.001, 0.001);
    } else if (initialSize.y > 10) {
        console.log('[Garment] Model besar (kemungkinan centimeter), mengaplikasikan scale 0.01');
        model.scale.set(0.01, 0.01, 0.01);
    }

    // Remove forced scaling/positioning that might break SkinnedMesh
    model.rotation.y = 0;
    // 2. Atur material agar terlihat jelas
    model.traverse((child) => {
        if (child.isMesh) {
            child.castShadow = true;
            child.receiveShadow = true;
            child.renderOrder = 10;

            if (child.material) {
                const mats = Array.isArray(child.material) ? child.material : [child.material];
                mats.forEach((mat) => {
                    mat.side = THREE.DoubleSide;
                    mat.depthTest = true;
                    mat.depthWrite = true;
                    mat.polygonOffset = true;
                    mat.polygonOffsetFactor = -3;
                    mat.polygonOffsetUnits = -5;
                    mat.needsUpdate = true;
                });
            }
        }
    });

    // 3. Buat wrapper grup utama
    const wrapper = new THREE.Group();
    wrapper.name = 'garment-wrapper';
    wrapper.renderOrder = 10;
    wrapper.add(model);

    targetGroup.add(wrapper);

    const garmentBox = new THREE.Box3().setFromObject(wrapper);
    const garmentSize = garmentBox.getSize(new THREE.Vector3());
    const garmentCenter = garmentBox.getCenter(new THREE.Vector3());

    // Target: pusat vertikal baju sejajar dengan pusat torso avatar (y≈1.12)
    const avatarTorsoCenter = 1.12;
    const autoYOffset = avatarTorsoCenter - garmentCenter.y;
    
    wrapper.position.y += autoYOffset;

    // Target: pusat horizontal baju sejajar dengan pusat avatar (x=0, z=0)
    wrapper.position.x -= garmentCenter.x;
    wrapper.position.z -= garmentCenter.z;

    // Hitung ulang BoundingBox setelah dipindah ke world position baru
    const finalGarmentBox = new THREE.Box3().setFromObject(wrapper);
    
    // collarYLocal harus berupa jarak puncak kerah ke origin model lokal!
    // Karena wrapper.position.y digeser, max.y dunia harus dikurangi wrapper.position.y
    const collarYLocal = finalGarmentBox.max.y - wrapper.position.y;

    garmentCache.set(wrapper, {
        rawSize: garmentSize.clone(),
        collarYLocal: collarYLocal,
        model: model,
        initialY: wrapper.position.y
    });

    console.log(`[Garment] Auto-positioned: yOffset=${autoYOffset.toFixed(3)}, size=${garmentSize.y.toFixed(3)}h x ${garmentSize.x.toFixed(3)}w x ${garmentSize.z.toFixed(3)}d`);

    console.log('[Garment] Baju 3D berhasil dipasang ke avatar');

    return wrapper;
}

/**
 * Menyesuaikan ukuran dan posisi baju saat avatar atau ukuran pakaian diganti.
 */
export function fitGarmentToAvatar(garmentWrapper, body = {}, sizeSpec = null, matchState = null, avatar = null, baseSizeSpec = null) {
    if (!avatar || !garmentWrapper || !sizeSpec || !baseSizeSpec) return;

    const cache = garmentCache.get(garmentWrapper);
    if (!cache) return;

    const scaleX = sizeSpec.lebar_dada / (baseSizeSpec.lebar_dada || 50);
    const scaleY = sizeSpec.panjang / (baseSizeSpec.panjang || 70);

    const debugScaleEl = document.getElementById('debug-scale');
    const debugScale = debugScaleEl ? parseFloat(debugScaleEl.value) : 1.0;

    const debugYEl = document.getElementById('debug-y');
    const debugY = debugYEl ? parseFloat(debugYEl.value) : 0.0;

    const debugZEl = document.getElementById('debug-z');
    const debugZ = debugZEl ? parseFloat(debugZEl.value) : 0.0;

    // Kalkulasi final: base x rasio_size x slider
    let finalScaleX = scaleX * debugScale;
    const finalScaleY = scaleY * debugScale;

    // A-Pose & Fat Tolerance:
    // Jika baju lebih besar dari ukuran dasar (scaleX > 1.0),
    // lengan A-pose dan perut avatar membengkak menembus sisi ketiak/lengan bawah.
    // Kita berikan ekstra kelonggaran pelebaran (X dan Z) secara progresif.
    if (scaleX > 1.0) {
        const extraFit = (scaleX - 1.0) * 0.35; // Tambah 35% kelonggaran dari selisih pelebaran
        finalScaleX += extraFit;
    }
    
    let finalScaleZ = finalScaleX; // Ketebalan perut/dada
    // Untuk ukuran besar, manusia biasanya membesar ke depan (Z) lebih banyak daripada ke samping (X).
    if (scaleX > 1.0) {
        finalScaleZ += (scaleX - 1.0) * 0.2; 
    }

    garmentWrapper.scale.set(finalScaleX, finalScaleY, finalScaleZ);

    // Kompensasi pivot kerah: 
    // Kita ingin kerah (titik Y tertinggi) tidak bergeser ke atas saat ukuran berubah.
    // Jika ukuran Y membesar, kerah aslinya akan naik sejauh: collarYLocal * (finalScaleY - 1).
    // Kita menurunkannya sebesar itu agar statis, ditambah sedikit "turun ekstra" 
    // sesuai permintaan user agar kerah baju XL sedikit lebih melorot/turun.
    const extraSag = (finalScaleY > 1.0) ? ((finalScaleY - 1.0) * 0.25) : 0;
    const pivotCompensationY = - (cache.collarYLocal * (finalScaleY - 1)) - extraSag;

    // Pengguna menginginkan UI slider start di -0.30 (Y) dan 0.12 (Z).
    // Nilai ini di-"netralkan" agar tidak mendorong baju turun/maju ganda saat inisiasi.
    // Di nilai -0.30, posisi yang dirasa pas adalah offset -0.01 dari titik otomatis (initialY).
    const uiYOffset = debugY - (-0.30) - 0.01; 
    const uiZOffset = debugZ - (0.12);

    garmentWrapper.position.y = cache.initialY + pivotCompensationY + uiYOffset;
    
    if (typeof cache.initialZ === 'undefined') {
        cache.initialZ = garmentWrapper.position.z;
    }
    garmentWrapper.position.z = cache.initialZ + uiZOffset;
}

/**
 * Model sampel sederhana jika produk belum memiliki file GLB.
 */
export function createDummyGarment(targetGroup) {
    targetGroup.clear();

    const dummyGroup = new THREE.Group();
    dummyGroup.name = 'dummy-shirt';

    const mat = new THREE.MeshStandardMaterial({
        color: 0x172A39, // Navy
        roughness: 0.6,
        metalness: 0.05,
        side: THREE.DoubleSide,
    });

    const bodyMesh = new THREE.Mesh(
        new THREE.CylinderGeometry(0.30, 0.28, 0.70, 32),
        mat
    );
    dummyGroup.add(bodyMesh);

    const box = new THREE.Box3().setFromObject(dummyGroup);
    const size = box.getSize(new THREE.Vector3());

    const wrapper = new THREE.Group();
    wrapper.name = 'garment-wrapper';
    wrapper.add(dummyGroup);
    wrapper.position.set(0, 1.12, 0.02);

    garmentCache.set(wrapper, {
        rawSize: size.clone(),
        model: dummyGroup,
    });

    targetGroup.add(wrapper);
    return wrapper;
}