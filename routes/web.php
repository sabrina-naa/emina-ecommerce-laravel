<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VarianProdukController;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PesananController;
use App\Http\Controllers\Frontend\ReviewController as FrontendReviewController;
use App\Http\Controllers\Frontend\CustomerAuthController;
use App\Http\Controllers\Frontend\CustomerProfileController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES (Customer)
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/{id}', [ShopController::class, 'show'])->name('show');
});

// Kategori
Route::get('/makeup', [ShopController::class, 'kategori'])->defaults('slug', 'makeup')->name('makeup');
Route::get('/skincare', [ShopController::class, 'kategori'])->defaults('slug', 'skincare')->name('skincare');
Route::get('/lip-products', [ShopController::class, 'kategori'])->defaults('slug', 'lip-products')->name('lip-products');
Route::get('/sun-protection', [ShopController::class, 'kategori'])->defaults('slug', 'sun-protection')->name('sun-protection');

// Promo
Route::get('/promo', [\App\Http\Controllers\Frontend\PromoController::class, 'index'])->name('promo');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::post('/toggle-select/{id}', [CartController::class, 'toggleSelect'])->name('toggle-select'); 
    Route::post('/select-all', [CartController::class, 'selectAll'])->name('select-all'); 
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'getCount'])->name('count');
});

// Checkout
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/success/{id}', [CheckoutController::class, 'success'])->name('success');
});

// Pesanan
Route::middleware('auth:customer')->group(function () {
    Route::get('/pesanan-saya', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{kode}', [PesananController::class, 'show'])->name('pesanan.show');
});

// Customer Auth (Login, Register, Logout)
Route::prefix('customer')->name('customer.')->group(function () {
    // Guest only (belum login)
    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [CustomerAuthController::class, 'login']);
        Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [CustomerAuthController::class, 'register']);
    });
    
    // Authenticated only (sudah login)
    Route::middleware('auth:customer')->group(function () {
        Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
        
        // Profile
        Route::get('/profile', [CustomerProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/foto', [CustomerProfileController::class, 'updateFoto'])->name('profile.foto');
        Route::put('/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('profile.password');
        
        // Review 
         Route::prefix('review')->name('review.')->group(function () {
            Route::get('/', [FrontendReviewController::class, 'index'])->name('index');
            Route::get('/create/{transaksiId}', [FrontendReviewController::class, 'create'])->name('create');
            Route::post('/store', [FrontendReviewController::class, 'store'])->name('store');
        });

        // Orders
        Route::get('/orders', [CustomerProfileController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [CustomerProfileController::class, 'orderDetail'])->name('orders.detail');

    });
});

/*
|--------------------------------------------------------------------------
| BACKEND ROUTES (Admin)
|--------------------------------------------------------------------------
*/

Route::get('backend/beranda', [BerandaController::class, 'berandaBackend'])->name('backend.beranda')->middleware('auth:admin');

Route::get('backend/login', [LoginController::class, 'loginBackend'])->name('backend.login');
Route::post('backend/login', [LoginController::class, 'authenticateBackend'])->name('backend.login');
Route::post('backend/logout', [LoginController::class, 'logoutBackend'])->name('backend.logout')->middleware('auth:admin');

Route::resource('backend/user', UserController::class, ['as' => 'backend'])->middleware('auth:admin');

Route::resource('backend/kategori', KategoriController::class, ['as' => 'backend'])->middleware('auth:admin');

Route::resource('backend/produk', ProdukController::class, ['as' => 'backend'])->middleware('auth:admin');

Route::prefix('backend/varian')
    ->name('backend.varian.')
    ->middleware('auth:admin')
    ->group(function () {
        Route::post('/', [VarianProdukController::class, 'store'])->name('store');
        Route::put('/{id}', [VarianProdukController::class, 'update'])->name('update');
        Route::delete('/{id}', [VarianProdukController::class, 'destroy'])->name('destroy');
    });

// Route untuk menambahkan foto
Route::post('foto-produk/store', [ProdukController::class, 'storeFoto'])->name('backend.foto_produk.store')->middleware('auth:admin');
// Route untuk menghapus foto
Route::delete('foto-produk/{id}', [ProdukController::class, 'destroyFoto'])->name('backend.foto_produk.destroy')->middleware('auth:admin');

Route::get('backend/laporan/formuser', [UserController::class, 'formUser'])->name('backend.laporan.formuser')->middleware('auth:admin');
Route::post('backend/laporan/cetakuser', [UserController::class, 'cetakUser'])->name('backend.laporan.cetakuser')->middleware('auth:admin');

Route::get('backend/laporan/formproduk', [ProdukController::class, 'formProduk'])->name('backend.laporan.formproduk')->middleware('auth:admin');
Route::post('backend/laporan/cetakproduk', [ProdukController::class, 'cetakProduk'])->name('backend.laporan.cetakproduk')->middleware('auth:admin');


Route::prefix('backend/transaksi')
    ->name('backend.transaksi.')
    ->middleware('auth:admin')
    ->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/{id}', [TransaksiController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [TransaksiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TransaksiController::class, 'update'])->name('update');
        Route::delete('/{id}', [TransaksiController::class, 'destroy'])->name('destroy');
    });


// Customer 
Route::prefix('backend/customer')
    ->name('backend.customer.')
    ->middleware('auth:admin')
    ->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::put('/{id}/status', [CustomerController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
    });

// Review 
Route::prefix('backend/reviews')
    ->name('backend.reviews.')
    ->middleware('auth:admin')
    ->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/{id}', [ReviewController::class, 'show'])->name('show');
        Route::post('/{id}/reply', [ReviewController::class, 'reply'])->name('reply');
        Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy');
    });