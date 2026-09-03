import fs from 'fs';

// catmull implementation from avatar.js
function catmull(p0, p1, p2, p3, t) {
    const v0 = (p2 - p0) * 0.5;
    const v1 = (p3 - p1) * 0.5;
    const t2 = t * t;
    const t3 = t * t2;

    return (
        (2 * p1 - 2 * p2 + v0 + v1) * t3 +
        (-3 * p1 + 3 * p2 - 2 * v0 - v1) * t2 +
        v0 * t +
        p1
    );
}

function smooth(keys, steps = 10) {
    if (keys.length < 2) return [...keys];
    const out = [];
    const n = keys.length;
    for (let i = 0; i < n - 1; i++) {
        const r0 = keys[Math.max(0, i - 1)];
        const r1 = keys[i];
        const r2 = keys[i + 1];
        const r3 = keys[Math.min(n - 1, i + 2)];

        for (let s = 0; s < steps; s++) {
            const t = s / steps;
            out.push({
                y: catmull(r0.y, r1.y, r2.y, r3.y, t),
                z: catmull(r0.z || 0, r1.z || 0, r2.z || 0, r3.z || 0, t),
                rz: catmull(r0.rz, r1.rz, r2.rz, r3.rz, t)
            });
        }
    }
    out.push(keys[n - 1]);
    return out;
}

const h = 1.7; // 170cm
const chestR = { rx: 0.18, rz: 0.139 };
const waistR = { rx: 0.16, rz: 0.12 };
const hipR = { rx: 0.17, rz: 0.14 };
const shRx = 0.22;
const yCrotch = 0;
const yHip = 0.2;
const yWaist = 0.4;
const yChest = 0.6;
const yShoulder = 0.75;
const yNeckBase = 0.8;
const neckH = 0.1;

function lerp(a, b, t) { return a + (b - a) * t; }

const torsoKeys = [
    { y: yCrotch, rx: hipR.rx * 0.52, rz: hipR.rz * 0.65, z: h * 0.015 },
    { y: lerp(yCrotch, yHip, 0.5), rx: hipR.rx * 0.88, rz: hipR.rz * 0.88, z: -h * 0.005 },
    { y: yHip, ...hipR, z: -h * 0.020 },
    { y: lerp(yHip, yWaist, 0.5), rx: lerp(hipR.rx, waistR.rx, 0.55), rz: lerp(hipR.rz, waistR.rz, 0.5), z: -h * 0.005 },
    { y: yWaist, ...waistR, z: h * 0.015 },
    { y: lerp(yWaist, yChest, 0.4), rx: lerp(waistR.rx, chestR.rx, 0.45), rz: lerp(waistR.rz, chestR.rz, 0.25), z: h * 0.025 },
    { y: yChest, ...chestR, z: h * 0.022 },
    { y: lerp(yChest, yShoulder, 0.5), rx: lerp(chestR.rx, shRx, 0.5), rz: chestR.rz * 0.85, z: h * 0.015 },
    { y: yShoulder, rx: shRx, rz: chestR.rz * 0.70, z: h * 0.005 },
    { y: yNeckBase - neckH * 0.15, rx: shRx * 0.22, rz: chestR.rz * 0.28, z: h * 0.005 },
];

const smoothed = smooth(torsoKeys);
for (const r of smoothed) {
    console.log(`y: ${r.y.toFixed(3)}, z: ${r.z.toFixed(3)}, rz: ${r.rz.toFixed(3)}, frontZ: ${(r.z + r.rz).toFixed(3)}, backZ: ${(r.z - r.rz).toFixed(3)}`);
}
