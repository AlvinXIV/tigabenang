import * as THREE from 'three';

// ──────────────────────────────────────────────────────────────
// CONSTANTS
// ──────────────────────────────────────────────────────────────

const SEGS   = 48;   // vertices per ring  (was 32 → smoother)
const INTERP = 8;    // interpolation steps (was 6  → smoother)
const NAME   = 'fitvendor-avatar';

// ──────────────────────────────────────────────────────────────
// SHARED SKIN MATERIAL
// ──────────────────────────────────────────────────────────────
//
// MeshPhysicalMaterial with clearcoat gives a subtle sheen
// similar to mannequin plastic / matte skin.
// ──────────────────────────────────────────────────────────────

const material =
    new THREE.MeshPhysicalMaterial({
        color: 0xc8b8a8,
        roughness: 0.48,
        metalness: 0.0,
        clearcoat: 0.18,
        clearcoatRoughness: 0.35,
        sheen: 0.15,
        sheenRoughness: 0.6,
        sheenColor: new THREE.Color(0xe8d0c0),
        side: THREE.DoubleSide,
    });

// ──────────────────────────────────────────────────────────────
// MATH
// ──────────────────────────────────────────────────────────────

const lerp = (a, b, t) =>
    a + (b - a) * t;

const smoothstep = (t) =>
    t * t * (3 - 2 * t);

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
// Each "ring" = { y, rx, rz, x?, z? }
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
    const nrm = [];
    const idx = [];
    const vpr = segs + 1;

    for (const r of rings) {
        for (let j = 0; j <= segs; j++) {
            const a =
                (j / segs) * Math.PI * 2;

            pos.push(
                (r.x || 0) + Math.cos(a) * r.rx,
                r.y,
                (r.z || 0) + Math.sin(a) * r.rz,
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

        pos.push(r.x || 0, r.y, r.z || 0);

        for (let j = 0; j < segs; j++) {
            idx.push(ci, j + 1, j);
        }
    }

    if (capTop) {
        const ci = pos.length / 3;
        const li = rings.length - 1;
        const r = rings[li];

        pos.push(r.x || 0, r.y, r.z || 0);

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
                x: catmull(
                    r0.x || 0,
                    r1.x || 0,
                    r2.x || 0,
                    r3.x || 0,
                    t,
                ),
                z: catmull(
                    r0.z || 0,
                    r1.z || 0,
                    r2.z || 0,
                    r3.z || 0,
                    t,
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
// BUILD LIMB TUBE (improved with anatomical muscle curve)
// ──────────────────────────────────────────────────────────────

function limbRings(
    len,
    rTop,
    rBot,
    yBase = 0,
    n = 7,
    bulgeAmount = 0.12,
    bulgePeak = 0.35,
) {
    const keys = [];

    for (let i = 0; i <= n; i++) {
        const t = i / n;

        const r = lerp(rTop, rBot, t);

        // Anatomical muscle bulge — peaks near top 1/3
        const bulgeT = Math.sin(
            Math.pow(t, 0.7) * Math.PI,
        );
        const bulge =
            bulgeT *
            bulgeAmount *
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

    return smooth(keys, 5);
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
    const neckH = h * 0.032;

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
        1.30,
    );

    const chestR = circ(
        chestCm,
        s,
        1.70,
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
    //
    // Many more key-rings for anatomical
    // detail: pelvis, obliques, ribcage,
    // pectoral shelf, clavicle taper.
    // ══════════════════════════════════════

    const shRx = Math.max(
        chestR.rx,
        shW,
    );

    const torsoKeys = [
        // ── Crotch (narrow V) ──
        {
            y: yCrotch,
            rx: hipR.rx * 0.50,
            rz: hipR.rz * 0.60,
            z: h * 0.015,
        },

        // ── Inner thigh junction ──
        {
            y: lerp(yCrotch, yHip, 0.25),
            rx: hipR.rx * 0.72,
            rz: hipR.rz * 0.70,
            z: h * 0.015,
        },

        // ── Lower pelvis ──
        {
            y: lerp(yCrotch, yHip, 0.50),
            rx: hipR.rx * 0.90,
            rz: hipR.rz * 0.82,
            z: h * 0.012,
        },

        // ── Upper pelvis / gluteal shelf ──
        {
            y: lerp(yCrotch, yHip, 0.75),
            rx: hipR.rx * 0.98,
            rz: hipR.rz * 0.85,
            z: h * 0.010,
        },

        // ── Hip (widest lower body) ──
        {
            y: yHip,
            rx: hipR.rx,
            rz: hipR.rz * 0.85,
            z: h * 0.008,
        },

        // ── Iliac crest ──
        {
            y: lerp(yHip, yWaist, 0.25),
            rx: lerp(hipR.rx, waistR.rx, 0.30),
            rz: lerp(hipR.rz, waistR.rz, 0.25),
            z: h * 0.005,
        },

        // ── Oblique area ──
        {
            y: lerp(yHip, yWaist, 0.55),
            rx: lerp(hipR.rx, waistR.rx, 0.60),
            rz: lerp(hipR.rz, waistR.rz, 0.50),
            z: h * 0.002,
        },

        // ── Waist (narrowest) ──
        {
            y: yWaist,
            rx: waistR.rx,
            rz: waistR.rz * 0.90,
            z: h * 0.000,
        },

        // ── Lower rib cage ──
        {
            y: lerp(yWaist, yChest, 0.25),
            rx: lerp(waistR.rx, chestR.rx, 0.30),
            rz: lerp(waistR.rz, chestR.rz, 0.20) * 0.90,
            z: h * 0.005,
        },

        // ── Mid rib cage ──
        {
            y: lerp(yWaist, yChest, 0.45),
            rx: lerp(waistR.rx, chestR.rx, 0.55),
            rz: lerp(waistR.rz, chestR.rz, 0.30) * 0.90,
            z: h * 0.005,
        },

        // ── Chest (pectoral shelf) ──
        {
            y: yChest,
            rx: chestR.rx,
            rz: chestR.rz * 0.90,
            z: h * 0.000,
        },

        // ── Upper pectoral ──
        {
            y: lerp(yChest, yShoulder, 0.30),
            rx: lerp(chestR.rx, shRx, 0.35),
            rz: chestR.rz * 0.78,
            z: h * 0.005,
        },

        // ── Clavicle level ──
        {
            y: lerp(yChest, yShoulder, 0.55),
            rx: lerp(chestR.rx, shRx * 0.75, 0.50),
            rz: chestR.rz * 0.50,
            z: -h * 0.005,
        },

        // ── Shoulder level (sloped down) ──
        {
            y: yShoulder,
            rx: shRx * 0.75,
            rz: chestR.rz * 0.38,
            z: -h * 0.006,
        },

        // ── Trapezius slope ──
        {
            y: yShoulder + neckH * 0.20,
            rx: shRx * 0.36,
            rz: chestR.rz * 0.32,
            z: h * 0.000,
        },

        // ── Upper trapezius ──
        {
            y: yShoulder + neckH * 0.42,
            rx: shRx * 0.30,
            rz: chestR.rz * 0.30,
            z: h * 0.003,
        },

        // ── Neck base ──
        {
            y: yNeckBase - neckH * 0.10,
            rx: shRx * 0.20,
            rz: chestR.rz * 0.25,
            z: h * 0.005,
        },
    ];

    const torsoGeo = loftGeo(
        smooth(torsoKeys),
    );

    const torso = new THREE.Mesh(
        torsoGeo,
        material,
    );
    torso.name = 'torso';

    torso.castShadow = true;
    torso.receiveShadow = true;

    avatar.add(torso);

    // ══════════════════════════════════════
    // NECK (more anatomical rings)
    // ══════════════════════════════════════

    const neckR = h * 0.032;

    const neckKeys = [
        {
            y: yNeckBase - neckH * 0.10,
            rx: neckR * 1.35,
            rz: neckR * 1.25,
            z: h * 0.005,
        },
        {
            y: yNeckBase + neckH * 0.15,
            rx: neckR * 1.15,
            rz: neckR * 1.10,
            z: h * 0.008,
        },
        {
            y: yNeckBase + neckH * 0.45,
            rx: neckR * 1.05,
            rz: neckR * 1.00,
            z: h * 0.010,
        },
        {
            y: yNeckBase + neckH * 0.75,
            rx: neckR * 1.00,
            rz: neckR * 0.95,
            z: h * 0.012,
        },
        {
            y: yNeckBase + neckH,
            rx: neckR * 0.96,
            rz: neckR * 0.90,
            z: h * 0.014,
        },
    ];

    const neckGeo = loftGeo(
        smooth(neckKeys, 5),
    );

    const neckMesh = new THREE.Mesh(neckGeo, material);
    neckMesh.castShadow = true;
    avatar.add(neckMesh);

    // ══════════════════════════════════════
    // HEAD (skull-shaped ellipsoid)
    // ══════════════════════════════════════

    const headR = headH * 0.42;

    // Cranium — slightly elongated top-to-bottom, narrower side-to-side
    const headGeo = new THREE.SphereGeometry(
        headR,
        32,
        26,
    );

    const head = new THREE.Mesh(
        headGeo,
        material,
    );

    head.scale.set(0.90, 1.12, 0.95);
    head.position.set(0, yHeadCenter, h * 0.015);
    head.castShadow = true;

    avatar.add(head);

    // Jaw / chin subtle bulge
    const jawGeo = new THREE.SphereGeometry(
        headR * 0.55,
        16,
        12,
        0,
        Math.PI * 2,
        Math.PI * 0.3,
        Math.PI * 0.7,
    );

    const jaw = new THREE.Mesh(jawGeo, material);
    jaw.scale.set(0.82, 0.50, 0.85);
    jaw.position.set(
        0,
        yHeadCenter - headR * 0.55,
        h * 0.025,
    );
    avatar.add(jaw);

    // ══════════════════════════════════════
    // SHOULDER CAPS (deltoid — dropped/sloped)
    // ══════════════════════════════════════

    const capR = h * 0.020;

    for (const side of [-1, 1]) {
        // Deltoid cap — small, fits inside shirt
        const cap = new THREE.Mesh(
            new THREE.SphereGeometry(
                capR,
                18,
                12,
            ),
            material,
        );

        cap.scale.set(0.80, 0.55, 0.60);

        cap.position.set(
            side * shW * 0.86,
            yShoulder - h * 0.016,
            -h * 0.015,
        );

        cap.castShadow = true;
        avatar.add(cap);
    }

    // ══════════════════════════════════════
    // ARMS (improved muscle definition)
    // ══════════════════════════════════════

    const upperArmLen = armLen * 0.50;
    const forearmLen = armLen * 0.50;

    const upperArmR = h * 0.022;
    const forearmR = h * 0.017;
    const wristR = h * 0.013;
    const handLen = h * 0.050;
    const handW = h * 0.019;

    const armAngleZ = 0.62;  // More spread to raise arms higher
    const armAngleX = 0.00;

    for (const side of [-1, 1]) {
        const arm = new THREE.Group();

        // ── Upper arm (bicep/tricep bulge) ──
        const upKeys = limbRings(
            upperArmLen,
            upperArmR,
            forearmR * 1.05,
            -upperArmLen,
            8,
            0.15,    // more pronounced muscle
            0.35,
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

        // ── Elbow joint ──
        const elbow = new THREE.Mesh(
            new THREE.SphereGeometry(
                forearmR * 1.12,
                14,
                12,
            ),
            material,
        );

        elbow.position.y =
            -upperArmLen;
        elbow.scale.set(1.0, 0.85, 0.95);

        arm.add(elbow);

        // ── Forearm (tapered) ──
        const fKeys = limbRings(
            forearmLen,
            forearmR,
            wristR,
            -upperArmLen - forearmLen,
            8,
            0.10,
            0.30,
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

        // ── Wrist joint (smooth transition) ──
        const wrist = new THREE.Mesh(
            new THREE.SphereGeometry(
                wristR * 1.05,
                12,
                10,
            ),
            material,
        );
        wrist.position.y =
            -upperArmLen - forearmLen;
        wrist.scale.set(1.05, 0.80, 0.90);
        arm.add(wrist);

        // ── Hand (palm + finger taper) ──
        const handKeys = [
            { y: 0, rx: handW, rz: handW * 0.45 },
            { y: -handLen * 0.15, rx: handW * 1.10, rz: handW * 0.48 },
            { y: -handLen * 0.40, rx: handW * 1.05, rz: handW * 0.45 },
            { y: -handLen * 0.65, rx: handW * 0.90, rz: handW * 0.38 },
            { y: -handLen * 0.85, rx: handW * 0.65, rz: handW * 0.30 },
            { y: -handLen, rx: handW * 0.35, rz: handW * 0.22 },
        ];

        const handGeo = loftGeo(
            smooth(handKeys, 4),
            SEGS,
            true,
            true,
        );

        const handMesh = new THREE.Mesh(
            handGeo,
            material,
        );

        handMesh.position.y =
            -upperArmLen -
            forearmLen -
            wristR * 0.5;

        handMesh.castShadow = true;
        arm.add(handMesh);

        // ── Position & rotate arm (raised higher) ──
        arm.position.set(
            side * shW * 0.88,
            yShoulder - h * 0.008,
            -h * 0.015,
        );

        arm.rotation.order = 'ZXY';
        arm.rotation.z = side * armAngleZ;
        arm.rotation.x = armAngleX;

        avatar.add(arm);
    }

    // ══════════════════════════════════════
    // LEGS (improved anatomy)
    // ══════════════════════════════════════

    const thighLen =
        (yCrotch - yKnee) * 1.0;

    const calfLen =
        (yKnee - yAnkle) * 1.0;

    const thighR = h * 0.050;
    const kneeR = h * 0.038;
    const calfR = h * 0.037;
    const ankleR = h * 0.024;

    const legSpacing = Math.max(
        hipR.rx * 0.35,
        h * 0.035,
    );

    for (const side of [-1, 1]) {
        // ── Thigh (quadriceps bulge) ──
        const tKeys = limbRings(
            thighLen,
            thighR,
            kneeR,
            yKnee,
            8,
            0.10,
            0.35,
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

        thigh.position.set(
            side * legSpacing,
            0,
            h * 0.015,
        );

        thigh.castShadow = true;

        avatar.add(thigh);

        // ── Knee (slightly bony) ──
        const knee = new THREE.Mesh(
            new THREE.SphereGeometry(
                kneeR * 1.02,
                16,
                12,
            ),
            material,
        );

        knee.scale.set(1.0, 0.85, 1.05);

        knee.position.set(
            side * legSpacing,
            yKnee,
            h * 0.015,
        );

        knee.castShadow = true;
        avatar.add(knee);

        // ── Calf (gastrocnemius bulge near top) ──
        const cKeys = [];
        const calfSteps = 9;
        for (let i = 0; i <= calfSteps; i++) {
            const t = i / calfSteps;
            const base = lerp(calfR, ankleR, t);

            // Calf muscle bulge — peaks at t≈0.25
            const calfBulge =
                Math.sin(Math.pow(t, 0.5) * Math.PI) *
                calfR * 0.18;

            // Slightly wider in back (gastrocnemius)
            const rzExtra = (t < 0.5)
                ? calfBulge * 0.5
                : 0;

            cKeys.push({
                y: yAnkle + calfLen * (1 - t),
                rx: (base + calfBulge) * 1.02,
                rz: base + calfBulge + rzExtra,
                z: (t < 0.4) ? -calfR * 0.06 : 0,
            });
        }

        const cGeo = loftGeo(
            smooth(cKeys, 5),
            SEGS,
            true,
            false,
        );

        const calf = new THREE.Mesh(
            cGeo,
            material,
        );

        calf.position.set(
            side * legSpacing,
            0,
            h * 0.015,
        );

        calf.castShadow = true;

        avatar.add(calf);

        // ── Ankle transition ──
        const ankle = new THREE.Mesh(
            new THREE.SphereGeometry(
                ankleR * 1.05,
                14,
                10,
            ),
            material,
        );

        ankle.scale.set(1.05, 0.75, 0.90);
        ankle.position.set(
            side * legSpacing,
            yAnkle,
            h * 0.015,
        );

        avatar.add(ankle);
    }

    // ══════════════════════════════════════
    // FEET (anatomically shaped)
    // ══════════════════════════════════════

    const footLen = h * 0.078;
    const footW = h * 0.032;
    const footH = h * 0.022;

    for (const side of [-1, 1]) {
        const footKeys = [
            // Heel
            { y: 0, rx: footW * 0.85, rz: footH * 0.90 },
            // Arch
            { y: 0, rx: footW * 0.88, rz: footH * 0.75, z: footLen * 0.20 },
            // Mid-foot
            { y: 0, rx: footW * 1.00, rz: footH * 0.80, z: footLen * 0.45 },
            // Ball of foot
            { y: 0, rx: footW * 1.05, rz: footH * 0.85, z: footLen * 0.70 },
            // Toe taper
            { y: 0, rx: footW * 0.72, rz: footH * 0.60, z: footLen * 0.90 },
            // Toe tip
            { y: 0, rx: footW * 0.30, rz: footH * 0.35, z: footLen },
        ];

        // Rotate foot keys: swap y↔z for horizontal loft along Z
        const rotatedKeys = footKeys.map(k => ({
            y: (k.z || 0) - footLen * 0.30, // center on ball
            rx: k.rx,
            rz: k.rz,
        }));

        const footGeo = loftGeo(
            smooth(rotatedKeys, 4),
            SEGS,
            true,
            true,
        );

        const foot = new THREE.Mesh(
            footGeo,
            material,
        );

        foot.rotation.x = Math.PI / 2;

        foot.position.set(
            side * legSpacing,
            footH * 0.85,
            h * 0.035,
        );

        foot.castShadow = true;
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