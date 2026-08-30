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

    // Remove forced scaling/positioning that might break SkinnedMesh
    // Just rotate Y if necessary (or let it be for now).
    model.rotation.y = Math.PI;

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

    // Add BoxHelper to debug visibility and scale
    const boxHelper = new THREE.BoxHelper(wrapper, 0xff0000);
    wrapper.add(boxHelper);

    // Add a debug sphere to verify garmentGroup is rendering at all
    const sphereGeo = new THREE.SphereGeometry(0.5, 32, 32);
    const sphereMat = new THREE.MeshBasicMaterial({ color: 0xff0000, wireframe: true });
    const sphereMesh = new THREE.Mesh(sphereGeo, sphereMat);
    sphereMesh.position.set(0, 1.12, 0); // Chest height
    wrapper.add(sphereMesh);

    targetGroup.add(wrapper);
    
    // Create an on-screen debug overlay so the user can see it in screenshots
    let hasBones = false;
    model.traverse((child) => {
        if (child.isSkinnedMesh) hasBones = true;
    });
    
    const box = new THREE.Box3().setFromObject(model);
    const size = box.getSize(new THREE.Vector3());
    const center = box.getCenter(new THREE.Vector3());
    
    const debugDiv = document.createElement('div');
    debugDiv.style.position = 'absolute';
    debugDiv.style.top = '20px';
    debugDiv.style.right = '20px';
    debugDiv.style.background = 'rgba(0,0,0,0.8)';
    debugDiv.style.color = '#fff';
    debugDiv.style.padding = '15px';
    debugDiv.style.borderRadius = '8px';
    debugDiv.style.zIndex = '9999';
    debugDiv.style.fontFamily = 'monospace';
    debugDiv.style.fontSize = '14px';
    debugDiv.style.pointerEvents = 'none';
    debugDiv.innerHTML = `
        <b>DEBUG GLB:</b><br/>
        Size: X:${size.x.toFixed(3)}, Y:${size.y.toFixed(3)}, Z:${size.z.toFixed(3)}<br/>
        Center: X:${center.x.toFixed(3)}, Y:${center.y.toFixed(3)}, Z:${center.z.toFixed(3)}<br/>
        Has Bones: ${hasBones ? 'YES' : 'NO'}<br/>
        If size is very small (e.g. 0.001) or very large (e.g. 1000), it won't be visible.<br/>
        There should also be a red wireframe sphere on the avatar's chest.
    `;
    
    const viewport = document.getElementById('fitting-viewport');
    if (viewport) {
        // Remove previous debug if exists
        const prev = viewport.querySelector('#debug-glb');
        if (prev) prev.remove();
        debugDiv.id = 'debug-glb';
        viewport.appendChild(debugDiv);
    }

    console.log('[Garment] Baju 3D berhasil dipasang ke avatar tanpa scale');

    return wrapper;
}

/**
 * Menyesuaikan ukuran dan posisi baju saat avatar atau ukuran pakaian diganti.
 */
export function fitGarmentToAvatar(garmentWrapper, body = {}, sizeSpec = null) {
    // Biarkan baju sesuai ukuran asli dari file GLB untuk sementara
    // agar SkinnedMesh tidak rusak saat di-scale.
    console.log('[Garment] fitGarmentToAvatar called but doing nothing (no scaling) to avoid SkinnedMesh bugs');
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