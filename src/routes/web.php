<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CustomerHomeController;
use App\Http\Controllers\DealOrderController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderController as CustomerOrderController;
use App\Http\Controllers\VirtualFittingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\Model3DController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AnalyticsController;

// ==========================================
// 1. CUSTOMER STOREFRONT ROUTES
// ==========================================
Route::get('/', [CustomerHomeController::class, 'index'])->name('home');
Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collection/{produk}', [CollectionController::class, 'show'])->name('collection.show');
Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
Route::get('/virtual-fitting', [VirtualFittingController::class, 'index'])->name('virtual-fitting');
Route::view('/about', 'customer.about')->name('about');
Route::get('/order/create', [CustomerOrderController::class, 'create'])->name('order.create');
Route::post('/order', [CustomerOrderController::class, 'store'])->name('order.store');
Route::get('/order/success', [CustomerOrderController::class, 'success'])->name('order.success');

// Dedicated Standalone Deal Order Form (Direct Vendor-Customer Deal)
Route::get('/form-pemesanan', [DealOrderController::class, 'create'])->name('deal-order.create');
Route::post('/form-pemesanan', [DealOrderController::class, 'store'])->name('deal-order.store');
Route::get('/form-pemesanan/sukses', [DealOrderController::class, 'success'])->name('deal-order.success');

// ==========================================
// 2. AUTHENTICATION ROUTES
// ==========================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// 3. ADMIN VENDOR DASHBOARD ROUTES
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Overview Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Analytics & Business Performance
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    // Profil Vendor & Settings
    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profil-vendor', [ProfileController::class, 'edit'])->name('profile.legacy');

    // Manajemen Kategori / Material & Produk
    Route::resource('kategori', CategoryController::class);
    Route::resource('produk', ProductController::class);

    // Matriks Dimensi Ukuran (Size Charts)
    Route::resource('ukuran', SizeController::class);

    // Aset Model Pakaian 3D (.glb/.gltf)
    Route::resource('model-3d', Model3DController::class);
    Route::get('/model-3d/{id}/preview', [Model3DController::class, 'preview'])->name('model-3d.preview');

    // Manajemen Pesanan & Faktur Invoice
    Route::resource('pesanan', AdminOrderController::class);
    Route::get('/pesanan/{id}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');

    // Manajemen Data Pelanggan (Customers)
    Route::resource('pelanggan', CustomerController::class)->names('customers');
});
