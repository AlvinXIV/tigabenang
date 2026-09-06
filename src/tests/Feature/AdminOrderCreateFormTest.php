<?php

namespace Tests\Feature;

use App\Livewire\Admin\Orders\OrderCreateForm;
use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Models\Ukuran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminOrderCreateFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup Category 1: Jersey (5 sizes)
        $this->catJersey = Kategori::create(['nama_kategori' => 'Jersey']);
        $this->sizesJersey = [
            Ukuran::create(['kategori_id' => $this->catJersey->id_kategori, 'nama_ukuran' => 'S', 'lebar_dada' => 50]),
            Ukuran::create(['kategori_id' => $this->catJersey->id_kategori, 'nama_ukuran' => 'M', 'lebar_dada' => 53]),
            Ukuran::create(['kategori_id' => $this->catJersey->id_kategori, 'nama_ukuran' => 'L', 'lebar_dada' => 56]),
            Ukuran::create(['kategori_id' => $this->catJersey->id_kategori, 'nama_ukuran' => 'XL', 'lebar_dada' => 59]),
            Ukuran::create(['kategori_id' => $this->catJersey->id_kategori, 'nama_ukuran' => '2XL', 'lebar_dada' => 62]),
        ];
        $this->prodJersey = Produk::create([
            'kategori_id' => $this->catJersey->id_kategori,
            'nama_produk' => 'Aero Match Jersey',
            'harga' => 225000,
        ]);

        // Setup Category 2: Kaos (3 sizes: S, M, L)
        $this->catKaos = Kategori::create(['nama_kategori' => 'Kaos']);
        $this->sizesKaos = [
            Ukuran::create(['kategori_id' => $this->catKaos->id_kategori, 'nama_ukuran' => 'S', 'lebar_dada' => 48]),
            Ukuran::create(['kategori_id' => $this->catKaos->id_kategori, 'nama_ukuran' => 'M', 'lebar_dada' => 51]),
            Ukuran::create(['kategori_id' => $this->catKaos->id_kategori, 'nama_ukuran' => 'L', 'lebar_dada' => 54]),
        ];
        $this->prodKaos = Produk::create([
            'kategori_id' => $this->catKaos->id_kategori,
            'nama_produk' => 'Noir Crest Tee',
            'harga' => 150000,
        ]);

        // Setup Materials
        $this->matDryFit = Bahan::create(['nama_bahan' => 'Dry Fit']);
        $this->matCotton = Bahan::create(['nama_bahan' => 'Cotton Combed']);
        $this->matDrill = Bahan::create(['nama_bahan' => 'Drill']);
    }

    /**
     * CASE A & CASE C: Select product with category having S, M, L, XL, 2XL.
     * Expected: Each appears exactly once, no duplicates.
     */
    public function test_case_a_and_c_product_loads_category_sizes_without_duplicates(): void
    {
        Livewire::test(OrderCreateForm::class)
            ->assertSee('Silakan pilih produk terlebih dahulu')
            ->set('produk_id', $this->prodJersey->id_produk)
            ->assertViewHas('sizes', function ($sizes) {
                // Should have exactly 5 sizes
                if ($sizes->count() !== 5) {
                    return false;
                }
                // All 5 sizes belong to Jersey
                foreach ($sizes as $s) {
                    if ($s->kategori_id !== $this->catJersey->id_kategori) {
                        return false;
                    }
                }
                // Names should be S, M, L, XL, 2XL without duplication
                $names = $sizes->pluck('nama_ukuran')->all();
                return $names === ['S', 'M', 'L', 'XL', '2XL'];
            })
            ->assertSee('Menampilkan ukuran standar pola kategori')
            ->assertSee('Jersey');
    }

    /**
     * CASE B: Switch product to category with different sizes.
     * Expected: Size list updates, resetting obsolete size quantities.
     */
    public function test_case_b_switch_product_updates_sizes_and_resets_quantities(): void
    {
        $component = Livewire::test(OrderCreateForm::class)
            ->set('produk_id', $this->prodJersey->id_produk);

        $jerseySId = $this->sizesJersey[0]->id_ukuran;
        $component->set("ukuran.{$jerseySId}", 10);

        // Switch to Kaos (only S, M, L)
        $component->set('produk_id', $this->prodKaos->id_produk)
            ->assertViewHas('sizes', function ($sizes) {
                $names = $sizes->pluck('nama_ukuran')->all();
                return $names === ['S', 'M', 'L'];
            });

        // The old Jersey size id should no longer be present or active in ukuran array
        $ukuranState = $component->get('ukuran');
        $this->assertArrayNotHasKey($jerseySId, $ukuranState);

        // New sizes for Kaos should be initialized to 0
        $kaosSId = $this->sizesKaos[0]->id_ukuran;
        $this->assertArrayHasKey($kaosSId, $ukuranState);
        $this->assertSame(0, $ukuranState[$kaosSId]);
    }

    /**
     * CASE D: Select multiple materials via checkboxes.
     * Expected: Multiple materials can be selected simultaneously.
     */
    public function test_case_d_multiple_materials_selection(): void
    {
        Livewire::test(OrderCreateForm::class)
            ->set('bahan_ids', [
                $this->matDryFit->id_bahan,
                $this->matCotton->id_bahan,
            ])
            ->assertSet('bahan_ids', [
                $this->matDryFit->id_bahan,
                $this->matCotton->id_bahan,
            ]);
    }

    /**
     * CASE E: Submit manual order.
     * Expected: Quantity for each size and selected materials are correctly saved in database.
     */
    public function test_case_e_submit_manual_order_saves_correctly(): void
    {
        $jerseySId = $this->sizesJersey[0]->id_ukuran;
        $jerseyMId = $this->sizesJersey[1]->id_ukuran;
        $jerseyXLId = $this->sizesJersey[3]->id_ukuran;

        Livewire::test(OrderCreateForm::class)
            ->set('nama', 'Budi Pratama')
            ->set('no_hp', '08123456789')
            ->set('alamat', 'Jl. Merdeka No. 45, Bandung')
            ->set('produk_id', $this->prodJersey->id_produk)
            ->set('bahan_ids', [$this->matDryFit->id_bahan, $this->matDrill->id_bahan])
            ->set("ukuran.{$jerseySId}", 12)
            ->set("ukuran.{$jerseyMId}", 24)
            ->set("ukuran.{$jerseyXLId}", 6)
            ->set('total_harga', '15000000')
            ->set('notes', 'Bordir dada kiri')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.pesanan.index'));

        // Assert pemesanan in database
        $this->assertDatabaseHas('pemesanan', [
            'nama' => 'Budi Pratama',
            'no_hp' => '08123456789',
            'produk_id' => $this->prodJersey->id_produk,
            'total_harga' => 15000000,
            'notes' => 'Bordir dada kiri',
        ]);

        $order = Pemesanan::with(['bahan', 'ukuran'])->first();
        $this->assertNotNull($order);

        // Check materials
        $savedMaterialIds = $order->bahan->pluck('id_bahan')->all();
        sort($savedMaterialIds);
        $expectedMaterialIds = [$this->matDryFit->id_bahan, $this->matDrill->id_bahan];
        sort($expectedMaterialIds);
        $this->assertSame($expectedMaterialIds, $savedMaterialIds);

        // Check sizes and quantities
        $savedSizes = $order->ukuran->keyBy('id_ukuran');
        $this->assertCount(3, $savedSizes);
        $this->assertEquals(12, $savedSizes[$jerseySId]->pivot->kuantitas);
        $this->assertEquals(24, $savedSizes[$jerseyMId]->pivot->kuantitas);
        $this->assertEquals(6, $savedSizes[$jerseyXLId]->pivot->kuantitas);
    }

    public function test_admin_order_create_page_renders_successfully(): void
    {
        $this->get(route('admin.pesanan.create'))
            ->assertOk()
            ->assertSee('Tambah Pesanan Manual')
            ->assertSee('Silakan pilih produk terlebih dahulu');
    }
}
