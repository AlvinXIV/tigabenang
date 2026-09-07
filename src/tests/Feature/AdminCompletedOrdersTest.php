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
            'status_pembayaran' => 'lunas',
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

    public function test_marking_order_completed_requires_lunas_payment_from_index(): void
    {
        $order = Pemesanan::create([
            'nama' => 'Belum Bayar Wibowo',
            'no_hp' => '081299887766',
            'alamat' => 'Jl. Merdeka No. 45',
            'produk_id' => $this->product->id_produk,
            'status' => 'masuk',
            'status_pembayaran' => 'belum_bayar',
            'total_harga' => 300000,
        ]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('markAsCompleted', $order->id_pemesanan);

        $order->refresh();
        $this->assertEquals('masuk', $order->status);
        $this->assertFalse($order->isSelesai());

        $orderSudahDp = Pemesanan::create([
            'nama' => 'Sudah DP Saputra',
            'no_hp' => '081377665544',
            'alamat' => 'Jl. Cendana No. 9',
            'produk_id' => $this->product->id_produk,
            'status' => 'masuk',
            'status_pembayaran' => 'sudah_dp',
            'total_harga' => 450000,
        ]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('markAsCompleted', $orderSudahDp->id_pemesanan);

        $orderSudahDp->refresh();
        $this->assertEquals('masuk', $orderSudahDp->status);
        $this->assertFalse($orderSudahDp->isSelesai());
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
            'status_pembayaran' => 'lunas',
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

    public function test_order_detail_blocks_completion_when_payment_not_lunas(): void
    {
        $order = Pemesanan::create([
            'nama' => 'Cicilin Muktadir',
            'no_hp' => '081744556677',
            'alamat' => 'Jl. Kenanga No. 21',
            'produk_id' => $this->product->id_produk,
            'status' => 'masuk',
            'status_pembayaran' => 'belum_bayar',
            'total_harga' => 700000,
        ]);

        Livewire::actingAs($this->admin)
            ->test(Detail::class, ['orderId' => $order->id_pemesanan])
            ->assertDontSee('Tandai Selesai')
            ->assertSee('butuh lunas')
            ->call('markAsCompleted');

        $order->refresh();
        $this->assertEquals('masuk', $order->status);
        $this->assertFalse($order->isSelesai());

        $order->status_pembayaran = 'sudah_dp';
        $order->save();

        Livewire::actingAs($this->admin)
            ->test(Detail::class, ['orderId' => $order->id_pemesanan])
            ->call('markAsCompleted');

        $order->refresh();
        $this->assertEquals('masuk', $order->status);

        Livewire::actingAs($this->admin)
            ->test(Detail::class, ['orderId' => $order->id_pemesanan])
            ->call('setPaymentStatus', 'lunas');

        $order->refresh();
        $this->assertTrue($order->isLunas());

        Livewire::actingAs($this->admin)
            ->test(Detail::class, ['orderId' => $order->id_pemesanan])
            ->assertSee('Tandai Selesai')
            ->call('markAsCompleted');

        $order->refresh();
        $this->assertEquals('selesai', $order->status);
    }

    public function test_admin_completed_orders_route_renders_successfully(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pesanan.completed'));

        $response->assertOk()
            ->assertSee('Pesanan Selesai')
            ->assertSee('Lihat Pesanan Masuk');
    }

    public function test_admin_can_filter_and_update_payment_status(): void
    {
        $order1 = Pemesanan::create([
            'nama' => 'Pelanggan Belum Bayar',
            'no_hp' => '08111111111',
            'alamat' => 'Alamat 1',
            'produk_id' => $this->product->id_produk,
            'status' => 'masuk',
            'status_pembayaran' => 'belum_bayar',
            'total_harga' => 200000,
        ]);

        $order2 = Pemesanan::create([
            'nama' => 'Pelanggan Sudah DP',
            'no_hp' => '08222222222',
            'alamat' => 'Alamat 2',
            'produk_id' => $this->product->id_produk,
            'status' => 'masuk',
            'status_pembayaran' => 'sudah_dp',
            'total_harga' => 400000,
        ]);

        $order3 = Pemesanan::create([
            'nama' => 'Pelanggan Sudah Lunas',
            'no_hp' => '08333333333',
            'alamat' => 'Alamat 3',
            'produk_id' => $this->product->id_produk,
            'status' => 'masuk',
            'status_pembayaran' => 'lunas',
            'total_harga' => 600000,
        ]);

        // Test filter sudah_dp
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('filterPayment', 'sudah_dp')
            ->assertSee('Pelanggan Sudah DP')
            ->assertDontSee('Pelanggan Belum Bayar')
            ->assertDontSee('Pelanggan Sudah Lunas');

        // Test filter lunas
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('filterPayment', 'lunas')
            ->assertSee('Pelanggan Sudah Lunas')
            ->assertDontSee('Pelanggan Belum Bayar')
            ->assertDontSee('Pelanggan Sudah DP');

        // Test update payment status from index
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('setPaymentStatus', $order1->id_pemesanan, 'sudah_dp');

        $order1->refresh();
        $this->assertEquals('sudah_dp', $order1->status_pembayaran);
        $this->assertTrue($order1->isSudahDp());

        // Test update payment status from detail
        Livewire::actingAs($this->admin)
            ->test(Detail::class, ['orderId' => $order1->id_pemesanan])
            ->call('setPaymentStatus', 'lunas');

        $order1->refresh();
        $this->assertEquals('lunas', $order1->status_pembayaran);
        $this->assertTrue($order1->isLunas());
    }
}
