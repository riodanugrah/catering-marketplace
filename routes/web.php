<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MerchantProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Merchant
    Route::get('/admin/merchants/create', [AdminDashboardController::class, 'createMerchant'])->name('admin.merchants.create');
    Route::post('/admin/merchants', [AdminDashboardController::class, 'storeMerchant'])->name('admin.merchants.store');
    Route::get('/admin/merchants/{merchant}/edit', [AdminDashboardController::class, 'editMerchant'])->name('admin.merchants.edit');
    Route::put('/admin/merchants/{merchant}', [AdminDashboardController::class, 'updateMerchant'])->name('admin.merchants.update');
    Route::delete('/admin/merchants/{merchant}', [AdminDashboardController::class, 'destroyMerchant'])->name('admin.merchants.destroy');

    // Customer
    Route::get('/admin/customers/{customer}/edit', [AdminDashboardController::class, 'editCustomer'])->name('admin.customers.edit');
    Route::put('/admin/customers/{customer}', [AdminDashboardController::class, 'updateCustomer'])->name('admin.customers.update');
    Route::delete('/admin/customers/{customer}', [AdminDashboardController::class, 'destroyCustomer'])->name('admin.customers.destroy');

    // Order
    Route::get('/admin/orders/{order}/edit', [AdminDashboardController::class, 'editOrder'])->name('admin.orders.edit');
    Route::put('/admin/orders/{order}', [AdminDashboardController::class, 'updateOrder'])->name('admin.orders.update');
    Route::delete('/admin/orders/{order}', [AdminDashboardController::class, 'destroyOrder'])->name('admin.orders.destroy');
});

Route::middleware(['auth', 'role:merchant'])->group(function () {
    Route::get('/merchant/dashboard', [MerchantProfileController::class, 'index'])->name('merchant.dashboard');

    Route::get('/merchant/menus', [MenuController::class, 'index'])->name('merchant.menus');
    Route::get('/merchant/menus/create', [MenuController::class, 'create'])->name('merchant.menus.create');
    Route::post('/merchant/menus', [MenuController::class, 'store'])->name('merchant.menus.store');
    Route::get('/merchant/menus/{menu}/edit', [MenuController::class, 'edit'])->name('merchant.menus.edit');
    Route::put('/merchant/menus/{menu}', [MenuController::class, 'update'])->name('merchant.menus.update');
    Route::delete('/merchant/menus/{menu}', [MenuController::class, 'destroy'])->name('merchant.menus.destroy');

    Route::get('/merchant/orders', [OrderController::class, 'index'])->name('merchant.orders');
    Route::get('/merchant/orders/{order}', [OrderController::class, 'show'])->name('merchant.orders.show');
});

require __DIR__ . '/auth.php';
