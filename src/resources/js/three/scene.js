import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

export function createFittingScene(container) {
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xebe3d6);

    const camera = new THREE.PerspectiveCamera(
        35,
        Math.max(container.clientWidth, 1) / Math.max(container.clientHeight, 1),
        0.1,
        100,
    );
    camera.position.set(0, 1.4, 4.2);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: false });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    container.appendChild(renderer.domElement);

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.target.set(0, 1.1, 0);
    controls.minDistance = 2.4;
    controls.maxDistance = 7;
    controls.maxPolarAngle = Math.PI * 0.55;

    const ambient = new THREE.AmbientLight(0xf4efe6, 1.1);
    const key = new THREE.DirectionalLight(0xffffff, 1.15);
    key.position.set(2.4, 4, 3);
    const fill = new THREE.DirectionalLight(0xb85c38, 0.25);
    fill.position.set(-3, 1.5, -1);
    scene.add(ambient, key, fill);

    const floor = new THREE.Mesh(
        new THREE.CircleGeometry(2.4, 48),
        new THREE.MeshStandardMaterial({ color: 0xddd4c8, roughness: 0.9, metalness: 0 }),
    );
    floor.rotation.x = -Math.PI / 2;
    scene.add(floor);

    const garmentGroup = new THREE.Group();
    scene.add(garmentGroup);

    let frame = 0;
    const animate = () => {
        frame = requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    };
    animate();

    const resize = () => {
        const width = Math.max(container.clientWidth, 1);
        const height = Math.max(container.clientHeight, 1);
        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
    };

    window.addEventListener('resize', resize);

    return {
        scene,
        camera,
        renderer,
        garmentGroup,
        resize,
        dispose() {
            cancelAnimationFrame(frame);
            window.removeEventListener('resize', resize);
            controls.dispose();
            renderer.dispose();
            renderer.domElement.remove();
        },
    };
}
