<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MyPurchasesController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Buyer routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/place-buy/{productId}', [ProductController::class, 'placeBuy'])->name('placeBuy');
    Route::get('/my-purchases', [MyPurchasesController::class, 'index'])->name('my.purchases');

    // Admin routes
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');
        Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products.index');
        Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
        Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
        Route::get('/admin/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
        Route::put('/admin/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
        Route::delete('/admin/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
        Route::get('/admin/purchase-stats', [AdminController::class, 'purchaseStats'])->name('admin.purchase-stats');
    });
});
// Authentication routes
Auth::routes();
