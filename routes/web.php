<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Frontend\CartController; 
use App\Http\Controllers\Owner\EmployeeController;

//controller admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Admin\AdminProfileController;
//controller pemilik
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Frontend\OrderController as FrontendOrderController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Models\Product;
use App\Models\Promo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Halaman Utama (Landing Page)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute baru untuk halaman promo
Route::get('/promo', function () {$promos = Promo::all(); return view('promo', compact('promos')); })->name('promo');

// Rute baru untuk halaman produk
Route::get('/produk', function () { $products = Product::all(); return view('produk', compact('products')); })->name('produk');

// Rute Halaman Tentang Kami
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');

// Rute untuk Halaman Kontak Kami
Route::get('/kontak-kami', [HomeController::class, 'contact'])->name('contact');

// Rute untuk Halaman & Proses Autentikasi
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// Rute untuk Produk
Route::get('/produk/{product:slug}', [App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('products.show');

    // Rute yang memerlukan login (dilindungi middleware)
 Route::middleware('auth')->group(function () {
     // Rute Dasbor Pelanggan
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('profile.dashboard');
    Route::get('/dashboard/pesanan', [ProfileController::class, 'orders'])->name('profile.orders');
    //Route Edit Profil
    Route::get('/dashboard/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/dashboard/profil', [ProfileController::class, 'update'])->name('profile.update');
    
    // --- Rute BARU untuk Ubah Password ---
    Route::get('/dashboard/profil/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/dashboard/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
// TAMBAHKAN RUTE BARU UNTUK MELIHAT & MENAMBAH KE KERANJANG
    Route::post('/keranjang/tambah', [App\Http\Controllers\Frontend\CartController::class, 'store'])->name('cart.store');
    Route::get('/keranjang', [App\Http\Controllers\Frontend\CartController::class, 'index'])->name('cart.index');
    // Ubah {rowId} menjadi {productId}
    Route::patch('/keranjang/update/{productId}', [App\Http\Controllers\Frontend\CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/hapus/{productId}', [App\Http\Controllers\Frontend\CartController::class, 'remove'])->name('cart.remove');

    // RUTE BARU UNTUK CHECKOUT
    Route::get('/checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order_number}', [App\Http\Controllers\Frontend\CheckoutController::class, 'showSuccessPage'])->name('checkout.success');
    //Bukti Pembayaran
    Route::post('/orders/{order}/upload-proof', [App\Http\Controllers\Frontend\OrderController::class, 'uploadPaymentProof'])->name('orders.uploadPaymentProof');
    //Konfirmasi pesanan
    Route::put('/order/{order}/confirm', [App\Http\Controllers\Frontend\OrderController::class, 'confirmReceived'])->name('order.confirm_received');
    // Route baru untuk mengambil biaya pengiriman secara dinamis
    Route::get('/checkout/shipping-cost', [App\Http\Controllers\Frontend\CheckoutController::class, 'getShippingCost'])->name('checkout.shipping-cost');
     // Rute untuk mengunggah ulang desain
    Route::patch('/orders/{orderItem}/reupload-design', [App\Http\Controllers\Frontend\OrderController::class, 'reuploadDesign'])
        ->name('orders.reupload-design');
    //invoice  Cetak
    Route::get('/orders/{orderId}/invoice', [App\Http\Controllers\Frontend\OrderController::class, 'downloadInvoice'])->name('customer.invoice.download');

        
});

//route akses admin/karyawan
//middleware Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    //Rute Dashboard Admun
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
   
    // Rute-Data Pelamggam
    Route::resource('pelanggan', CustomerController::class)->names('admin.customers'); //Route Data Pelanggan
    
    //Rute Pesanan
    Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/pesanan/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    
    //Rute Produk (Resource)
    Route::resource('products', \App\Http\Controllers\Admin\AdminProductController::class)->except('show');
   
    //Rute Promo (Resource)
    Route::resource('promo', \App\Http\Controllers\Admin\PromoController::class);
   
    // Rute profil Admin
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/profile/password', [AdminProfileController::class, 'editPassword'])->name('admin.profile.password.edit');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.password.update');
    
    // Rute laporan pemesanan
    Route::get('/laporan/pemesanan', [LaporanController::class, 'index'])->name('admin.report.admin_laporan');
    
    // Rute untuk verifikasi pembayaran
    Route::post('/orders/{order}/verify-payment', [App\Http\Controllers\Admin\OrderController::class, 'verifyPayment'])
        ->name('orders.verifyPayment');

    //Rute Pemesanan Offline
    Route::get('/admin/orders/create', [App\Http\Controllers\Admin\OrderController::class, 'createForStaff'])->name('admin.order.create');
    Route::post('/admin/orders/store', [App\Http\Controllers\Admin\OrderController::class, 'storeForStaff'])->name('admin.orders.store');
});

Route::middleware(['auth', 'owner'])->prefix('owner')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
     Route::resource('employee', EmployeeController::class)->names('owner.employee');
     // Route untuk Pengaturan Profil Owner
    Route::get('/profile/edit', [App\Http\Controllers\Owner\ProfileController::class, 'edit'])->name('owner.profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\Owner\ProfileController::class, 'update'])->name('owner.profile.update');
    Route::get('/profile/password', [App\Http\Controllers\Owner\ProfileController::class, 'editPassword'])->name('owner.profile.password.edit');
    Route::put('/profile/password', [App\Http\Controllers\Owner\ProfileController::class, 'updatePassword'])->name('owner.profile.password.update');
     Route::get('/settings', [App\Http\Controllers\Owner\SettingController::class, 'index'])->name('owner.settings.index');
    Route::post('/settings', [App\Http\Controllers\Owner\SettingController::class, 'update'])->name('owner.settings.update');    
});