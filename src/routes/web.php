<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CustomerHomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VirtualFittingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CustomerHomeController::class, 'index'])->name('home');

Route::get('/collection', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collection/{produk}', [CollectionController::class, 'show'])->name('collection.show');

Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');

Route::get('/virtual-fitting', [VirtualFittingController::class, 'index'])->name('virtual-fitting');

Route::view('/about', 'customer.about')->name('about');

Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
