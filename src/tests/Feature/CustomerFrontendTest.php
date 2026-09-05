<?php

namespace Tests\Feature;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Models\Ukuran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomerFrontendTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_pages_render(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Bagus Pratama')
            ->assertSee('Nadia Putri')
            ->assertSee('Yoga Prasetyo')
            ->assertSee('images/profile1.jpg', false)
            ->assertSee('images/profile8.jpg', false)
            ->assertSee('images/virtual.jpg', false)
            ->assertDontSee('virtual-fitting-teaser.jpg');
        $this->get('/collection')->assertOk();
        $this->get('/materials')->assertOk();
        $this->get('/virtual-fitting')
            ->assertOk()
            ->assertSee('T-shirt preview')
            ->assertSee('Pilihan pakaian');
        $this->get('/about')
            ->assertOk()
            ->assertSee('Visi')
            ->assertSee('Misi')
            ->assertSee('Hubungi Kami')
            ->assertSee('Antara meja potong dan layar fitting')
            ->assertSee('images/tentang1.jpg', false)
            ->assertSee('images/tentang2.jpg', false)
            ->assertSee('images/tentang3.jpg', false)
            ->assertSee('images/tentang4.jpg', false)
            ->assertSee(config('fitvendor.contact.email'));

        $this->get('/order/create')->assertOk();
    }

    public function test_collection_show_and_order_validation(): void
    {
        $kategori = Kategori::query()->create(['nama_kategori' => 'Kaos']);
        $ukuran = Ukuran::query()->create([
            'kategori_id' => $kategori->id_kategori,
            'nama_ukuran' => 'M',
            'lebar_dada' => 51,
            'panjang' => 69,
            'lebar_bahu' => 44,
            'panjang_lengan' => 21,
        ]);
        $bahan = Bahan::query()->create(['nama_bahan' => 'Cotton Combed']);
        Bahan::query()->create(['nama_bahan' => 'Baby Terry']);
        $produk = Produk::query()->create([
            'kategori_id' => $kategori->id_kategori,
            'nama_produk' => 'Kaos Studio',
            'harga' => 150000,
        ]);
        $produk->bahan()->attach($bahan->id_bahan);

        $this->get('/order/create?product='.$produk->id_produk)
            ->assertOk()
            ->assertSee('Kategori pakaian')
            ->assertSee('Pilih kategori pakaian yang ingin Anda pesan.')
            ->assertSee('Kaos')
            ->assertDontSee('Model pakaian')
            ->assertDontSee('Harga mengikuti model yang dipilih.')
            ->assertDontSee('Kaos Studio · Rp')
            ->assertSee('Cotton Combed')
            ->assertSee('name="produk_id"', false)
            ->assertSee('name="materials[]"', false)
            ->assertSee('>M</label>', false)
            ->assertSee('name="sizes[0][ukuran_id]"', false)
            ->assertSee('name="sizes[0][kuantitas]"', false);

        // A category holding one product resolves it without asking the customer.
        $this->get('/order/create')
            ->assertOk()
            ->assertSee('value="'.$produk->id_produk.'"', false);

        $this->get('/collection/'.$produk->id_produk)
            ->assertOk()
            ->assertSee('Kaos Studio')
            ->assertSee('Pesan produk ini')
            ->assertSee('Bahan tersedia')
            ->assertSee('Bahan yang terhubung dengan produk ini.')
            ->assertSee('Cotton Combed')
            ->assertSee('Baby Terry')
            ->assertSee('images/materials/cotton_combed.jpg', false)
            ->assertSee('images/materials/baby_terry.jpg', false)
            ->assertDontSee('Ukuran tersedia')
            ->assertDontSee('Mengikuti size chart kategori produk.');

        $this->get('/collection/99999')->assertNotFound();

        $this->post('/order', [])->assertSessionHasErrors(['nama', 'alamat', 'no_hp', 'produk_id']);

        $this->post('/order', [
            'nama' => 'Sari Atelier',
            'alamat' => 'Bandung',
            'no_hp' => '08123456789',
            'produk_id' => $produk->id_produk,
            'materials' => [$bahan->id_bahan],
            'sizes' => [
                ['ukuran_id' => $ukuran->id_ukuran, 'kuantitas' => 3],
            ],
            'notes' => 'Navy body, cream sleeves',
        ])->assertRedirect(route('order.success'));

        $this->assertDatabaseHas('pemesanan', [
            'nama' => 'Sari Atelier',
            'produk_id' => $produk->id_produk,
            'total_harga' => null,
        ]);

        $whatsappNumber = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));

        $this->get(route('order.success'))
            ->assertOk()
            ->assertSee('Kaos Studio')
            ->assertSee('Cotton Combed')
            ->assertSee('Estimasi total')
            ->assertSee('Rp 450.000')
            ->assertSee('Lanjut via WhatsApp')
            ->assertSee('https://wa.me/'.$whatsappNumber, false)
            ->assertSee('Nomor permintaan #')
            ->assertSee('Harga final dikonfirmasi bersama vendor.')
            ->assertDontSee('Payment successful')
            ->assertDontSee('Payment confirmed');

        Storage::fake('public');

        $this->post('/order', [
            'nama' => 'Sari Atelier',
            'alamat' => 'Bandung',
            'no_hp' => '08123456789',
            'produk_id' => $produk->id_produk,
            'materials' => [$bahan->id_bahan],
            'sizes' => [
                ['ukuran_id' => $ukuran->id_ukuran, 'kuantitas' => 1],
            ],
            'upload_design' => UploadedFile::fake()->create('design.jpg', 80, 'image/jpeg'),
        ])->assertRedirect(route('order.success'));

        $this->assertTrue(
            collect(Storage::disk('public')->allFiles('designs'))->isNotEmpty()
        );

        $this->from(route('order.create'))
            ->post('/order', [
                'nama' => 'Sari Atelier',
                'alamat' => 'Bandung',
                'no_hp' => '08123456789',
                'produk_id' => $produk->id_produk,
                'materials' => [$bahan->id_bahan],
                'sizes' => [
                    ['ukuran_id' => $ukuran->id_ukuran, 'kuantitas' => 1],
                ],
                'upload_design' => UploadedFile::fake()->create('notes.txt', 20, 'text/plain'),
            ])
            ->assertRedirect(route('order.create'))
            ->assertSessionHasErrors('upload_design');
    }

    public function test_home_previews_products_while_collection_lists_all(): void
    {
        $kategori = Kategori::query()->create(['nama_kategori' => 'Kaos']);

        foreach (range(1, 7) as $index) {
            Produk::query()->create([
                'kategori_id' => $kategori->id_kategori,
                'nama_produk' => 'Atelier Piece '.$index,
                'harga' => 100000 + ($index * 1000),
            ]);
        }

        $home = $this->get('/');
        $home->assertOk()
            ->assertSee('Karya kami')
            ->assertSee('Lihat koleksi')
            ->assertSee('Atelier Piece 7')
            ->assertDontSee('Atelier Piece 1')
            ->assertDontSee('Bahan produksi')
            ->assertDontSee('Lihat semua bahan');

        $collection = $this->get('/collection');
        $collection->assertOk()
            ->assertSee('Koleksi')
            ->assertSee('Atelier Piece 1')
            ->assertSee('Atelier Piece 7')
            ->assertSee('Rp 107.000')
            ->assertSee('Kaos')
            ->assertDontSee('Pesan sesuai kebutuhan');

        $this->get('/collection?category=kaos')
            ->assertOk()
            ->assertSee('Atelier Piece 1');
    }

    public function test_price_estimation_flow_to_agreed_price_and_invoice(): void
    {
        $kategori = Kategori::query()->create(['nama_kategori' => 'Kemeja']);
        $produk = Produk::query()->create([
            'kategori_id' => $kategori->id_kategori,
            'nama_produk' => 'Kemeja Oxford',
            'harga' => 200000,
        ]);
        $bahan = Bahan::query()->create(['nama_bahan' => 'Katun Oxford']);
        $ukuran = Ukuran::query()->create([
            'kategori_id' => $kategori->id_kategori,
            'nama_ukuran' => 'L',
        ]);

        // CASE A: Customer creates new standard order
        $this->post('/order', [
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka No. 10',
            'no_hp' => '081299887766',
            'produk_id' => $produk->id_produk,
            'materials' => [$bahan->id_bahan],
            'sizes' => [
                ['ukuran_id' => $ukuran->id_ukuran, 'kuantitas' => 2],
            ],
            'notes' => 'Tolong kancing putih',
        ])->assertRedirect(route('order.success'));

        // Case A checks: total_harga is NULL in database
        $this->assertDatabaseHas('pemesanan', [
            'nama' => 'Budi Santoso',
            'produk_id' => $produk->id_produk,
            'total_harga' => null,
        ]);

        $order = Pemesanan::query()->where('nama', 'Budi Santoso')->firstOrFail();

        // Customer success page shows dynamic estimate: Rp 400.000, Tigabenang branding
        $this->get(route('order.success'))
            ->assertOk()
            ->assertSee('Estimasi total')
            ->assertSee('Rp 400.000')
            ->assertSee('Harga ini merupakan estimasi awal.')
            ->assertSee('Halo%20Tigabenang');

        // Admin Pesanan Index shows "Menunggu Penetapan" badge
        $this->get(route('admin.pesanan.index'))
            ->assertOk()
            ->assertSee('Menunggu Penetapan');

        // CASE D: Invoice before price agreed:
        // Status: "Menunggu Penetapan Harga", Total: "Belum Ditetapkan", No bank transfer details
        $this->get(route('admin.orders.invoice', $order->id_pemesanan))
            ->assertOk()
            ->assertSee('Menunggu Penetapan Harga')
            ->assertSee('Belum Ditetapkan')
            ->assertDontSee('8420-9988-771');

        // CASE B: Admin sets price (e.g. Rp 450.000)
        $order->update(['total_harga' => 450000]);

        // Admin pesanan detail shows agreed price
        $this->get(route('admin.pesanan.show', $order->id_pemesanan))
            ->assertOk()
            ->assertSee('Harga Disepakati')
            ->assertSee('Rp 450.000');

        // CASE E: Invoice after price agreed:
        $this->get(route('admin.orders.invoice', $order->id_pemesanan))
            ->assertOk()
            ->assertSee('Harga Disepakati')
            ->assertSee('Total Harga Disepakati')
            ->assertSee('Rp 450.000')
            ->assertSee('REKENING PEMBAYARAN:')
            ->assertSee('8420-9988-771');

        // CASE C: Deal order form submission also sets total_harga to NULL
        $this->post('/form-pemesanan', [
            'nama' => 'Dewi Sartika',
            'alamat' => 'Bandung',
            'no_hp' => '081233445566',
            'produk_id' => $produk->id_produk,
            'materials' => [$bahan->id_bahan],
            'sizes' => [
                ['ukuran_id' => $ukuran->id_ukuran, 'kuantitas' => 5],
            ],
        ])->assertRedirect(route('deal-order.success'));

        $this->assertDatabaseHas('pemesanan', [
            'nama' => 'Dewi Sartika',
            'total_harga' => null,
        ]);

        $this->get(route('deal-order.success'))
            ->assertOk()
            ->assertSee('Estimasi Total:')
            ->assertSee('Rp 1.000.000')
            ->assertSee('Tigabenang')
            ->assertSee('#TB-');
    }
}
