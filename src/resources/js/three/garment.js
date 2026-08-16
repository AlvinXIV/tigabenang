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
