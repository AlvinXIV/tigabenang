# Tigabenang

Tigabenang adalah aplikasi web vendor pakaian custom yang membantu pelanggan melihat katalog pakaian, memilih bahan, menentukan ukuran dan jumlah pesanan, serta melakukan simulasi ukuran melalui fitur virtual fitting 3D.

---

## Daftar isi

1. [Penjelasan aplikasi](#1-penjelasan-aplikasi)
2. [Fitur utama](#2-fitur-utama)
3. [Teknologi yang digunakan](#3-teknologi-yang-digunakan)
4. [Struktur folder](#4-struktur-folder)
5. [Halaman dan route](#5-halaman-dan-route)
6. [Virtual Fitting](#6-virtual-fitting)
7. [Docker](#7-docker)
8. [Cara instalasi](#8-cara-instalasi)
9. [Cara penggunaan](#9-cara-penggunaan)
10. [Pengujian](#10-pengujian)
11. [Konfigurasi development](#11-konfigurasi-development)

---

## 1. Penjelasan aplikasi

### Latar belakang

Pemesanan pakaian custom biasanya melibatkan beberapa langkah yang terpisah: memilih model, menentukan bahan dan ukuran, mengirim desain, lalu menawar harga. Proses itu sering terjadi di chat, tanpa catatan yang rapi di sisi vendor.

Tujuannya meniru alur kerja nyata dari permintaan pelanggan sampai pemrosesan admin, tanpa bergantung pada partner bisnis atau API supplier eksternal.

### Tujuan

Aplikasi ini bertujuan:

- memberi pelanggan halaman katalog, detail produk, dan Virtual Fitting;
- menerima permintaan pesanan lengkap (data pemesan, produk, bahan, ukuran, desain, catatan);
- memberi admin satu tempat untuk meninjau pesanan dan menetapkan harga final;
- mendokumentasikan kesepakatan lewat tautan WhatsApp, PDF konsultasi, dan faktur.

### Alur bisnis

Alur yang berlaku di kode saat ini:

1. Pelanggan mengisi formulir pesanan.
2. Pesanan masuk ke portal admin.
3. Admin menghubungi pelanggan melalui tautan WhatsApp.
4. Harga dinegosiasikan di luar aplikasi (chat WhatsApp).
5. Admin memasukkan harga yang sudah disepakati.
6. Admin dapat membuka atau mencetak faktur setelah harga terisi.

---

## 2. Fitur utama

Navbar customer menampilkan: **Beranda**, **Koleksi**, **Virtual fitting**, dan **Tentang**.

### Storefront pelanggan

**Beranda (`/`)**  
Halaman pembuka brand. Isinya hero, ajakan ke pesanan dan Virtual Fitting, cuplikan kategori, grid produk, layanan produksi, FAQ, dan testimoni.

**Koleksi (`/collection`)**  
Daftar produk dengan filter kategori lewat query `?category=`. Setiap kartu menampilkan gambar, nama, kategori, dan harga mulai.

**Detail produk (`/collection/{produk}`)**  
Menampilkan gambar, harga, bahan yang terkait produk, size chart kategori, serta pratinjau model 3D jika `file_model_3d` terisi. Dari sini pelanggan dapat lanjut ke formulir pesanan atau Virtual Fitting.

**Bahan pada detail produk**  
Bahan diambil dari relasi `produk_bahan`. Jika produk belum punya relasi bahan, formulir pesanan menampilkan seluruh bahan yang ada di katalog.

**Virtual Fitting (`/virtual-fitting`)**  
Studio 3D untuk produk yang sudah punya model. Pengguna memilih produk, mengatur ukuran tubuh, melihat rekomendasi size, dan memuat garment ke avatar. Penjelasan teknis ada di [bagian 6](#6-virtual-fitting).

**Tentang (`/about`)**  
Profil brand, proses kerja, dan kontak. Email yang tampil memakai konfigurasi kontak (default `hello@tigabenang.id`) plus tautan WhatsApp.

**Request pesanan (`/order/create`)**  
Formulir konsultasi. Data yang diisi:

- nama, alamat, nomor telepon;
- produk (dan kategori mengikuti produk);
- bahan;
- ukuran beserta jumlah per size;
- unggah desain (opsional);
- catatan (opsional).

Total yang ditampilkan adalah **estimasi** (`harga produk × total kuantitas`). Harga final tidak diisi pelanggan. Submit menyimpan pesanan dengan `total_harga = null`, lalu mengarah ke halaman sukses.

**Halaman sukses (`/order/success`)**  
Ringkasan permintaan, estimasi, tautan WhatsApp berisi detail konsultasi, dan tautan PDF.

**PDF pesanan (`/order/{id}/pdf`)**  
Lembar konsultasi yang bisa dibuka atau dicetak. Bukan faktur pembayaran.

**Form pemesanan deal (`/form-pemesanan`)**  
Formulir mandiri dengan data inti yang sama. Setelah submit, `total_harga` juga `null`. Halaman suksesnya di `/form-pemesanan/sukses`.

**Katalog bahan (`/materials`)**  
Halaman baca saja yang menampilkan bahan. Route ini ada, tetapi **tidak** masuk navbar utama.

### Portal admin

Portal admin dipakai untuk operasional pesanan dan penetapan harga. Semua route di bawah `/admin` memakai middleware `auth`. `GET /admin` diarahkan ke dashboard.

**Dashboard**  
Ringkasan jumlah pesanan, pesanan menunggu harga, pesanan yang sudah ada harga, dan daftar yang perlu ditindaklanjuti.

**Analytics**  
Ringkasan historis: penjualan, jumlah pesanan, rata-rata nilai pesanan, grafik, serta produk dan bahan yang sering muncul. Grafik memakai Chart.js.

**Produk**  
CRUD produk: nama, kategori, harga, gambar, bahan, dan file model 3D.

**Kategori**  
CRUD kategori pakaian (contoh seeder: Jaket Varsity, Work Jacket, JaketWindbreaker, Jersey, Kaos).

**Bahan**  
Nama bahan dikelola di modul yang sama dengan kategori (`/admin/kategori`), bukan halaman admin terpisah. Tidak ada manajemen stok.

**Size chart**  
Ukuran per kategori: nama size, lebar dada, panjang, lebar bahu, dan panjang lengan.

**Model 3D**  
Unggah atau lepas file `.glb` / `.gltf` pada produk, plus halaman pratinjau (`<model-viewer>`).

**Pesanan**  
Daftar pesanan, pembuatan pesanan manual, detail, penetapan harga, dan faktur. Status “dikonfirmasi” di dashboard berarti `total_harga` sudah terisi. Tidak ada kolom status produksi terpisah.

**Pelanggan**  
Dikelompokkan dari data pesanan (nama/telepon). Bukan direktori CRM terpisah.

**Settings / Profile**  
Ubah nama, email di UI, dan password akun admin yang sedang login.

**Login & register**  
Login di `/login`. Field form bernama `email`, tetapi autentikasi mencoba kolom `username` (lalu `nama`) pada tabel `users`. Halaman `/register` ada, namun controller saat ini hanya mengarahkan ke login **tanpa menyimpan akun baru**.

---

## Sustainable Development Goals (SDGs)

Tigabenang berkontribusi pada SDG secara tidak langsung: aplikasi memfasilitasi digitalisasi proses bisnis vendor pakaian custom. Kontribusi ini bersifat pendukung, bukan klaim bahwa aplikasi secara langsung mencapai target SDG.

| SDG | Relevansi dengan Tigabenang |
|---|---|
| SDG 8 | Digitalisasi proses bisnis vendor pakaian custom dan dukungan terhadap aktivitas usaha |
| SDG 9 | Pemanfaatan teknologi digital, Docker, dan Virtual Fitting 3D |

### SDG 8 — Pekerjaan Layak dan Pertumbuhan Ekonomi

Tigabenang mendukung SDG 8 melalui pemanfaatan teknologi digital untuk membantu proses bisnis vendor pakaian custom, khususnya dalam pengelolaan katalog, permintaan produksi, komunikasi dengan pelanggan, dan pengelolaan pesanan.

Hubungan yang sesuai dengan implementasi saat ini:

- Membantu digitalisasi proses bisnis vendor pakaian custom.
- Membuat proses permintaan produksi lebih terstruktur lewat formulir pesanan, PDF konsultasi, dan portal admin.
- Membantu vendor/UMKM menjalankan proses katalog dan pesanan melalui platform digital.
- Mempermudah komunikasi antara pelanggan dan vendor melalui alur konsultasi WhatsApp.
- Membantu pengelolaan pesanan dan faktur di sisi admin.
- Membuka peluang pemanfaatan teknologi dalam aktivitas usaha pakaian custom.

Aplikasi ini tidak diklaim menciptakan lapangan kerja secara langsung, menjamin pekerjaan layak, meningkatkan pendapatan secara terukur, menambah jumlah UMKM, atau meningkatkan ekonomi daerah.

### SDG 9 — Industri, Inovasi dan Infrastruktur

Tigabenang berkontribusi pada SDG 9 dari sisi industri, inovasi teknologi, dan digitalisasi proses — bukan pembangunan infrastruktur skala besar.

Bentuk kontribusinya:

- pengembangan platform digital untuk bisnis pakaian custom;
- penggunaan Laravel dan PostgreSQL;
- Docker sebagai lingkungan pengembangan;
- Vite untuk frontend;
- Three.js untuk visualisasi 3D;
- Virtual Fitting sebagai pemanfaatan teknologi 3D agar pelanggan mendapat pratinjau pakaian.

---

## 3. Teknologi yang digunakan

| Lapisan | Teknologi | Keterangan |
|---|---|---|
| Runtime PHP | PHP 8.3-FPM (Docker), requirement `^8.2` | Image `php:8.3-fpm` di `Dockerfile` |
| Framework | Laravel 13 (`^13.8`) | Aplikasi di `src/` |
| Templating | Laravel Blade | View customer dan admin |
| Admin UI | Livewire 3 (`^3.8`) | Dashboard, produk, pesanan, analytics, dan modul admin lain |
| Database | PostgreSQL | `DB_CONNECTION=pgsql` |
| Session, cache, queue | Driver `database` (contoh env) | `src/.env.example` |
| Storage | Flysystem, disk `local` / `public` / `supabase` | `supabase` memakai S3-compatible API |
| Build frontend | Vite 8 | `src/vite.config.js` |
| CSS | Tailwind CSS 4 | Plugin `@tailwindcss/vite` |
| Interaksi UI | Alpine.js 3 | `resources/js/app.js` |
| Virtual Fitting | Three.js 0.183 + GLTFLoader | `resources/js/three/` |
| Pratinjau 3D di detail produk | `@google/model-viewer` 4.3 | Dimuat jika ada elemen `<model-viewer>` |
| Grafik admin | Chart.js 4.5 | Dimuat saat ada elemen chart |
| Tes | PHPUnit 12 | `src/phpunit.xml`, SQLite in-memory |
| Orkestrasi | Docker Compose | `docker-compose.yml` |
| HTTP | Nginx Alpine | Port host `8000` |
| Frontend container | Node 22 Alpine | Profile Compose `vite`, port `5173` |
| Postgres Docker | PostgreSQL 16 Alpine | Port host `5433` |
| GUI DB (opsional) | pgAdmin 4 | Port host `8080` |

---

## 4. Struktur folder

```text
tigabenang/
├── docker-compose.yml          
├── Dockerfile                  
├── .env                        
├── docker/
│   ├── nginx/default.conf      
│   └── php/                   
└── src/                        
    ├── app/
    │   ├── Http/Controllers/   
    │   ├── Livewire/Admin/     
    │   ├── Models/             
    │   └── Support/            
    ├── bootstrap/
    ├── config/                 
    ├── database/               
    ├── public/                 
    ├── resources/
    │   ├── css/app.css
    │   ├── js/
    │   │   ├── app.js
    │   │   ├── customer/       
    │   │   └── three/         
    │   └── views/
    ├── routes/web.php
    ├── tests/
    ├── artisan
    ├── composer.json
    ├── package.json
    └── vite.config.js
```

Peran singkat:

- **Root** — Docker dan environment yang dipakai saat `docker compose`.
- **`src/app`** — logika aplikasi. Jangan menjalankan `npm` di container `app`.
- **`src/resources/js/three`** — scene Virtual Fitting dan loader GLB.
- **`src/public`** — aset yang dilayani Nginx.
- **`src/config/fitvendor.php`** — konfigurasi WhatsApp dan kontak. Namanya identifier teknis, bukan nama brand di UI.

---

## 5. Halaman dan route

Health check Laravel: `GET /up`.

### Customer

| Method | Path | Nama route |
|---|---|---|
| GET | `/` | `home` |
| GET | `/collection` | `collection.index` |
| GET | `/collection/{produk}` | `collection.show` |
| GET | `/materials` | `materials.index` |
| GET | `/virtual-fitting` | `virtual-fitting` |
| GET | `/about` | `about` |
| GET | `/order/create` | `order.create` |
| POST | `/order` | `order.store` |
| POST | `/order/upload-design` | `order.upload-design` |
| GET | `/order/success` | `order.success` |
| GET | `/order/{id}/pdf` | `order.pdf` |
| GET | `/form-pemesanan` | `deal-order.create` |
| POST | `/form-pemesanan` | `deal-order.store` |
| GET | `/form-pemesanan/sukses` | `deal-order.success` |

### Autentikasi

| Method | Path | Nama route |
|---|---|---|
| GET, POST | `/login` | `login` |
| GET, POST | `/register` | `register` |
| GET, POST | `/logout` | `logout` |

### Admin (`auth`)

| Path | Keterangan |
|---|---|
| `/admin/dashboard` | Dashboard |
| `/admin/analytics` | Analytics |
| `/admin/settings` | Pengaturan profil |
| `/admin/kategori` | Kategori dan bahan |
| `/admin/produk` | Produk |
| `/admin/ukuran` | Size chart |
| `/admin/model-3d` | Model 3D |
| `/admin/model-3d/{id}/preview` | Pratinjau 3D |
| `/admin/pesanan` | Pesanan |
| `/admin/pesanan/{id}/invoice` | Faktur |
| `/admin/pelanggan` | Pelanggan |

---

## 6. Virtual Fitting

Cara kerja yang ada di kode:

1. Controller hanya mengambil produk yang `file_model_3d`-nya terisi.
2. Katalog (nama, gambar, URL model, size) dikirim ke halaman sebagai JSON.
3. `virtual-fitting.js` membangun product picker (filter kategori dan pencarian).
4. Slider tubuh mengatur tinggi, dada, pinggang, pinggul, bahu, panjang lengan, dan panjang torso.
5. `fit-analysis.js` memberi rekomendasi size.
6. Three.js merender avatar (`avatar.js`) dan memuat garment GLB lewat `GLTFLoader` (`garment.js`).
7. URL model diselesaikan oleh `CustomerMedia::modelUrl()`: file di `public/`, storage, atau URL disk Supabase untuk path `models3d/`.
8. Jika katalog kosong, kode memakai fallback `/models/t-shirt.glb`.
9. Profil tubuh disimpan di `localStorage` (key teknis `clothiq-body-profile`).

Di halaman detail produk, pratinjau 3D memakai `@google/model-viewer`, terpisah dari studio Three.js.

---

## 7. Docker

Jalankan semua perintah Compose dari **root repository** (folder yang berisi `docker-compose.yml`).

| Service | Container | Port host | Peran |
|---|---|---|---|
| `app` | `tigabenang_app` | — | PHP-FPM, Composer, Artisan |
| `nginx` | `tigabenang_nginx` | **8000** → 80 | HTTP, root `/var/www/public` |
| `postgres` | `tigabenang_postgres` | **5433** → 5432 | PostgreSQL lokal (opsional) |
| `pgadmin` | `tigabenang_pgadmin` | **8080** → 80 | UI database |
| `node` | `tigabenang_node` | **5173** → 5173 | npm / Vite |

Service `node` memakai profile `vite`:

```yaml
profiles:
  - vite
```

Akibatnya, `docker compose up -d` **tidak** menyalakan container `node`. Frontend tidak boleh diinstal di container `app`.

Volume yang dipakai:

- `./src` → `/var/www`
- `./.env` → `/var/www/.env`
- `vendor_data` → `/var/www/vendor`
- `node_modules_data` → `/var/www/node_modules`

Aplikasi memakai `DB_*` di `.env`. `src/.env.example` mencontohkan PostgreSQL remote. Service Postgres Docker tersedia jika ingin database lokal di port `5433`.

Batas unggah PHP dan Nginx: **20MB**.

---

## 8. Cara instalasi

Prasyarat: Docker Desktop, atau Docker Engine + Compose.

### Langkah 1 — Environment

Compose membaca `.env` di **root**, bukan di `src/`.

Windows:

```bash
copy src\.env.example .env
```

Linux / macOS:

```bash
cp src/.env.example .env
```

Isi yang perlu dicek:

- `APP_KEY` (dibuat setelah container `app` hidup)
- `APP_URL` (lokal: `http://localhost:8000`)
- `DB_CONNECTION=pgsql` beserta host, port, database, username, password, dan `DB_SSLMODE` jika remote
- `WHATSAPP_NUMBER`, `WHATSAPP_MESSAGE`
- `FITVENDOR_EMAIL` — **nama key teknis**; nilai yang tampil ke pengguna default-nya `hello@tigabenang.id`
- `FITVENDOR_LOCATION`
- kredensial Supabase Storage jika disk `supabase` dipakai

### Langkah 2 — Nyalakan backend

```bash
docker compose up -d
docker compose ps
```

Yang aktif: `app`, `nginx`, `postgres`, `pgadmin`.

### Langkah 3 — Dependency PHP

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan config:clear
```

Pastikan folder ini dapat ditulis:

- `src/storage/framework/views`
- `src/storage/framework/cache`
- `src/storage/framework/sessions`
- `src/bootstrap/cache`

### Langkah 4 — Dependency frontend

Hanya di container `node`:

```bash
docker compose --profile vite run --rm node npm install
docker compose --profile vite run --rm node npm run build
```

Hasil build ada di `src/public/build`. Setelah build, `http://localhost:8000` dapat berjalan tanpa Vite.

### Langkah 5 — Database

Hanya jalankan jika database tujuan masih kosong dan Anda memang ingin menerapkan schema/seeder:

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

Seeder mengisi akun admin, 5 kategori, 6 bahan, size chart, 8 produk contoh, relasi bahan, dan beberapa pesanan contoh.

Akun seeder:

| Field | Nilai |
|---|---|
| Username | `admin` |
| Password | `password123` |

---

## 9. Cara penggunaan

### Menjalankan aplikasi

```bash
docker compose up -d
```

| Halaman | URL |
|---|---|
| Storefront | http://localhost:8000 |
| Health check | http://localhost:8000/up |
| Login admin | http://localhost:8000/login |
| pgAdmin | http://localhost:8080 |

### Vite (hot reload)

Setelah `npm install`:

```bash
docker compose --profile vite up -d
docker compose ps
```

Jika container `node` sudah berjalan:

```bash
docker compose exec node npm install
docker compose exec node npm run build
docker compose exec node npm run dev -- --host 0.0.0.0
```

`src/vite.config.js` memakai host `0.0.0.0`, port `5173`, dan CORS untuk `http://localhost:8000`. Service `node` meng-set `VITE_USE_POLLING=1`.

### Alur pelanggan

1. Buka koleksi atau Virtual Fitting.
2. Buka detail produk.
3. Lanjut ke `/order/create`.
4. Isi data pemesan, bahan, jumlah per ukuran, desain, dan catatan.
5. Kirim formulir tanpa mengisi harga final.
6. Lanjut ke WhatsApp atau unduh PDF konsultasi.

### Alur admin

1. Masuk di `/login`.
2. Buka `/admin/pesanan`.
3. Hubungi pelanggan lewat tautan WhatsApp.
4. Isi harga yang disepakati.
5. Buka faktur di `/admin/pesanan/{id}/invoice`.

---

## 10. Pengujian

```bash
docker compose exec app php artisan config:clear
docker compose exec app php artisan test
```

File tes:

- `src/tests/Feature/CustomerFrontendTest.php`
- `src/tests/Feature/AdminOrderCreateFormTest.php`
- `src/tests/Feature/AdminProductUploadTest.php`
- `src/tests/Feature/ExampleTest.php`
- `src/tests/Unit/ExampleTest.php`

PHPUnit memakai SQLite in-memory (`src/phpunit.xml`). Tes tidak menulis ke database development.

---

## 11. Konfigurasi development

| Item | Nilai saat ini |
|---|---|
| Brand di UI | Tigabenang |
| Email komersial default | `hello@tigabenang.id` |
| URL aplikasi lokal | http://localhost:8000 |
| Vite | http://localhost:5173 |
| Env container | `.env` di root repository |
| Contoh env | `src/.env.example` |
| Config kontak | `src/config/fitvendor.php` |
| Disk contoh | `FILESYSTEM_DISK=local` |
| Session / cache / queue contoh | `database` |
| Tampilan mobile | media query di `app.css` dan layout customer, termasuk menu mobile |

Identifier teknis yang **bukan** nama brand UI, dan tidak perlu diubah hanya karena rebrand:

- key env `FITVENDOR_EMAIL`, `FITVENDOR_LOCATION`
- file `src/config/fitvendor.php` dan pemanggilan `config('fitvendor.*')`
- nama container Docker (`tigabenang_app`, dan seterusnya)
- bucket / URL storage jika masih memakai identifier lama
- `window.FitVendorOrder` di JavaScript pesanan
