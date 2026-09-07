<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::create([
            'nama' => 'Admin Tigabenang',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($admin);
        config(['filesystems.default' => 'public']);
        Storage::fake('public');
    }

    public function test_admin_can_upload_product_and_automatically_generate_webp(): void
    {
        Storage::fake('public');

        /** @var Kategori $kategori */
        $kategori = Kategori::query()->create([
            'nama_kategori' => 'Jaket',
        ]);

        $image = UploadedFile::fake()->image('varsity-custom.png', 400, 400);

        $response = $this->post(route('admin.produk.store'), [
            'nama_produk' => 'Varsity Vintage Edition',
            'kategori_id' => $kategori->id_kategori,
            'harga' => 350000,
            'gambar' => $image,
        ]);

        $response->assertRedirect(route('admin.produk.index'));
        $response->assertSessionHas('success');

        /** @var Produk $produk */
        $produk = Produk::query()->where('nama_produk', 'Varsity Vintage Edition')->firstOrFail();
        $this->assertNotNull($produk->gambar);

        // Verify original uploaded file exists in public storage
        Storage::disk('public')->assertExists((string) $produk->gambar);

        // Verify that .webp version was automatically generated in public storage if webp is supported
        $webpPath = $produk->gambar_webp;
        $this->assertNotNull($webpPath);
        $this->assertStringEndsWith('.webp', $webpPath);
        if ($this->supportsWebp()) {
            Storage::disk('public')->assertExists((string) $webpPath);
        }
    }

    public function test_admin_updating_product_image_replaces_both_original_and_webp(): void
    {
        Storage::fake('public');

        /** @var Kategori $kategori */
        $kategori = Kategori::query()->create([
            'nama_kategori' => 'Kaos',
        ]);

        $initialImage = UploadedFile::fake()->image('kaos-old.png', 300, 300);

        $this->post(route('admin.produk.store'), [
            'nama_produk' => 'Kaos Polos',
            'kategori_id' => $kategori->id_kategori,
            'harga' => 100000,
            'gambar' => $initialImage,
        ]);

        /** @var Produk $produk */
        $produk = Produk::query()->where('nama_produk', 'Kaos Polos')->firstOrFail();
        $oldGambar = (string) $produk->gambar;
        $oldWebp = (string) $produk->gambar_webp;

        $this->assertNotEmpty($oldGambar);
        $this->assertNotEmpty($oldWebp);

        Storage::disk('public')->assertExists($oldGambar);
        if ($this->supportsWebp()) {
            Storage::disk('public')->assertExists($oldWebp);
        }

        // Update with new image
        $newImage = UploadedFile::fake()->image('kaos-new.png', 300, 300);

        $updateResponse = $this->put(route('admin.produk.update', $produk->id_produk), [
            'nama_produk' => 'Kaos Polos Updated',
            'kategori_id' => $kategori->id_kategori,
            'harga' => 110000,
            'gambar' => $newImage,
        ]);

        $updateResponse->assertRedirect(route('admin.produk.index'));

        $produk->refresh();
        $newGambar = (string) $produk->gambar;
        $newWebp = (string) $produk->gambar_webp;

        $this->assertNotEquals($oldGambar, $newGambar);

        // Old files must be deleted
        Storage::disk('public')->assertMissing($oldGambar);
        if ($this->supportsWebp()) {
            Storage::disk('public')->assertMissing($oldWebp);
            Storage::disk('public')->assertExists($newWebp);
        }

        // New files must exist
        Storage::disk('public')->assertExists($newGambar);
    }

    public function test_admin_deleting_product_removes_both_original_and_webp(): void
    {
        Storage::fake('public');

        /** @var Kategori $kategori */
        $kategori = Kategori::query()->create([
            'nama_kategori' => 'Outerwear',
        ]);

        $image = UploadedFile::fake()->image('jacket.png', 400, 400);

        $this->post(route('admin.produk.store'), [
            'nama_produk' => 'Windbreaker Arctic',
            'kategori_id' => $kategori->id_kategori,
            'harga' => 250000,
            'gambar' => $image,
        ]);

        /** @var Produk $produk */
        $produk = Produk::query()->where('nama_produk', 'Windbreaker Arctic')->firstOrFail();
        $gambar = (string) $produk->gambar;
        $webp = (string) $produk->gambar_webp;

        $this->assertNotEmpty($gambar);
        $this->assertNotEmpty($webp);

        Storage::disk('public')->assertExists($gambar);
        if ($this->supportsWebp()) {
            Storage::disk('public')->assertExists($webp);
        }

        $deleteResponse = $this->delete(route('admin.produk.destroy', $produk->id_produk));
        $deleteResponse->assertRedirect(route('admin.produk.index'));

        // Both files must be deleted
        Storage::disk('public')->assertMissing($gambar);
        if ($this->supportsWebp()) {
            Storage::disk('public')->assertMissing($webp);
        }

        $this->assertDatabaseMissing('produk', [
            'id_produk' => $produk->id_produk,
        ]);
    }

    protected function supportsWebp(): bool
    {
        return function_exists('imagewebp');
    }
}
