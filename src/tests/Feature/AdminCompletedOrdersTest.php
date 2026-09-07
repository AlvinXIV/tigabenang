<?php

namespace Tests\Feature;

use App\Livewire\Admin\Orders\Completed;
use App\Livewire\Admin\Orders\Detail;
use App\Livewire\Admin\Orders\Index;
use App\Models\Kategori;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminCompletedOrdersTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Produk $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'nama' => 'Admin Tigabenang',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $cat = Kategori::create(['nama_kategori' => 'Kemeja']);
        $this->product = Produk::create([
            'kategori_id' => $cat->id_kategori,
            'nama_produk' => 'Kemeja Formal Oxford',
            'harga' => 180000,
        ]);
    }

    public function test_incoming_orders_page_only_shows_masuk_orders(): void
    {
        $orderMasuk = Pemesanan::create([
            'nama' => 'Budi Santoso',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10',
            'produk_id' => $this->product->id_produk,
            'status' => 'masuk',
            'total_harga' => 250000,
        ]);

        $orderSelesai = Pemesanan::create([
            'nama' => 'Siti Nurhaliza',
            'no_hp' => '089876543210',
            'alamat' => 'Jl. Sudirman No. 5',
            'produk_id' => $this->product->id_produk,
            'status' => 'selesai',
            'total_harga' => 450000,
        ]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('Budi Santoso')
            ->assertDontSee('Siti Nurhaliza');
    }

    public function test_completed_orders_page_only_shows_selesai_orders(): void
    {
        $orderMasuk = Pemesanan::create([
            'nama' => 'Budi Santoso',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10',
            'produk_id' => $this->product->id_produk,
            'status' => 'masuk',
        ]);

        $orderSelesai = Pemesanan::create([
            'nama' => 'Siti Nurhaliza',
            'no_hp' => '089876543210',
            'alamat' => 'Jl. Sudirman No. 5',
            'produk_id' => $this->product->id_produk,
            'status' => 'selesai',
            'total_harga' => 450000,
        ]);

        Livewire::actingAs($this->admin)
            ->test(Completed::class)
            ->assertSee('Siti Nurhaliza')
            ->assertDontSee('Budi Santoso');
    }

    public function test_marking_order_completed_from_index_moves_it_to_completed(): void
    {
        $order = Pemesanan::create([
            'nama' => 'Rian Ardiansyah',
            'no_hp' => '081122334455',
            'alamat' => 'Jl. Gatot Subroto No. 8',
            'produk_id' => $this->product->id_produk,
            'status' => 'masuk',
            'total_harga' => 300000,
        ]);

        $this->assertEquals('masuk', $order->status);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('markAsCompleted', $order->id_pemesanan);

        $order->refresh();
        $this->assertEquals('selesai', $order->status);
        $this->assertTrue($order->isSelesai());
    }

    public function test_marking_order_active_from_completed_reverts_to_masuk(): void
    {
        $order = Pemesanan::create([
            'nama' => 'Dewi Lestari',
            'no_hp' => '082233445566',
            'alamat' => 'Jl. Pahlawan No. 12',
            'produk_id' => $this->product->id_produk,
            'status' => 'selesai',
            'total_harga' => 500000,
        ]);

        $this->assertEquals('selesai', $order->status);

        Livewire::actingAs($this->admin)
            ->test(Completed::class)
            ->call('markAsActive', $order->id_pemesanan);

        $order->refresh();
        $this->assertEquals('masuk', $order->status);
        $this->assertFalse($order->isSelesai());
    }

    public function test_order_detail_can_toggle_completed_and_active(): void
    {
        $order = Pemesanan::create([
            'nama' => 'Hendra Gunawan',
            'no_hp' => '085566778899',
            'alamat' => 'Jl. Diponegoro No. 3',
            'produk_id' => $this->product->id_produk,
            'status' => 'masuk',
            'total_harga' => 600000,
        ]);

        Livewire::actingAs($this->admin)
            ->test(Detail::class, ['orderId' => $order->id_pemesanan])
            ->assertSee('Tandai Selesai')
            ->call('markAsCompleted');

        $order->refresh();
        $this->assertEquals('selesai', $order->status);

        Livewire::actingAs($this->admin)
            ->test(Detail::class, ['orderId' => $order->id_pemesanan])
            ->assertSee('Pesanan Selesai')
            ->assertSee('Kembalikan ke Masuk')
            ->call('revertToActive');

        $order->refresh();
        $this->assertEquals('masuk', $order->status);
    }

    public function test_admin_completed_orders_route_renders_successfully(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pesanan.completed'));

        $response->assertOk()
            ->assertSee('Pesanan Selesai')
            ->assertSee('Lihat Pesanan Masuk');
    }
}
