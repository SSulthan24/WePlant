<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\MarketplaceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Farmer\DashboardController as FarmerDashboardController;
use App\Http\Controllers\Farmer\DroneController;
use App\Http\Controllers\Farmer\ScanHistoryController;
use App\Http\Controllers\Farmer\OrderController;
use App\Http\Controllers\Farmer\GardenController;
use App\Http\Controllers\Farmer\SettingsController as FarmerSettingsController;
use App\Http\Controllers\Partner\DashboardController as PartnerDashboardController;
use App\Http\Controllers\Partner\ProductController as PartnerProductController;
use App\Http\Controllers\Partner\OrderController as PartnerOrderController;
use App\Http\Controllers\Partner\SalesReportController;
use App\Http\Controllers\Partner\SettingsController as PartnerSettingsController;

// Public routes
Route::view('/', 'pages.home')->name('home');
Route::view('/tentang', 'pages.about')->name('about');
Route::get('/toko', [ShopController::class, 'index'])->name('shop');
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles');
Route::get('/artikel/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Cart routes
Route::get('/keranjang', [CartController::class, 'index'])->name('cart');
Route::post('/keranjang/tambah/{id}', [CartController::class, 'add'])->name('cart.add');
Route::put('/keranjang/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/hapus/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// Authentication routes
Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
Route::post('/masuk', [AuthController::class, 'login']);
Route::get('/daftar/petani', [AuthController::class, 'showRegisterFarmer'])->name('register.farmer');
Route::post('/daftar/petani', [AuthController::class, 'registerFarmer']);
Route::get('/daftar/mitra', [AuthController::class, 'showRegisterPartner'])->name('register.partner');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes - Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/products/{id}/approve', [ProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{id}/reject', [ProductController::class, 'reject'])->name('products.reject');
    Route::put('/products/{id}/status', [ProductController::class, 'updateStatus'])->name('products.update-status');
    Route::get('/articles', [AdminArticleController::class, 'index'])->name('articles');
    Route::get('/articles/create', [AdminArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [AdminArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{id}', [AdminArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');
    Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
});

// Protected routes - Farmer
Route::middleware(['auth'])->prefix('farmer')->name('farmer.')->group(function () {
    Route::get('/dashboard', [FarmerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/drone', [DroneController::class, 'index'])->name('drone');
    Route::get('/scan-history', [ScanHistoryController::class, 'index'])->name('scan-history');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/garden', [GardenController::class, 'index'])->name('garden');
    Route::post('/garden', [GardenController::class, 'update'])->name('garden.update');
    Route::get('/settings', [FarmerSettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [FarmerSettingsController::class, 'update'])->name('settings.update');
});

// Protected routes - Partner
Route::middleware(['auth'])->prefix('partner')->name('partner.')->group(function () {
    Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [PartnerProductController::class, 'index'])->name('products');
    Route::get('/products/create', [PartnerProductController::class, 'create'])->name('products.create');
    Route::post('/products', [PartnerProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [PartnerProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [PartnerProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [PartnerProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/orders', [PartnerOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [PartnerOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [PartnerOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/sales-report', [SalesReportController::class, 'index'])->name('sales-report');
    Route::get('/sales-report/export-pdf', [SalesReportController::class, 'exportPdf'])->name('sales-report.export-pdf');
    Route::get('/sales-report/export-excel', [SalesReportController::class, 'exportExcel'])->name('sales-report.export-excel');
    Route::get('/settings', [PartnerSettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [PartnerSettingsController::class, 'update'])->name('settings.update');
});
