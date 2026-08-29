import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import * as THREE from 'three';

const loader = new GLTFLoader();

export async function loadGarment(url, targetGroup) {
    targetGroup.clear();

    if (!url) {
        return null;
    }

    const gltf = await loader.loadAsync(url);
    const model = gltf.scene;
    model.updateMatrixWorld(true);

    const box = new THREE.Box3().setFromObject(model);
    const size = box.getSize(new THREE.Vector3());
    const maxDim = Math.max(size.x, size.y, size.z) || 1;
    const scale = 1.8 / maxDim;

    model.scale.setScalar(scale);

    const scaledBox = new THREE.Box3().setFromObject(model);
    const center = scaledBox.getCenter(new THREE.Vector3());

    model.position.sub(center);
    model.position.y += scaledBox.getSize(new THREE.Vector3()).y / 2;

    targetGroup.add(model);

    return model;
}

/**
 * Dummy kaos untuk testing virtual fitting.
 * Belum menggunakan file GLB.
 */
export function createDummyGarment(targetGroup) {
    targetGroup.clear();

    const garment = new THREE.Group();
    garment.name = 'dummy-shirt';

    const material = new THREE.MeshStandardMaterial({
        color: 0xb85c38,
        roughness: 0.8,
        metalness: 0,
        side: THREE.DoubleSide,
    });

    // Badan kaos
    const body = new THREE.Mesh(
        new THREE.CylinderGeometry(
            0.36, // radius atas
            0.40, // radius bawah
            0.95, // tinggi
            24
        ),
        material
    );

    body.position.y = 1.15;
    garment.add(body);

    // Lengan kiri
    const leftSleeve = new THREE.Mesh(
        new THREE.CylinderGeometry(0.11, 0.13, 0.42, 16),
        material
    );

    leftSleeve.position.set(-0.40, 1.30, 0);
    leftSleeve.rotation.z = Math.PI / 2;
    garment.add(leftSleeve);

    // Lengan kanan
    const rightSleeve = new THREE.Mesh(
        new THREE.CylinderGeometry(0.11, 0.13, 0.42, 16),
        material
    );

    rightSleeve.position.set(0.40, 1.30, 0);
    rightSleeve.rotation.z = Math.PI / 2;
    garment.add(rightSleeve);

    targetGroup.add(garment);

    return garment;
}