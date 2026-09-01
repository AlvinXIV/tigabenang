import * as THREE from 'three';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

export function createFittingScene(container) {

    const scene = new THREE.Scene();

    scene.background = new THREE.Color(
        0xebe3d6,
    );

    /*
    |--------------------------------------------------------------------------
    | CAMERA
    |--------------------------------------------------------------------------
    */

    const camera = new THREE.PerspectiveCamera(
        35,
        Math.max(
            container.clientWidth,
            1,
        ) /
        Math.max(
            container.clientHeight,
            1,
        ),
        0.1,
        100,
    );

    camera.position.set(
        0,
        1.05,
        4.8,
    );

    /*
    |--------------------------------------------------------------------------
    | RENDERER
    |--------------------------------------------------------------------------
    */

    const renderer =
        new THREE.WebGLRenderer({
            antialias: true,
            alpha: true,
        });

    renderer.setPixelRatio(
        Math.min(
            window.devicePixelRatio,
            2,
        ),
    );

    renderer.setSize(
        Math.max(container.clientWidth, 1),
        Math.max(container.clientHeight, 1),
    );

    renderer.domElement.style.display = 'block';
    renderer.domElement.style.width = '100%';
    renderer.domElement.style.height = '100%';

    renderer.outputColorSpace =
        THREE.SRGBColorSpace;

    renderer.shadowMap.enabled = true;

    container.appendChild(
        renderer.domElement,
    );

    /*
    |--------------------------------------------------------------------------
    | CONTROLS
    |--------------------------------------------------------------------------
    */

    const controls =
        new OrbitControls(
            camera,
            renderer.domElement,
        );

    controls.enableDamping = true;

    controls.target.set(
        0,
        0.95,
        0,
    );

    controls.minDistance = 2.8;

    controls.maxDistance = 7;

    controls.maxPolarAngle =
        Math.PI * 0.55;

    /*
    |--------------------------------------------------------------------------
    | LIGHTING
    |--------------------------------------------------------------------------
    */

    const ambient =
        new THREE.HemisphereLight(
            0xfff8ed,
            0x8d8174,
            2.0,
        );

    scene.add(ambient);

    const key =
        new THREE.DirectionalLight(
            0xffffff,
            2.0,
        );

    key.position.set(
        3,
        5,
        4,
    );

    key.castShadow = true;

    scene.add(key);

    const fill =
        new THREE.DirectionalLight(
            0xffdfc8,
            0.6,
        );

    fill.position.set(
        -3,
        2,
        2,
    );

    scene.add(fill);

    /*
    |--------------------------------------------------------------------------
    | FLOOR
    |--------------------------------------------------------------------------
    */

    const floor =
        new THREE.Mesh(
            new THREE.CircleGeometry(
                1.6,
                48,
            ),
            new THREE.MeshStandardMaterial({
                color: 0xd0c5b8,
                roughness: 0.95,
                metalness: 0,
            }),
        );

    floor.rotation.x =
        -Math.PI / 2;

    floor.position.y = 0;

    floor.receiveShadow = true;

    scene.add(floor);

    /*
    |--------------------------------------------------------------------------
    | GARMENT GROUP
    |--------------------------------------------------------------------------
    |
    | Belum digunakan.
    | Nanti baju akan masuk ke sini.
    |
    */

    const garmentGroup =
        new THREE.Group();

    garmentGroup.name =
        'garment-group';

    scene.add(garmentGroup);

    /*
    |--------------------------------------------------------------------------
    | ANIMATION
    |--------------------------------------------------------------------------
    */

    let frame = 0;

    const animate = () => {

        frame =
            requestAnimationFrame(
                animate,
            );

        controls.update();

        renderer.render(
            scene,
            camera,
        );
    };

    animate();

    /*
    |--------------------------------------------------------------------------
    | RESIZE
    |--------------------------------------------------------------------------
    */

    const resize = () => {

        const width =
            Math.max(
                container.clientWidth,
                1,
            );

        const height =
            Math.max(
                container.clientHeight,
                1,
            );

        camera.aspect =
            width / height;

        camera.updateProjectionMatrix();

        renderer.setSize(
            width,
            height,
        );
    };

    const resizeObserver =
        new ResizeObserver(resize);

    resizeObserver.observe(container);

    /*
    |--------------------------------------------------------------------------
    | RETURN
    |--------------------------------------------------------------------------
    */

    const resetView = () => {
        camera.position.set(0, 1.05, 4.8);
        controls.target.set(0, 0.95, 0);
        controls.update();
    };

    return {
        scene,
        camera,
        renderer,
        controls,
        garmentGroup,
        resize,
        resetView,

        dispose() {

            cancelAnimationFrame(
                frame,
            );

            resizeObserver.disconnect();

            controls.dispose();

            renderer.dispose();

            renderer.domElement.remove();
        },
    };
}