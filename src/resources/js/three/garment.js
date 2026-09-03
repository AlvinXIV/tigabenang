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

    garmentCache.set(wrapper, {
        rawSize: new THREE.Vector3(1, 1, 1),
        model: model,
    });

    targetGroup.add(wrapper);

    // ── Auto-position baju agar langsung pas di badan avatar ──
    // Avatar tinggi ~1.7 unit (170cm / 100). Bahu di sekitar y=1.44, selangkangan y=0.80
    // Pusat torso avatar kira-kira y = 1.12
    const garmentBox = new THREE.Box3().setFromObject(wrapper);
    const garmentSize = garmentBox.getSize(new THREE.Vector3());
    const garmentCenter = garmentBox.getCenter(new THREE.Vector3());

    // Target: pusat vertikal baju sejajar dengan pusat torso avatar (y≈1.12)
    const avatarTorsoCenter = 1.12;
    const yOffset = avatarTorsoCenter - garmentCenter.y;
    wrapper.position.y += yOffset;

    // Target: pusat horizontal baju sejajar dengan pusat avatar (x=0, z=0)
    wrapper.position.x -= garmentCenter.x;
    wrapper.position.z -= garmentCenter.z;

    console.log(`[Garment] Auto-positioned: yOffset=${yOffset.toFixed(3)}, size=${garmentSize.y.toFixed(3)}h x ${garmentSize.x.toFixed(3)}w x ${garmentSize.z.toFixed(3)}d`);

    console.log('[Garment] Baju 3D berhasil dipasang ke avatar');

    return wrapper;
}

/**
 * Menyesuaikan ukuran dan posisi baju saat avatar atau ukuran pakaian diganti.
 */
export function fitGarmentToAvatar(garmentWrapper, body = {}, sizeSpec = null, matchState = null, avatar = null) {
    if (!avatar || !garmentWrapper) return;

    // Biarkan baju sesuai ukuran asli dari file GLB untuk sementara
    // agar SkinnedMesh tidak rusak saat di-scale.
    console.log('[Garment] fitGarmentToAvatar called but not squishing the avatar so we preserve human anatomy.');
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