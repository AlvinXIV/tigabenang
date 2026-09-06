# Tigabenang

Vendor management portal dan storefront pakaian custom. Brand yang tampil di aplikasi: **Tigabenang**.

Aplikasi ini membantu pelanggan memilih produk, bahan, dan ukuran, mencoba Virtual Fitting 3D, lalu mengirim permintaan pesanan. Admin meninjau pesanan, berkomunikasi lewat WhatsApp, dan memasukkan harga final yang disepakati.

Laravel app berada di folder `src/`. Docker Compose, Dockerfile, dan file `.env` yang dipakai container ada di root repository ini.

---

## Penjelasan aplikasi

Tigabenang dibuat untuk alur konveksi yang sederhana dan realistis:

1. Pelanggan mengisi formulir pesanan (tanpa menentukan harga final).
2. Pesanan muncul di portal admin.
3. Admin menghubungi pelanggan melalui tautan WhatsApp.
4. Harga dinegosiasikan di luar aplikasi.
5. Admin memasukkan harga yang disepakati.
6. Admin dapat mencetak faktur setelah harga diisi.

Tidak ada payment gateway, tidak ada integrasi supplier, dan tidak ada negosiasi harga otomatis. Stok bahan di database saat ini hanya menyimpan nama bahan; tidak ada pengurangan stok otomatis.

---

## Fitur utama

### Storefront pelanggan

- **Beranda** — pengantar brand, showcase kategori, portofolio produk, teaser Virtual Fitting, FAQ, dan testimoni.
- **Koleksi** — daftar produk dengan filter kategori, lalu halaman detail produk (gambar, harga mulai, bahan, ukuran, pratinjau model 3D bila ada).
- **Virtual Fitting** — studio 3D (Three.js): pilih produk yang punya model, atur ukuran tubuh, lihat rekomendasi size, dan pratinjau garment.
- **Tentang** — profil brand dan kontak (WhatsApp + email `hello@tigabenang.id`).
- **Request pesanan** (`/order/create`) — nama, alamat, telepon, produk, bahan, kuantitas per ukuran, unggah desain opsional, dan catatan. Total yang tampil adalah estimasi (`harga produk × kuantitas`), bukan harga final.
- **Halaman sukses + PDF** — ringkasan pesanan, tautan WhatsApp berisi detail konsultasi, dan lembar PDF.
- **Form pemesanan deal** (`/form-pemesanan`) — formulir mandiri dengan data inti yang sama; `total_harga` juga disimpan `null`.
- **Katalog bahan** (`/materials`) — tampilan bahan bersifat baca saja. Halaman ini tidak ada di navbar utama.

Navbar customer: Beranda, Koleksi, Virtual fitting, Tentang.

### Portal admin (butuh login)

- Dashboard operasional (pesanan, menunggu harga, pesanan terbaru).
- Analytics (omzet, jumlah pesanan, grafik, produk/bahan teratas) memakai Chart.js.
- Produk, kategori, dan bahan (nama bahan dikelola bersama modul kategori).
- Size chart (ukuran per kategori: lebar dada, panjang, lebar bahu, panjang lengan).
- Unggah / pratinjau model 3D (`.glb` / `.gltf`).
- Pesanan: daftar, buat manual, detail, tetapkan harga, faktur.
- Pelanggan: dikelompokkan dari data pesanan (bukan CRM terpisah).
- Pengaturan profil admin (nama, email di UI, password).

Form **Register** (`/register`) menampilkan field pendaftaran, tetapi controller saat ini hanya mengarahkan kembali ke login tanpa menyimpan akun baru.

---

## Teknologi yang digunakan

| Lapisan | Teknologi | Sumber |
|---|---|---|
| Backend | PHP 8.3 (image Docker), requirement `^8.2` | `Dockerfile`, `src/composer.json` |
| Framework | Laravel `^13.8` | `src/composer.json` |
| Admin UI | Livewire `^3.8` | `src/composer.json` |
| Database | PostgreSQL (`DB_CONNECTION=pgsql`) | `src/.env.example`, `src/config/database.php` |
| Session / cache / queue | driver `database` (contoh env) | `src/.env.example` |
| Storage file | disk `local` / `public` / `supabase` (S3-compatible) | `src/config/filesystems.php` |
| Frontend build | Vite `^8`, Tailwind CSS `^4` | `src/package.json` |
| JS runtime UI | Alpine.js `^3.16` | `src/package.json` |
| 3D | Three.js `^0.183`, `@google/model-viewer` `^4.3` | `src/package.json` |
| Chart admin | Chart.js `^4.5` | `src/package.json` |
| Tes | PHPUnit `^12.5` | `src/composer.json`, `src/phpunit.xml` |
| Web server | Nginx Alpine + PHP-FPM | `docker-compose.yml` |
| Node image | `node:22-alpine` | `docker-compose.yml` |
| Postgres lokal (Docker) | `postgres:16-alpine` | `docker-compose.yml` |
| pgAdmin (Docker) | `dpage/pgadmin4` | `docker-compose.yml` |

Paket PHP lain yang terpasang: `laravel/tinker`, `league/flysystem-aws-s3-v3`.

---

## Struktur folder

```text
tigabenang/
├── docker-compose.yml
├── Dockerfile
├── .env                      # dipakai container (di-mount ke /var/www/.env)
├── docker/
│   ├── nginx/default.conf
│   └── php/                  # zz-www-dev.conf, uploads.ini
└── src/                      # Laravel app → /var/www
    ├── app/
    │   ├── Http/Controllers/ # customer + admin + auth
    │   ├── Livewire/Admin/   # dashboard, produk, pesanan, dll.
    │   ├── Models/
    │   └── Support/          # CustomerCatalog, CustomerMedia, ...
    ├── bootstrap/
    ├── config/
    ├── database/             # migrations, seeders
    ├── public/               # index.php, images, build, models
    ├── resources/
    │   ├── css/app.css
    │   ├── js/
    │   │   ├── app.js
    │   │   ├── customer/     # order.js, virtual-fitting.js, fit-analysis.js
    │   │   └── three/        # scene.js, avatar.js, garment.js
    │   └── views/
    ├── routes/web.php
    ├── tests/
    ├── artisan
    ├── composer.json
    ├── package.json
    └── vite.config.js
```

---

## Halaman dan route

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

Login memakai field `email` di form, lalu mencoba kolom `username` (dan fallback `nama`) pada tabel `users`.

### Admin (`auth` middleware)

`GET /admin` mengarah ke `/admin/dashboard`.

| Path | Keterangan |
|---|---|
| `/admin/dashboard` | Dashboard |
| `/admin/analytics` | Analytics |
| `/admin/settings` | Pengaturan profil |
| `/admin/kategori` | Kategori & bahan |
| `/admin/produk` | Produk |
| `/admin/ukuran` | Size chart |
| `/admin/model-3d` | Model 3D |
| `/admin/model-3d/{id}/preview` | Pratinjau 3D |
| `/admin/pesanan` | Pesanan |
| `/admin/pesanan/{id}/invoice` | Faktur |
| `/admin/pelanggan` | Pelanggan |

---

## Virtual Fitting

Halaman: `/virtual-fitting` (bisa `?product={id}`).

Yang diimplementasikan sekarang:

- Hanya produk dengan `file_model_3d` yang masuk katalog fitting.
- Product picker (filter kategori + pencarian).
- Slider tubuh: tinggi, dada, pinggang, pinggul, bahu, panjang lengan, panjang torso.
- Rekomendasi size dari `resources/js/customer/fit-analysis.js`.
- Scene Three.js: `scene.js`, `avatar.js`, `garment.js`.
- Model garment dimuat dari URL `CustomerMedia::modelUrl()` (file publik, storage, atau URL Supabase untuk path `models3d/`).
- Fallback prototipe di kode: `/models/t-shirt.glb`.
- Profil tubuh disimpan di `localStorage`.
- Product detail memakai `@google/model-viewer` jika ada model 3D.

Entry Vite terkait: `resources/js/customer/virtual-fitting.js` (lihat `src/vite.config.js`).

---

## Docker dan port

Service di `docker-compose.yml`:

| Service | Container | Port host | Catatan |
|---|---|---|---|
| `app` | `tigabenang_app` | — | PHP 8.3-FPM, `WORKDIR /var/www` |
| `nginx` | `tigabenang_nginx` | **8000** → 80 | root ` /var/www/public` |
| `postgres` | `tigabenang_postgres` | **5433** → 5432 | DB `tigabenang`, user `postgres` |
| `pgadmin` | `tigabenang_pgadmin` | **8080** → 80 | email `admin@tigabenang.com` |
| `node` | `tigabenang_node` | **5173** → 5173 | image Node 22; **profile `vite`** |

`docker compose up -d` **tidak** menyalakan container `node`. Service itu memakai:

```yaml
profiles:
  - vite
```

Aplikasi Laravel memakai variabel `DB_*` di `.env`. Contoh di `src/.env.example` menunjuk PostgreSQL remote (Supabase). Service Postgres Docker tersedia jika ingin database lokal di port `5433`.

Volume penting:

- `./src` → `/var/www`
- `./.env` → `/var/www/.env`
- `vendor_data` untuk `vendor/`
- `node_modules_data` untuk `node_modules/`

Upload PHP/Nginx dibatasi **20MB** (`docker/php/uploads.ini`, `docker/nginx/default.conf`).

---

## Cara instalasi

Prasyarat: Docker Desktop (atau Docker Engine + Compose).

Jalankan command berikut dari **root repository** (folder yang berisi `docker-compose.yml`).

### 1. Environment

Salin contoh env Laravel, lalu letakkan sebagai `.env` di root (karena Compose me-mount `./.env`):

```bash
copy src\.env.example .env
```

Di Linux/macOS:

```bash
cp src/.env.example .env
```

Isi minimal yang relevan:

- `APP_KEY` — generate setelah container `app` hidup
- `APP_URL=http://localhost:8000` (sesuaikan jika perlu)
- `DB_CONNECTION=pgsql` plus host, port, database, username, password, `DB_SSLMODE` jika remote
- `WHATSAPP_NUMBER`, `WHATSAPP_MESSAGE`
- `FITVENDOR_EMAIL` (default aplikasi: `hello@tigabenang.id`)
- `FITVENDOR_LOCATION`
- kunci Supabase Storage jika memakai disk `supabase`

Jangan menjalankan `npm install` di container `app`. Frontend hanya di container `node`.

### 2. Nyalakan stack backend

```bash
docker compose up -d
docker compose ps
```

Service yang aktif: `app`, `nginx`, `postgres`, `pgadmin`.

### 3. Dependency PHP

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan config:clear
```

Pastikan folder berikut dapat ditulis:

- `src/storage/framework/views`
- `src/storage/framework/cache`
- `src/storage/framework/sessions`
- `src/bootstrap/cache`

### 4. Dependency frontend (container `node`)

Pasang paket dulu lewat one-off container (profile `vite`):

```bash
docker compose --profile vite run --rm node npm install
docker compose --profile vite run --rm node npm run build
```

Asset hasil build ada di `src/public/build`. Setelah `npm run build`, situs di `http://localhost:8000` sudah bisa memakai aset production tanpa Vite.

### 5. Database

Jika database tujuan masih kosong, schema dan data awal tersedia lewat Artisan (hanya jalankan bila Anda memang ingin menerapkan schema/seeder ke database yang dikonfigurasi):

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

Seeder mengisi admin, 5 kategori, 6 bahan, size chart, 8 produk contoh, relasi bahan, dan beberapa pesanan contoh.

Akun seeder:

- username: `admin`
- password: `password123`

---

## Cara penggunaan

### Menjalankan aplikasi

1. Pastikan stack sudah `up`:

   ```bash
   docker compose up -d
   ```

2. Buka storefront: [http://localhost:8000](http://localhost:8000)

3. Health check: [http://localhost:8000/up](http://localhost:8000/up)

4. Login admin: [http://localhost:8000/login](http://localhost:8000/login)

5. pgAdmin (opsional): [http://localhost:8080](http://localhost:8080)

### Vite (hot reload) di development

Nyalakan profile `vite` setelah `npm install`:

```bash
docker compose --profile vite up -d
docker compose ps
```

Atau, jika container `node` sudah berjalan:

```bash
docker compose exec node npm run dev -- --host 0.0.0.0
```

`src/vite.config.js` sudah mengatur `host: 0.0.0.0`, port `5173`, dan CORS untuk `http://localhost:8000`. Variabel `VITE_USE_POLLING=1` di-set pada service `node`.

Perintah frontend lain (hanya di `node`):

```bash
docker compose exec node npm install
docker compose exec node npm run build
```

### Alur yang didemonstrasikan

**Pelanggan**

1. Buka koleksi atau Virtual Fitting.
2. Buka detail produk, lalu Request / `/order/create`.
3. Isi data, pilih bahan dan kuantitas per size, unggah desain jika perlu.
4. Submit. Harga final **tidak** diisi pelanggan.
5. Lanjut ke WhatsApp / unduh PDF konsultasi.

**Admin**

1. Masuk di `/login`.
2. Tinjau pesanan di `/admin/pesanan`.
3. Hubungi pelanggan lewat tautan WhatsApp.
4. Isi harga yang disepakati di detail pesanan.
5. Buka faktur di `/admin/pesanan/{id}/invoice`.

### Tes

```bash
docker compose exec app php artisan config:clear
docker compose exec app php artisan test
```

Suite yang ada:

- `tests/Feature/CustomerFrontendTest.php`
- `tests/Feature/AdminOrderCreateFormTest.php`
- `tests/Feature/AdminProductUploadTest.php`
- `tests/Feature/ExampleTest.php`
- `tests/Unit/ExampleTest.php`

PHPUnit memakai SQLite in-memory (`src/phpunit.xml`). Tidak memakai database development.

---

## Konfigurasi development

| Item | Nilai yang berlaku sekarang |
|---|---|
| Brand UI | Tigabenang |
| Email komersial default | `hello@tigabenang.id` |
| App URL (lokal) | `http://localhost:8000` |
| Vite | `http://localhost:5173` |
| Env container | file `.env` di root repo |
| Contoh env | `src/.env.example` |
| Disk default contoh | `FILESYSTEM_DISK=local` |
| Session / cache / queue contoh | `database` |
| Config kontak | `src/config/fitvendor.php` |
| Responsive | media query di `app.css` dan Blade customer (termasuk menu mobile) |

Jangan mengubah identifier teknis seperti nama container (`tigabenang_app`), key env `FITVENDOR_EMAIL`, atau bucket Storage, kecuali Anda memang mengubah infrastruktur.

---

## Lisensi

Kode aplikasi berbasis skeleton Laravel yang berlisensi [MIT](https://opensource.org/licenses/MIT).
