<?php

namespace Tests\Feature;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Ukuran;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    }
}
