<?php

namespace Tests\Feature;

use App\Models\Bahan;
use App\Models\Kategori;
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
        $this->get('/')->assertOk();
        $this->get('/collection')->assertOk();
        $this->get('/materials')->assertOk();
        $this->get('/virtual-fitting')->assertOk();
        $this->get('/about')->assertOk();
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
        $produk = Produk::query()->create([
            'kategori_id' => $kategori->id_kategori,
            'nama_produk' => 'Kaos Studio',
            'harga' => 150000,
        ]);
        $produk->bahan()->attach($bahan->id_bahan);

        $this->get('/order/create?product='.$produk->id_produk)
            ->assertOk()
            ->assertSee('Cotton Combed')
            ->assertSee('name="materials[]"', false)
            ->assertSee('>M</label>', false)
            ->assertSee('name="sizes[0][ukuran_id]"', false)
            ->assertSee('name="sizes[0][kuantitas]"', false);

        $this->get('/collection/'.$produk->id_produk)
            ->assertOk()
            ->assertSee('Kaos Studio')
            ->assertSee('Request This Product');

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
            'total_harga' => 450000,
        ]);

        $whatsappNumber = preg_replace('/\D+/', '', (string) config('fitvendor.whatsapp.number'));

        $this->get(route('order.success'))
            ->assertOk()
            ->assertSee('Kaos Studio')
            ->assertSee('Cotton Combed')
            ->assertSee('Estimated total')
            ->assertSee('Rp 450.000')
            ->assertSee('Continue on WhatsApp')
            ->assertSee('https://wa.me/'.$whatsappNumber, false)
            ->assertSee('Order reference #')
            ->assertSee('Final pricing is confirmed with the vendor.')
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
            ->assertSee('Our Work')
            ->assertSee('View Collection')
            ->assertSee('Atelier Piece 7')
            ->assertDontSee('Atelier Piece 1');

        $collection = $this->get('/collection');
        $collection->assertOk()
            ->assertSee('Collection')
            ->assertSee('Atelier Piece 1')
            ->assertSee('Atelier Piece 7')
            ->assertSee('Rp 107.000')
            ->assertSee('Kaos');

        $this->get('/collection?category=kaos')
            ->assertOk()
            ->assertSee('Atelier Piece 1');
    }
}
