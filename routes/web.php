<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/slider/storage/{filename}', [FrontendController::class, 'getImage'])->name('frontend.getSliderImage');
Route::get('/produk-terbaru/storage/{filename}', [FrontendController::class, 'getImageProdukBaru'])->name('frontend.getImageProdukBaru');
Route::get('/produk/{slug}', [FrontendController::class, 'kategori'])->name('frontend.kategori');
Route::post('/produk/cart/{slug}', [FrontendController::class, 'produkCart'])->name('frontend.produkCart');
Route::get('/produk/detail/{slug}', [FrontendController::class, 'produkDetail'])->name('frontend.produkDetail');
Route::get('/cart', [FrontendController::class, 'orderCart'])->name('frontend.orderCart');
Route::post('/produk/cart', [FrontendController::class, 'produkTambahCart'])->name('frontend.produkTambahCart');
Route::get('/totalcart', [FrontendController::class, 'totalCart'])->name('frontend.totalCart');
Route::post('/totalcart/{id}', [FrontendController::class, 'updateTotalCart'])->name('frontend.updateTotalCart');
Route::delete('/deletecart/{id}', [FrontendController::class, 'deleteCart'])->name('frontend.deleteCart');
// Route::get('/proses-checkout', [FrontendController::class, 'prosesCheckout'])->name('frontend.prosesCheckout');
Route::get('/pembayaran/{id}', [FrontendController::class, 'pembayaran'])->name('frontend.pembayaran');
Route::post('/pembayaran', [FrontendController::class, 'prosesPembayaran'])->name('frontend.prosesPembayaran');
Route::get('/detail-pembayaran', [FrontendController::class, 'detailPembayaran'])->name('frontend.detailPembayaran');
Auth::routes();


Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
    Route::resource('/kategori', KategoriController::class);

    Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
    Route::resource('/produk', ProdukController::class);
    Route::get('/produk/storage/{filename}', [ProdukController::class, 'getImage'])->name('produk.getImage');

    Route::get('/slider/data', [SliderController::class, 'data'])->name('slider.data');
    Route::resource('/slider', SliderController::class);
    Route::get('/slider/storage/{filename}', [SliderController::class, 'getImage'])->name('slider.getImage');

    Route::get('/pembayaran/data', [PembayaranController::class, 'data'])->name('pembayaran.data');
    Route::resource('/pembayaran', PembayaranController::class);
    Route::get('/pembayaran/storage/{filename}', [PembayaranController::class, 'getImagePembayaran'])->name('pembayaran.getImagePembayaran');
});
