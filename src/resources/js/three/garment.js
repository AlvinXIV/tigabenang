import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import * as THREE from 'three';
import { calculateBodyParameters } from './avatar';

const loader = new GLTFLoader();

const TEXTURE_KEYS = [
    'map',
    'normalMap',
    'roughnessMap',
    'metalnessMap',
    'aoMap',
    'emissiveMap',
];

function disposeObject(object) {
    object.traverse((child) => {
        if (child.geometry) {
            child.geometry.dispose();
        }

        const materials = child.material
            ? (Array.isArray(child.material) ? child.material : [child.material])
            : [];

        materials.forEach((material) => {
            TEXTURE_KEYS.forEach((key) => {
                material[key]?.dispose?.();
            });
            material.dispose?.();
        });
    });
}

export function disposeGarment(targetGroup) {
    if (!targetGroup) {
        return;
    }

    [...targetGroup.children].forEach((child) => {
        disposeObject(child);
        targetGroup.remove(child);
    });

    targetGroup.clear();
}

function prepareGarmentMaterials(model) {
    model.traverse((child) => {
        if (!child.isMesh) {
            return;
        }

        child.visible = true;
        child.castShadow = true;
        child.receiveShadow = true;

        const materials = Array.isArray(child.material)
            ? child.material
            : [child.material];

        materials.forEach((material) => {
            if (!material) {
                return;
            }

            material.side = THREE.DoubleSide;
            material.transparent = false;
            material.opacity = 1;
            material.depthTest = true;
            material.depthWrite = true;
            material.needsUpdate = true;
        });
    });
}

function isUsableBox(box) {
    if (!box || box.isEmpty()) {
        return false;
    }

    const size = box.getSize(new THREE.Vector3());

    return Number.isFinite(size.x)
        && Number.isFinite(size.y)
        && Number.isFinite(size.z)
        && Math.max(size.x, size.y, size.z) > 0.0001;
}

function boxFromMeshes(object) {
    const box = new THREE.Box3();

    object.updateMatrixWorld(true);

    object.traverse((child) => {
        if (!child.isMesh || !child.geometry) {
            return;
        }

        child.geometry.computeBoundingBox();

        if (!child.geometry.boundingBox) {
            return;
        }

        const meshBox = child.geometry.boundingBox.clone();
        meshBox.applyMatrix4(child.matrixWorld);
        box.union(meshBox);
    });

    return box;
}

// Audited t-shirt.glb world box after the Sketchfab root (mm-like units).
const TSHIRT_FALLBACK_BOUNDS = {
    min: new THREE.Vector3(-403.73, 1496.70, -172.27),
    max: new THREE.Vector3(395.11, 2270.66, 175.69),
};

function boundsFromBox(box) {
    return {
        size: box.getSize(new THREE.Vector3()),
        center: box.getCenter(new THREE.Vector3()),
        min: box.min.clone(),
        max: box.max.clone(),
    };
}

function measureRawBounds(object) {
    object.updateMatrixWorld(true);

    let box = new THREE.Box3().setFromObject(object);

    if (!isUsableBox(box)) {
        box = boxFromMeshes(object);
    }

    if (!isUsableBox(box)) {
        box = new THREE.Box3(
            TSHIRT_FALLBACK_BOUNDS.min.clone(),
            TSHIRT_FALLBACK_BOUNDS.max.clone(),
        );
    }

    return boundsFromBox(box);
}

function resolveGarmentUrl(url) {
    if (!url) {
        return url;
    }

    if (/^https?:\/\//i.test(url)) {
        return url;
    }

    if (typeof window !== 'undefined' && window.location?.origin) {
        return new URL(url, window.location.origin).href;
    }

    return url;
}

/**
 * Load a static GLB into garmentGroup.
 * Does not treat raw millimetre-like values as metres.
 * Fit is applied separately via fitGarmentToMannequin().
 */
export async function loadGarment(url, targetGroup) {
    disposeGarment(targetGroup);

    if (!url) {
        return null;
    }

    const resolvedUrl = resolveGarmentUrl(url);
    const gltf = await loader.loadAsync(resolvedUrl);
    const model = gltf.scene;

    prepareGarmentMaterials(model);

    const wrapper = new THREE.Group();
    wrapper.name = 'garment-wrapper';
    wrapper.visible = true;
    wrapper.add(model);

    if (targetGroup) {
        targetGroup.add(wrapper);
    }

    captureRestBounds(wrapper);

    return wrapper;
}

// Radial ease so the static mesh sits just outside the solid torso.
const GARMENT_BODY_CLEARANCE = 0.028;

// Isolated preview ratios only — not real garment measurements.
export const GARMENT_SIZE_PRESETS = {
    S: 0.94,
    M: 1.00,
    L: 1.06,
    XL: 1.12,
    XXL: 1.18,
};

export function getGarmentSizeScale(size) {
    const key = String(size || 'M').toUpperCase();

    return GARMENT_SIZE_PRESETS[key] ?? 1;
}

function collectWorldVertices(object) {
    const vertices = [];
    const vertex = new THREE.Vector3();

    object.updateMatrixWorld(true);

    object.traverse((child) => {
        const position = child.geometry?.attributes?.position;

        if (!child.isMesh || !position) {
            return;
        }

        for (let i = 0; i < position.count; i += 1) {
            vertex.fromBufferAttribute(position, i);
            child.localToWorld(vertex);
            vertices.push(vertex.clone());
        }
    });

    return vertices;
}

function measureBandExtents(vertices, minY, height, t0, t1) {
    const lo = minY + height * t0;
    const hi = minY + height * t1;
    let minX = Infinity;
    let maxX = -Infinity;
    let minZ = Infinity;
    let maxZ = -Infinity;
    let count = 0;

    for (const point of vertices) {
        if (point.y < lo || point.y > hi) {
            continue;
        }

        minX = Math.min(minX, point.x);
        maxX = Math.max(maxX, point.x);
        minZ = Math.min(minZ, point.z);
        maxZ = Math.max(maxZ, point.z);
        count += 1;
    }

    if (count < 6 || !Number.isFinite(minX) || !Number.isFinite(maxX)) {
        return null;
    }

    return {
        width: maxX - minX,
        depth: maxZ - minZ,
        count,
    };
}

function analyzeRestGeometry(garment, boxBounds) {
    const vertices = collectWorldVertices(garment);
    const height = boxBounds.size.y;
    const fullWidth = boxBounds.size.x;
    const fullDepth = boxBounds.size.z;
    const minY = boxBounds.min.y;

    // Hem → mid-torso stays sleeve-free on this mesh. Sleeve takeoff
    // starts around 60% of garment height (see inspected GLB bands).
    const bodyBand = measureBandExtents(vertices, minY, height, 0.16, 0.56)
        || measureBandExtents(vertices, minY, height, 0.20, 0.50);

    // Audited t-shirt.glb: mid-body ~445 vs sleeve span ~799.
    const fallbackBodyRatio = 445.48 / 798.85;
    const bodyWidth = bodyBand?.width > 0.0001
        ? bodyBand.width
        : fullWidth * fallbackBodyRatio;
    const bodyDepth = bodyBand?.depth > 0.0001
        ? bodyBand.depth
        : fullDepth * 0.91;

    return {
        ...boxBounds,
        fullWidth,
        sleeveSpan: fullWidth,
        bodyWidth,
        bodyDepth,
        height,
        depth: fullDepth,
        bodyToSleeveRatio: fullWidth > 0.0001 ? bodyWidth / fullWidth : 1,
    };
}

function captureRestBounds(garment) {
    garment.position.set(0, 0, 0);
    garment.scale.set(1, 1, 1);
    garment.rotation.set(0, 0, 0);
    garment.updateMatrixWorld(true);

    const boxBounds = measureRawBounds(garment);
    const bounds = analyzeRestGeometry(garment, boxBounds);
    garment.userData.restBounds = bounds;
    garment.userData.rawSize = bounds.size;
    garment.userData.rawCenter = bounds.center;
    garment.userData.rawMin = bounds.min;
    garment.userData.rawMax = bounds.max;

    return bounds;
}

function getRestBounds(garment) {
    if (garment.userData.restBounds?.bodyWidth > 0.0001) {
        return garment.userData.restBounds;
    }

    return captureRestBounds(garment);
}

function recenterXZ(garment) {
    garment.updateMatrixWorld(true);
    const world = measureRawBounds(garment);
    garment.position.x += -world.center.x;
    garment.position.z += -world.center.z;
    garment.updateMatrixWorld(true);
}

/**
 * Fit the shirt BODY to the mannequin torso.
 * Sleeve-inclusive AABB width is not used as torso width.
 */
export function fitGarmentToMannequin(garment, bodyParameters = {}, size = 'M') {
    if (!garment) {
        return null;
    }

    const rest = getRestBounds(garment);

    if (!rest.bodyWidth || rest.bodyWidth <= 0.000001 || rest.height <= 0.000001) {
        return null;
    }

    const body = calculateBodyParameters(bodyParameters);
    const sizeScale = getGarmentSizeScale(size);
    const clearance = GARMENT_BODY_CLEARANCE;

    // 4. Target torso width from chest / waist / shoulder — not sleeve span.
    const torsoSpan = Math.max(
        body.chestWidth,
        body.waistWidth,
        body.shoulderWidth * 0.90,
    );
    const targetBodyWidth = (torsoSpan + (2 * clearance)) * sizeScale;

    // 5. Height: collar at neck, hem at waist to slightly below waist.
    const collarY = Math.min(body.yNeckBase - 0.016, body.yShoulder + 0.022);
    const preferredHemY = body.yWaist - 0.028;
    const minHemY = body.yHip + 0.06;
    const targetHeight = THREE.MathUtils.clamp(
        (collarY - preferredHemY) * sizeScale,
        0.40,
        0.62,
    );

    // 6. Depth: sit slightly outside the lofted chest / waist.
    const targetDepth = Math.max(
        body.chestDepth + (2 * clearance),
        body.waistDepth + (2 * clearance),
    ) * sizeScale;

    let scaleX = targetBodyWidth / rest.bodyWidth;
    let scaleY = targetHeight / rest.height;
    let scaleZ = rest.bodyDepth > 0.0001
        ? targetDepth / rest.bodyDepth
        : targetDepth / rest.depth;

    // Keep sleeves attached to the upper arm — do not let X explode.
    const maxSleeveSpan = (body.shoulderWidth + 0.36) * sizeScale;

    if (rest.sleeveSpan * scaleX > maxSleeveSpan) {
        scaleX = maxSleeveSpan / rest.sleeveSpan;
    }

    // Soften extreme X/Y squash so the tee still reads as one shirt.
    if (scaleY > 0.000001 && scaleX / scaleY > 1.62) {
        const longer = Math.min(
            scaleX / 1.48,
            (collarY - minHemY) / rest.height,
        );
        scaleY = Math.max(scaleY, longer);
    }

    scaleZ = THREE.MathUtils.clamp(scaleZ, scaleY * 0.85, scaleX * 1.15);

    // 7–8. Apply transform and recenter X/Z.
    garment.visible = true;
    garment.rotation.set(0, 0, 0);
    garment.scale.set(scaleX, scaleY, scaleZ);
    garment.position.set(0, 0, 0);
    recenterXZ(garment);

    // 9–10. Place collar, then hem.
    const afterScale = measureRawBounds(garment);
    garment.position.y += collarY - afterScale.max.y;
    garment.updateMatrixWorld(true);

    const placed = measureRawBounds(garment);

    if (placed.min.y < minHemY) {
        garment.position.y += minHemY - placed.min.y;
    } else if (placed.min.y > preferredHemY + 0.04) {
        garment.position.y -= Math.min(
            placed.min.y - preferredHemY,
            placed.max.y - (body.yNeckBase - 0.008),
        );
    }

    // 11. Keep the shell centered; clearance is already in the scales.
    recenterXZ(garment);

    // 12. Validate body coverage and nudge X if the torso is still short.
    const finalBox = measureRawBounds(garment);
    const estimatedBodyWidth = finalBox.size.x * (rest.bodyToSleeveRatio || 0.56);

    if (estimatedBodyWidth < targetBodyWidth * 0.97 && estimatedBodyWidth > 0.0001) {
        garment.scale.x *= targetBodyWidth / estimatedBodyWidth;
        recenterXZ(garment);
    }

    const validated = measureRawBounds(garment);
    const finalBodyWidth = validated.size.x * (rest.bodyToSleeveRatio || 0.56);
    const finalBodyDepth = rest.depth > 0.0001
        ? validated.size.z * (rest.bodyDepth / rest.depth)
        : validated.size.z;

    const coversTorso = finalBodyWidth >= body.chestWidth * 1.02
        && validated.min.y <= body.yWaist + 0.05
        && validated.max.y >= body.yChest;

    // Fitting is applied first. Hide only the covered lofted torso so
    // leftover static-shell intersections cannot poke through the shirt.
    const hideCoveredTorso = coversTorso;

    const fitResult = {
        size,
        sizeScale,
        clearance,
        scaleX,
        scaleY,
        scaleZ: garment.scale.z,
        restBodyWidth: rest.bodyWidth,
        restSleeveSpan: rest.sleeveSpan,
        targetBodyWidth,
        targetHeight,
        targetDepth,
        finalWidth: validated.size.x,
        finalHeight: validated.size.y,
        finalDepth: validated.size.z,
        finalBodyWidth,
        finalBodyDepth,
        hideCoveredTorso,
    };

    garment.userData.finalBounds = validated;
    garment.userData.fitResult = fitResult;

    return fitResult;
}

export function updateGarmentFit(garment, bodyParameters = {}, size = 'M') {
    return fitGarmentToMannequin(garment, bodyParameters, size);
}

export function createDummyGarment(targetGroup) {
    disposeGarment(targetGroup);

    const dummy = new THREE.Group();
    dummy.name = 'dummy-shirt';

    const material = new THREE.MeshStandardMaterial({
        color: 0xb85c38,
        roughness: 0.8,
        metalness: 0,
        side: THREE.DoubleSide,
    });

    const body = new THREE.Mesh(
        new THREE.CylinderGeometry(0.28, 0.30, 0.52, 24),
        material,
    );
    dummy.add(body);

    dummy.updateMatrixWorld(true);

    const box = new THREE.Box3().setFromObject(dummy);
    const wrapper = new THREE.Group();
    wrapper.name = 'garment-wrapper';
    wrapper.userData.rawSize = box.getSize(new THREE.Vector3());
    wrapper.userData.rawCenter = box.getCenter(new THREE.Vector3());
    wrapper.userData.rawMin = box.min.clone();
    wrapper.userData.rawMax = box.max.clone();
    wrapper.add(dummy);

    targetGroup.add(wrapper);

    return wrapper;
}
