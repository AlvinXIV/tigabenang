import * as THREE from 'three';

// ──────────────────────────────────────────────────────────────
// CONSTANTS
// ──────────────────────────────────────────────────────────────

const SEGS   = 32;   // vertices per ring
const INTERP = 6;    // interpolation steps
const NAME   = 'fitvendor-avatar';

// ──────────────────────────────────────────────────────────────
// SHARED MATERIAL
// ──────────────────────────────────────────────────────────────

const material =
    new THREE.MeshPhysicalMaterial({
        color: 0xc8b8a8,
        roughness: 0.55,
        metalness: 0.02,
        clearcoat: 0.12,
        clearcoatRoughness: 0.4,
        side: THREE.DoubleSide,
    });

// ──────────────────────────────────────────────────────────────
// MATH
// ──────────────────────────────────────────────────────────────

const lerp = (a, b, t) =>
    a + (b - a) * t;

const catmull = (p0, p1, p2, p3, t) => {
    const t2 = t * t;
    const t3 = t2 * t;

    return (
        0.5 *
        (2 * p1 +
            (-p0 + p2) * t +
            (2 * p0 -
                5 * p1 +
                4 * p2 -
                p3) *
                t2 +
            (-p0 +
                3 * p1 -
                3 * p2 +
                p3) *
                t3)
    );
};

// ──────────────────────────────────────────────────────────────
// GEOMETRY: LOFTED MESH FROM RINGS
// ──────────────────────────────────────────────────────────────
//
// Each "ring" = { y, rx, rz }
//   rx = side-to-side half-width
//   rz = front-to-back half-depth
//
// The function connects adjacent rings
// into a smooth triangle-strip surface.
// ──────────────────────────────────────────────────────────────

function loftGeo(
    rings,
    segs = SEGS,
    capBottom = false,
    capTop = false,
) {
    const pos = [];
    const idx = [];
    const vpr = segs + 1;

    for (const r of rings) {
        for (let j = 0; j <= segs; j++) {
            const a =
                (j / segs) * Math.PI * 2;

            pos.push(
                Math.cos(a) * r.rx,
                r.y,
                Math.sin(a) * r.rz,
            );
        }
    }

    for (
        let i = 0;
        i < rings.length - 1;
        i++
    ) {
        for (let j = 0; j < segs; j++) {
            const a = i * vpr + j;
            const b = a + vpr;

            idx.push(
                a,
                b,
                a + 1,
                a + 1,
                b,
                b + 1,
            );
        }
    }

    if (capBottom) {
        const ci = pos.length / 3;
        const r = rings[0];

        pos.push(0, r.y, 0);

        for (let j = 0; j < segs; j++) {
            idx.push(ci, j + 1, j);
        }
    }

    if (capTop) {
        const ci = pos.length / 3;
        const li = rings.length - 1;
        const r = rings[li];

        pos.push(0, r.y, 0);

        const b = li * vpr;

        for (let j = 0; j < segs; j++) {
            idx.push(ci, b + j, b + j + 1);
        }
    }

    const geo =
        new THREE.BufferGeometry();

    geo.setAttribute(
        'position',
        new THREE.Float32BufferAttribute(
            pos,
            3,
        ),
    );

    geo.setIndex(idx);
    geo.computeVertexNormals();

    return geo;
}

// ──────────────────────────────────────────────────────────────
// CATMULL-ROM RING INTERPOLATION
// ──────────────────────────────────────────────────────────────

function smooth(keys, steps = INTERP) {
    if (keys.length < 2) {
        return [...keys];
    }

    const out = [];
    const n = keys.length;

    for (let i = 0; i < n - 1; i++) {
        const r0 =
            keys[Math.max(0, i - 1)];

        const r1 = keys[i];
        const r2 = keys[i + 1];

        const r3 =
            keys[
                Math.min(n - 1, i + 2)
            ];

        for (let s = 0; s < steps; s++) {
            const t = s / steps;

            out.push({
                y: catmull(
                    r0.y,
                    r1.y,
                    r2.y,
                    r3.y,
                    t,
                ),
                rx: Math.max(
                    0.001,
                    catmull(
                        r0.rx,
                        r1.rx,
                        r2.rx,
                        r3.rx,
                        t,
                    ),
                ),
                rz: Math.max(
                    0.001,
                    catmull(
                        r0.rz,
                        r1.rz,
                        r2.rz,
                        r3.rz,
                        t,
                    ),
                ),
            });
        }
    }

    out.push(keys[n - 1]);

    return out;
}

// ──────────────────────────────────────────────────────────────
// CIRCUMFERENCE → ELLIPSE HALF-AXES
// ──────────────────────────────────────────────────────────────

function circ(c, s, wr = 1.15) {
    const avg = (c * s) / (2 * Math.PI);
    const dr = 1 / wr;

    return {
        rx: avg * Math.sqrt(wr),
        rz: avg * Math.sqrt(dr),
    };
}

// ──────────────────────────────────────────────────────────────
// PUBLIC: BODY LANDMARKS (metre scale)
// ──────────────────────────────────────────────────────────────
//
// Same anatomy math as createAvatar().
// Garment fitting must use this instead of inventing new formulas.
// ──────────────────────────────────────────────────────────────

export function getAvatarLandmarks(opts = {}) {
    const heightCm = Number(opts.height) || 170;
    const chestCm = Number(opts.chest) || 92;
    const waistCm = Number(opts.waist) || 76;
    const hipCm = Number(opts.hip) || 96;
    const shoulderCm = Number(opts.shoulder) || 44;
    const armCm = Number(opts.armLength) || 58;
    const torsoCm = Number(opts.torsoLength) || 44;
    const torsoType = opts.torsoType || 'normal';

    const h = heightCm / 100;
    const s = 1 / 100;

    const crotchFrac =
        torsoType === 'long'
            ? 0.44
            : torsoType === 'short'
              ? 0.50
              : 0.47;

    const headH = h * 0.125;
    const neckH = h * 0.028;
    const yCrotch = h * crotchFrac;
    const yAnkle = h * 0.046;
    const yKnee = yAnkle + (yCrotch - yAnkle) * 0.47;
    const yShoulder = h - headH - neckH;
    const yWaist = yShoulder - torsoCm * s;
    const yHip = lerp(yCrotch, yWaist, 0.35);
    const yChest = lerp(yWaist, yShoulder, 0.55);
    const yNeckBase = yShoulder + neckH;
    const yHeadCenter = yNeckBase + headH * 0.45;

    const hipR = circ(hipCm, s, 1.25);
    const waistR = circ(waistCm, s, 1.08);
    const chestR = circ(chestCm, s, 1.2);

    return {
        heightCm,
        chestCm,
        waistCm,
        hipCm,
        shoulderCm,
        armCm,
        torsoCm,
        torsoType,
        height: h,
        yCrotch,
        yAnkle,
        yKnee,
        yHip,
        yWaist,
        yChest,
        yShoulder,
        yNeckBase,
        yHeadCenter,
        headH,
        neckH,
        shoulderWidth: shoulderCm * s,
        torsoLength: torsoCm * s,
        armLength: armCm * s,
        chestWidth: chestR.rx * 2,
        chestDepth: chestR.rz * 2,
        waistWidth: waistR.rx * 2,
        waistDepth: waistR.rz * 2,
        hipWidth: hipR.rx * 2,
        chestR,
        waistR,
        hipR,
    };
}

export function calculateBodyParameters(opts = {}) {
    return getAvatarLandmarks(opts);
}

// ──────────────────────────────────────────────────────────────
// BUILD LIMB TUBE
// ──────────────────────────────────────────────────────────────
//
// Creates a tapered tube along the Y axis
// with a gentle muscle bulge in the middle.
// ──────────────────────────────────────────────────────────────

function limbRings(
    len,
    rTop,
    rBot,
    yBase = 0,
    n = 5,
) {
    const keys = [];

    for (let i = 0; i <= n; i++) {
        const t = i / n;

        const r = lerp(rTop, rBot, t);

        // Slight muscle bulge
        const bulge =
            Math.sin(t * Math.PI) *
            0.12 *
            rTop;

        const rx =
            (r + bulge) * 1.05;

        const rz = r + bulge;

        keys.push({
            y: yBase + len * (1 - t),
            rx,
            rz,
        });
    }

    return smooth(keys, 4);
}

// ──────────────────────────────────────────────────────────────
// DISPOSE HELPERS
// ──────────────────────────────────────────────────────────────

function disposeGroup(group) {
    group.traverse((child) => {
        if (!child.isMesh) {
            return;
        }

        child.geometry?.dispose();

        // Don't dispose shared material
        if (
            child.material &&
            child.material !== material
        ) {
            child.material.dispose();
        }
    });
}

// ──────────────────────────────────────────────────────────────
// PUBLIC: CREATE AVATAR
// ──────────────────────────────────────────────────────────────
//
// Parameters (all in cm):
//   height       – Total height
//   chest        – Chest circumference
//   waist        – Waist circumference
//   hip          – Hip circumference
//   shoulder     – Shoulder width
//   armLength    – Full arm length
//   torsoLength  – Shoulder to waist
//   torsoType    – 'normal' | 'long' | 'short'
// ──────────────────────────────────────────────────────────────

export function createAvatar(
    opts = {},
) {
    const h =
        (Number(opts.height) || 170) /
        100;

    const chestCm =
        Number(opts.chest) || 92;

    const waistCm =
        Number(opts.waist) || 76;

    const hipCm =
        Number(opts.hip) || 96;

    const shoulderCm =
        Number(opts.shoulder) || 44;

    const armCm =
        Number(opts.armLength) || 58;

    const torsoCm =
        Number(opts.torsoLength) || 44;

    const torsoType =
        opts.torsoType || 'normal';

    // ── Scale factor ─────────────────────

    const s = 1 / 100;

    // ── Torso type modifier ──────────────

    const crotchFrac =
        torsoType === 'long'
            ? 0.44
            : torsoType === 'short'
              ? 0.50
              : 0.47;

    // ── Anatomy positions (from floor) ───

    const headH = h * 0.125;
    const neckH = h * 0.028;

    const yCrotch = h * crotchFrac;

    const yAnkle = h * 0.046;
    const yKnee =
        yAnkle +
        (yCrotch - yAnkle) * 0.47;

    const yShoulder =
        h - headH - neckH;

    const yWaist =
        yShoulder - torsoCm * s;

    const yHip = lerp(
        yCrotch,
        yWaist,
        0.35,
    );

    const yChest = lerp(
        yWaist,
        yShoulder,
        0.55,
    );

    const yNeckBase = yShoulder + neckH;
    const yHeadCenter =
        yNeckBase + headH * 0.45;

    // ── Radii from circumferences ────────

    const hipR = circ(
        hipCm,
        s,
        1.25,
    );

    const waistR = circ(
        waistCm,
        s,
        1.08,
    );

    const chestR = circ(
        chestCm,
        s,
        1.2,
    );

    const shW =
        (shoulderCm * s) / 2;

    const armLen = armCm * s;

    // ══════════════════════════════════════
    // AVATAR GROUP
    // ══════════════════════════════════════

    const avatar = new THREE.Group();

    avatar.name = NAME;

    // ══════════════════════════════════════
    // TORSO  (crotch → neck base)
    // ══════════════════════════════════════

    const shRx = Math.max(
        chestR.rx,
        shW,
    );

    const torsoKeys = [
        // Crotch (narrow)
        {
            y: yCrotch,
            rx: hipR.rx * 0.52,
            rz: hipR.rz * 0.65,
        },

        // Lower hip
        {
            y: lerp(
                yCrotch,
                yHip,
                0.5,
            ),
            rx: hipR.rx * 0.88,
            rz: hipR.rz * 0.88,
        },

        // Hip (widest lower body)
        {
            y: yHip,
            ...hipR,
        },

        // Hip → Waist transition
        {
            y: lerp(yHip, yWaist, 0.5),
            rx: lerp(
                hipR.rx,
                waistR.rx,
                0.55,
            ),
            rz: lerp(
                hipR.rz,
                waistR.rz,
                0.5,
            ),
        },

        // Waist (narrowest)
        {
            y: yWaist,
            ...waistR,
        },

        // Lower chest / rib cage
        {
            y: lerp(
                yWaist,
                yChest,
                0.4,
            ),
            rx: lerp(
                waistR.rx,
                chestR.rx,
                0.45,
            ),
            rz: lerp(
                waistR.rz,
                chestR.rz,
                0.3,
            ),
        },

        // Chest (widest upper body)
        {
            y: yChest,
            ...chestR,
        },

        // Upper chest
        {
            y: lerp(
                yChest,
                yShoulder,
                0.5,
            ),
            rx: lerp(
                chestR.rx,
                shRx,
                0.5,
            ),
            rz: chestR.rz * 0.88,
        },

        // Shoulder level
        {
            y: yShoulder,
            rx: shRx,
            rz: chestR.rz * 0.82,
        },

        // Neck base (taper quickly)
        {
            y: yNeckBase - neckH * 0.15,
            rx: shRx * 0.22,
            rz: chestR.rz * 0.28,
        },
    ];

    const torsoGeo = loftGeo(
        smooth(torsoKeys),
    );

    const torso = new THREE.Mesh(
        torsoGeo,
        material,
    );

    torso.name = 'avatar-torso';
    torso.castShadow = true;
    torso.receiveShadow = true;

    avatar.add(torso);

    // ══════════════════════════════════════
    // NECK
    // ══════════════════════════════════════

    const neckR = h * 0.031;

    const neckKeys = [
        {
            y: yNeckBase - neckH * 0.15,
            rx: neckR * 1.3,
            rz: neckR * 1.2,
        },
        {
            y: lerp(
                yNeckBase,
                yNeckBase + neckH * 0.5,
                0.5,
            ),
            rx: neckR * 1.05,
            rz: neckR,
        },
        {
            y: yNeckBase + neckH * 0.5,
            rx: neckR,
            rz: neckR * 0.95,
        },
    ];

    const neckGeo = loftGeo(
        smooth(neckKeys, 4),
    );

    avatar.add(
        new THREE.Mesh(neckGeo, material),
    );

    // ══════════════════════════════════════
    // HEAD
    // ══════════════════════════════════════

    const headR = headH * 0.42;

    const head = new THREE.Mesh(
        new THREE.SphereGeometry(
            headR,
            28,
            22,
        ),
        material,
    );

    head.scale.set(0.92, 1.1, 0.92);
    head.position.y = yHeadCenter;

    avatar.add(head);

    // ══════════════════════════════════════
    // SHOULDER CAPS (smooth bridge)
    // ══════════════════════════════════════

    const capR = h * 0.04;

    for (const side of [-1, 1]) {
        const cap = new THREE.Mesh(
            new THREE.SphereGeometry(
                capR,
                16,
                12,
            ),
            material,
        );

        cap.scale.set(1.15, 0.8, 0.95);

        cap.position.set(
            side * shW,
            yShoulder,
            0,
        );

        avatar.add(cap);
    }

    // ══════════════════════════════════════
    // ARMS
    // ══════════════════════════════════════

    const upperArmLen = armLen * 0.5;
    const forearmLen = armLen * 0.5;

    const upperArmR = h * 0.038;
    const forearmR = h * 0.03;
    const wristR = h * 0.022;
    const handR = h * 0.024;

    const armAngle = 0.18; // radians

    for (const side of [-1, 1]) {
        const arm = new THREE.Group();

        // Upper arm
        const upKeys = limbRings(
            upperArmLen,
            upperArmR,
            forearmR * 1.05,
            -upperArmLen,
        );

        const upGeo = loftGeo(
            upKeys,
            SEGS,
            false,
            true,
        );

        const upperMesh =
            new THREE.Mesh(
                upGeo,
                material,
            );

        upperMesh.castShadow = true;

        arm.add(upperMesh);

        // Elbow joint
        const elbow = new THREE.Mesh(
            new THREE.SphereGeometry(
                forearmR * 1.1,
                12,
                10,
            ),
            material,
        );

        elbow.position.y =
            -upperArmLen;

        arm.add(elbow);

        // Forearm
        const fKeys = limbRings(
            forearmLen,
            forearmR,
            wristR,
            -upperArmLen - forearmLen,
        );

        const fGeo = loftGeo(
            fKeys,
            SEGS,
            true,
            false,
        );

        const forearmMesh =
            new THREE.Mesh(
                fGeo,
                material,
            );

        forearmMesh.castShadow = true;

        arm.add(forearmMesh);

        // Hand (simple sphere)
        const hand = new THREE.Mesh(
            new THREE.SphereGeometry(
                handR,
                12,
                10,
            ),
            material,
        );

        hand.scale.set(
            0.7,
            1.1,
            0.5,
        );

        hand.position.y =
            -upperArmLen -
            forearmLen -
            handR * 0.6;

        arm.add(hand);

        // Position & rotate arm
        arm.position.set(
            side * shW,
            yShoulder,
            0,
        );

        arm.rotation.z =
            side * armAngle;

        avatar.add(arm);
    }

    // ══════════════════════════════════════
    // LEGS
    // ══════════════════════════════════════

    const thighLen =
        (yCrotch - yKnee) * 1.0;

    const calfLen =
        (yKnee - yAnkle) * 1.0;

    const thighR = h * 0.058;
    const kneeR = h * 0.04;
    const calfR = h * 0.038;
    const ankleR = h * 0.025;

    const legSpacing = Math.max(
        hipR.rx * 0.48,
        h * 0.042,
    );

    for (const side of [-1, 1]) {
        // Thigh
        const tKeys = limbRings(
            thighLen,
            thighR,
            kneeR,
            yKnee,
            6,
        );

        const tGeo = loftGeo(
            tKeys,
            SEGS,
            false,
            true,
        );

        const thigh = new THREE.Mesh(
            tGeo,
            material,
        );

        thigh.position.x =
            side * legSpacing;

        thigh.castShadow = true;

        avatar.add(thigh);

        // Knee joint
        const knee = new THREE.Mesh(
            new THREE.SphereGeometry(
                kneeR * 1.0,
                14,
                10,
            ),
            material,
        );

        knee.position.set(
            side * legSpacing,
            yKnee,
            0,
        );

        avatar.add(knee);

        // Calf
        const cKeys = limbRings(
            calfLen,
            calfR,
            ankleR,
            yAnkle,
            6,
        );

        const cGeo = loftGeo(
            cKeys,
            SEGS,
            true,
            false,
        );

        const calf = new THREE.Mesh(
            cGeo,
            material,
        );

        calf.position.x =
            side * legSpacing;

        calf.castShadow = true;

        avatar.add(calf);
    }

    // ══════════════════════════════════════
    // FEET
    // ══════════════════════════════════════

    const footR = h * 0.032;

    for (const side of [-1, 1]) {
        const foot = new THREE.Mesh(
            new THREE.CapsuleGeometry(
                footR,
                h * 0.04,
                8,
                12,
            ),
            material,
        );

        foot.rotation.x =
            Math.PI / 2;

        foot.scale.set(
            0.85,
            1.4,
            0.55,
        );

        foot.position.set(
            side * legSpacing,
            footR * 0.5,
            h * 0.025,
        );

        avatar.add(foot);
    }

    // ══════════════════════════════════════
    // GROUND CONTACT
    // ══════════════════════════════════════

    avatar.position.y = 0;

    return avatar;
}

// ──────────────────────────────────────────────────────────────
// PUBLIC: UPDATE AVATAR
// ──────────────────────────────────────────────────────────────

export function setCoveredTorsoVisible(avatar, visible) {
    if (!avatar) {
        return;
    }

    avatar.traverse((child) => {
        if (child.isMesh && child.name === 'avatar-torso') {
            child.visible = visible;
        }
    });
}

export function updateAvatar(
    avatar,
    opts = {},
) {
    if (!avatar) {
        return null;
    }

    const parent = avatar.parent;

    const pos =
        avatar.position.clone();

    const rot =
        avatar.rotation.clone();

    disposeGroup(avatar);

    if (parent) {
        parent.remove(avatar);
    }

    const next = createAvatar(opts);

    next.position.copy(pos);
    next.rotation.copy(rot);

    if (parent) {
        parent.add(next);
    }

    return next;
}