<?php

use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EcommerceController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\CategoryController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [EcommerceController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// SHOP
Route::get('/shop',[ShopController::class,'index'])->name('shop');
Route::get('/shop/{slug}',[ShopController::class,'productDetails'])->name('shop.details');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});

// FRONTEND




// BACKEND
Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brands/add', [AdminController::class, 'addBrand'])->name('admin.add-brand');
    Route::post('/admin/brands/store', [AdminController::class, 'store_brand'])->name('admin.store');
    Route::get('/admin/brands/edit/{id}', [AdminController::class, 'edit_brand'])->name('admin.edit-brand');
    Route::put('/admin/brands/update', [AdminController::class, 'update_brand'])->name('admin.update-brand');
    Route::delete('/admin/brand/{id}', [AdminController::class, 'destroy_brand'])->name('admin.brand.delete');
});


// CATEGORIES
Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('/admin/category/add', [CategoryController::class, 'add'])->name('admin.category.add');
    Route::post('/admin/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/admin/category/edit{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/admin/category/update', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/admin/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
});


// Products
Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {
    Route::get('/admin/product', [ProductController::class, 'index'])->name('admin.product.index');
    Route::get('/admin/product/add', [ProductController::class, 'addProduct'])->name('admin.product.add');
    Route::post('/admin/product/store', [ProductController::class, 'storeProduct'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}', [ProductController::class, 'editProduct'])->name('admin.product.edit');
    Route::put('/admin/product/update/', [ProductController::class, 'updateProduct'])->name('admin.product.update');
    Route::delete('/admin/product/destroy/{id}', [ProductController::class, 'destroyProduct'])->name('admin.product.destroy');

});

require __DIR__.'/auth.php';
