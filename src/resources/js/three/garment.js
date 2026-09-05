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

    // Hardcode nilai kalibrasi dasar (sebelumnya dari slider)
    const debugScale = 1.02; 
    const debugY = -0.30;
    const debugZ = 0.12;

    // Kalkulasi final: base x rasio_size x kalibrasi
    let finalScaleX = scaleX * debugScale;
    const finalScaleY = scaleY * debugScale;

    // Perkirakan besaran tubuh avatar di sumbu X (berdasarkan chest)
    // Asumsi avatar standar M memiliki half-chest sekitar 48cm (lebar dada baju M dikurangi kelonggaran 2cm)
    const avatarBaseHalfChest = (baseSizeSpec.lebar_dada || 50) - 2;
    const customerHalfChest = (body && body.chest) ? (body.chest / 2) : avatarBaseHalfChest;
    const avatarScaleX = customerHalfChest / avatarBaseHalfChest;

    // A-Pose & Fat Tolerance: ekstra kelonggaran untuk baju besar
    if (scaleX > 1.0) {
        const extraFit = (scaleX - 1.0) * 0.35;
        finalScaleX += extraFit;
    }

    // CEGAH TEMBUS (CLIPPING) UNTUK BAJU KEKECILAN:
    // Jika baju lebih kecil dari tubuh (misal dada 110 pakai baju S), 
    // baju tidak boleh menyusut tembus daging. Baju akan ditahan di ukuran badan (nge-press).
    // Baju akan terlihat kecil (cingkrang) karena scaleY (panjang) tetap menyusut.
    const minScaleX = avatarScaleX * 1.02; // Minimal 2% lebih besar dari daging agar ketat
    finalScaleX = Math.max(finalScaleX, minScaleX);

    let finalScaleZ = finalScaleX; 
    // Untuk baju kebesaran (scaleX > 1.0), ketebalan depan juga ditambah sedikit
    if (scaleX > 1.0) {
        finalScaleZ += (scaleX - 1.0) * 0.2; 
    }

    garmentWrapper.scale.set(finalScaleX, finalScaleY, finalScaleZ);

    // Kompensasi pivot kerah (sagging / melorot proporsional)
    // - Ukuran L (skala Y ~ 1.028) paling pas dengan dropFactor 1.20.
    // - Ukuran XL & 2XL: 1.20 terlalu ke bawah, 1.15 masih kurang ke bawah sedikit.
    //   Maka kita gunakan nilai 1.18
    let dropFactor = 1.0;
    if (finalScaleY > 1.0) {
        if (finalScaleY < 1.05) {
            dropFactor = 1.20; // L
        } else {
            dropFactor = 1.18; // XL dan 2XL (Titik antara 1.15 dan 1.20)
        }
    }
    const pivotCompensationY = - (cache.collarYLocal * (finalScaleY - 1)) * dropFactor;

    // Offset nilai default
    const uiYOffset = debugY - (-0.30) - 0.01; 
    const uiZOffset = debugZ - (0.12);

    garmentWrapper.position.y = cache.initialY + pivotCompensationY + uiYOffset;
    
    // Kompensasi Maju ke Depan (Z axis)
    // Pengguna mengamati dada depan tembus saat ukuran baju membesar.
    // L (skala 1.08) butuh sedikit maju (0.012), XL (1.16) butuh (0.024), 2XL (1.24) butuh batas maksimal (0.032).
    // Rumus linear: (scale - 1.00) * 0.15 secara presisi mengenai L(0.012) dan XL(0.024)!
    let pivotCompensationZ = 0;
    if (finalScaleX > 1.00) { 
        pivotCompensationZ = Math.min((finalScaleX - 1.00) * 0.15, 0.032); 
    }

    if (typeof cache.initialZ === 'undefined') {
        cache.initialZ = garmentWrapper.position.z;
    }
    garmentWrapper.position.z = cache.initialZ + uiZOffset + pivotCompensationZ;
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