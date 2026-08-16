import * as THREE from 'three';

const cloth = new THREE.MeshStandardMaterial({
    color: 0x2c2622,
    roughness: 0.72,
    metalness: 0.04,
});

const skin = new THREE.MeshStandardMaterial({
    color: 0xd7c4ae,
    roughness: 0.85,
    metalness: 0,
});

function limb(radius, height, material = cloth) {
    const mesh = new THREE.Mesh(new THREE.CylinderGeometry(radius, radius, height, 16), material);
    mesh.castShadow = false;
    return mesh;
}

export function createAvatar() {
    const avatar = new THREE.Group();
    avatar.name = 'fitvendor-avatar';

    const torso = new THREE.Mesh(new THREE.CylinderGeometry(0.28, 0.32, 0.85, 20), cloth);
    torso.position.y = 1.15;
    avatar.add(torso);

    const head = new THREE.Mesh(new THREE.SphereGeometry(0.16, 20, 16), skin);
    head.position.y = 1.78;
    avatar.add(head);

    const hips = new THREE.Mesh(new THREE.CylinderGeometry(0.26, 0.24, 0.28, 16), cloth);
    hips.position.y = 0.62;
    avatar.add(hips);

    const leftArm = limb(0.07, 0.7);
    leftArm.position.set(-0.42, 1.22, 0);
    leftArm.rotation.z = 0.12;
    avatar.add(leftArm);

    const rightArm = limb(0.07, 0.7);
    rightArm.position.set(0.42, 1.22, 0);
    rightArm.rotation.z = -0.12;
    avatar.add(rightArm);

    const leftLeg = limb(0.09, 0.7);
    leftLeg.position.set(-0.14, 0.22, 0);
    avatar.add(leftLeg);

    const rightLeg = limb(0.09, 0.7);
    rightLeg.position.set(0.14, 0.22, 0);
    avatar.add(rightLeg);

    return avatar;
}
