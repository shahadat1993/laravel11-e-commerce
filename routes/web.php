<?php

use Illuminate\Http\Request;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\EcommerceController;
use App\Http\Controllers\Admin\RoleController;
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
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{slug}', [ShopController::class, 'productDetails'])->name('shop.details');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::put('/cart/increase/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.increase');
Route::put('/cart/decrease/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_cart_item'])->name('cart.item.remove');
Route::delete('/cart/clear', [CartController::class, 'clear_cart'])->name('cart.clear');
Route::post('/cart/coupon/apply', [CartController::class, 'apply_coupon_code'])->name('cart.coupon.apply');
Route::delete('/cart/coupon/remove', [CartController::class, 'remove_coupon_code'])->name('cart.coupon.remove');


// CHECKOUT
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/place-an-order', [CartController::class, 'place_an_order'])->name('cart.place.an.order');
Route::get('/order-confirmation', [CartController::class, 'order_confirmation'])->name('cart.order-confirmation');
// EDIT ADDRESS from Checkout
Route::get('/checkout/address/edit/{id}', [CartController::class, 'edit_address_checkout'])->name('checkout.address.edit');

// UPDATE ADDRESS from Checkout
Route::put('/checkout/address/update/{id}', [CartController::class, 'update_address_checkout'])->name('checkout.address.update');





// USER ACCOUNT DETAILS
Route::middleware('auth')->group(function () {
    Route::get('/account-details', [UserController::class, 'account_details'])->name('user.account.details');
    Route::post('/account-update', [UserController::class, 'account_update'])->name('user.account.update');
});
// USER ABOUT DETAILS
// Route::middleware('auth')->group(function () {
    Route::get('/about', [UserController::class, 'about'])->name('user.about');
// });


// USER ADDRESS
Route::middleware('auth')->group(function () {
    Route::get('/user/address', [UserController::class, 'address'])->name('user.address');
    Route::get('/user/address/add', [UserController::class, 'user_add_address'])->name('user.address.add');
    Route::post('/user/address/store', [UserController::class, 'store_address'])->name('user.address.store');
    Route::post('/user/address/default/{id}', [UserController::class, 'setDefault'])->name('user.address.default');
    Route::delete('/user/address/delete/{id}', [UserController::class, 'destroy'])->name('user.address.delete');
    Route::get('/user/address/edit/{id}', [UserController::class, 'edit_address'])->name('user.address.edit');
    Route::put('/user/address/update/{id}', [UserController::class, 'update_address'])->name('user.address.update');
});

// CONTACT-US
Route::middleware('auth')->group(function () {
    Route::get('/contact-us', [EcommerceController::class, 'contact'])->name('home.contact');
    Route::post('/contact-store', [EcommerceController::class, 'contact_store'])->name('home.contact.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('/account-order', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/account-order/{order_id}/details', [UserController::class, 'order_details'])->name('user.orders.details');
    Route::post('/account-order/order-cancel', [UserController::class, 'order_cancel'])->name('user.orders.cancel');
});

// ROUTE SEARCH METHOD
Route::get('/search', [EcommerceController::class, 'search'])->name('product.search');

// FRONTEND




// BACKEND

Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {

    // ১. সাধারণ অ্যাডমিন ড্যাশবোর্ড (সব স্টাফের জন্য)});
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    /** */
    Route::get('/admin/dashboard/chart-data', [AdminController::class, 'chartData'])->name('admin.dashboard.chart');
    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/admin/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');

    // ২. ইউজার ম্যানেজমেন্ট (শুধুমাত্র যাদের user পারমিশন আছে)
    Route::middleware(['can:user-list'])->group(function () {
        // Admnin user show route
        Route::get('admin/users', [AdminController::class, 'showUsers'])->name('admin.users');
        // admin profile show route
        Route::get('/admin/profile/show', [UserController::class, 'users'])->name('admin.profile.show');
        // User oder count route
        Route::get('/admin/user/{id}/orders', [UserController::class, 'showOrders'])->name('admin.user.orders');
    });

    Route::middleware(['can:user-create'])->group(function () {
        // Create user route
        Route::get('/admin/create-user/', [AdminController::class, 'create_user'])->name('admin.createUser.index');
        Route::post('/admin/store-user', [AdminController::class, 'store_user'])->name('admin.createUser.store');
    });

    Route::middleware(['can:user-edit'])->group(function () {
        Route::get('/admin/edit-user/{id}', [AdminController::class, 'edit_user'])->name('admin.createUser.edit');
        Route::put('/admin/update-user/{id}', [AdminController::class, 'update_user'])->name('admin.createUser.update');
    });

    Route::middleware(['can:user-delete'])->group(function () {
        Route::delete('/admin/delete-user/{id}', [AdminController::class, 'destroy_user'])->name('admin.createUser.destroy');
        // Admin user profile delete route
        Route::delete('/admin/user/delete/{id}', [UserController::class, 'delete_user'])
            ->name('admin.user.delete');
    });
    // ৩. রোল ম্যানেজমেন্ট (শুধুমাত্র Super Admin বা যাদের role-manage পারমিশন আছে)
    Route::middleware(['can:role-manage'])->group(function () {
        Route::get('admin/roles', [RoleController::class, 'index'])->name('admin.roles');
        Route::get('admin/create-role', [RoleController::class, 'create'])->name('admin.createRole');
        Route::post('admin/store-role', [RoleController::class, 'store'])->name('admin.storeRole');
        Route::get('admin/edit-role/{id}', [RoleController::class, 'edit'])->name('admin.editRole');
        Route::put('admin/update-role/{id}', [RoleController::class, 'update'])->name('admin.updateRole');
        Route::delete('admin/delete-role/{id}', [RoleController::class, 'destroy'])->name('admin.deleteRole');
    });
    // ৪. ক্যাটাগরি এবং ব্র্যান্ড (Manage Permission)
    Route::middleware(['can:category-manage'])->group(function () {
        Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
        Route::get('/admin/category/add', [CategoryController::class, 'add'])->name('admin.category.add');
        Route::post('/admin/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/admin/category/edit{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/admin/category/update', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/admin/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    });
    Route::middleware(['can:brand-manage'])->group(function () {
        Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
        Route::get('/admin/brands/add', [AdminController::class, 'addBrand'])->name('admin.add-brand');
        Route::post('/admin/brands/store', [AdminController::class, 'store_brand'])->name('admin.store');
        Route::get('/admin/brands/edit/{id}', [AdminController::class, 'edit_brand'])->name('admin.edit-brand');
        Route::put('/admin/brands/update', [AdminController::class, 'update_brand'])->name('admin.update-brand');
        Route::delete('/admin/brand/{id}', [AdminController::class, 'destroy_brand'])->name('admin.brand.delete');
    });

    // ৫. প্রোডাক্ট ম্যানেজমেন্ট
    Route::middleware(['can:product-list'])->group(function () {
        Route::get('/admin/product', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/admin/products/search', [AdminController::class, 'searchProduct'])->name('admin.product.search');

    });
    Route::middleware(['can:product-create'])->group(function () {
        Route::get('/admin/product/add', [ProductController::class, 'addProduct'])->name('admin.product.add');
        Route::post('/admin/product/store', [ProductController::class, 'storeProduct'])->name('admin.product.store');
    });
    Route::middleware(['can:product-edit'])->group(function () {
        Route::get('/admin/product/edit/{id}', [ProductController::class, 'editProduct'])->name('admin.product.edit');
        Route::put('/admin/product/update/', [ProductController::class, 'updateProduct'])->name('admin.product.update');
    });
    Route::middleware(['can:product-delete'])->group(function () {
        Route::delete('/admin/product/destroy/{id}', [ProductController::class, 'destroyProduct'])->name('admin.product.destroy');
    });

    // ৬. অর্ডার ম্যানেজমেন্ট
    Route::middleware(['can:order-list'])->group(function () {
        Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::get('/admin/order/{order_id}/details', [AdminController::class, 'orderDetails'])->name('admin.orders.details');
    });
    Route::middleware(['can:order-status-update'])->group(function () {
        Route::put('/admin/order/update-status', [AdminController::class, 'update_order_status'])->name('admin.orders.status.update');

        // Transaction update route
        Route::put('/transaction/status', [AdminController::class, 'updateTransactionStatus'])
            ->name('admin.transaction.status.update');
    });


    // ৭. কুপন এবং স্লাইডার (Marketing/Banner Manage)
    Route::middleware(['can:coupon-manage'])->group(function () {
        Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupon');
        Route::get('/admin/coupons/add', [AdminController::class, 'add_coupon'])->name('admin.coupon.add');
        Route::post('/admin/coupons/store', [AdminController::class, 'store_coupon'])->name('admin.coupon.store');
        Route::get('/admin/coupons/edit/{id}', [AdminController::class, 'edit_coupon'])->name('admin.coupon.edit');
        Route::put('/admin/coupons/update/{id}', [AdminController::class, 'update_coupon'])->name('admin.coupon.update');
        Route::delete('/admin/coupons/destroy/{id}', [AdminController::class, 'delete_coupon'])->name('admin.coupon.destroy');
    });

    Route::middleware(['can:banner-manage'])->group(function () {
        Route::get('/admin/slides', [AdminController::class, 'slides'])->name('admin.slide.index');
        Route::get('/admin/slide/add', [AdminController::class, 'slide_add'])->name('admin.slide.add');
        Route::post('/admin/slide/store', [AdminController::class, 'slide_store'])->name('admin.slide.store');
        Route::get('/admin/slide/edit/{id}', [AdminController::class, 'slide_edit'])->name('admin.slide.edit');
        Route::put('/admin/slide/update/{id}', [AdminController::class, 'slide_update'])->name('admin.slide.update');
        Route::delete('/admin/slide/destroy/{id}', [AdminController::class, 'slide_destroy'])->name('admin.slide.delete');
    });
});


















// Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {
//     /** */

// });


// // CATEGORIES
// Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {});


// // Products
// Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {});


// // SLIDES
// Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {});



// // COUPONS
// Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {});


// // ORDERS
// Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {



//     // Route for Order tracking
//     Route::get('/admin/order/track-order', [AdminController::class, 'track_order'])->name('admin.order.track');

//     // Transaction status update Route
//     // Route::put('/admin/transaction/status', [AdminController::class, 'updateTransactionStatus'])
//     //     ->name('admin.transaction.status.update')
//     //     ->middleware('auth:admin');
// });

// Wishlist Routes
Route::post('/wishlist/add', [WishListController::class, 'add_to_wishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/item/remove/{rowId}', [WishListController::class, 'remove_wishlist'])->name('wishlist.item.remove');
Route::delete('/wishlist/clear', [WishListController::class, 'empty_wishlist'])->name('wishlist.destroy');
Route::post('/wishlist/move-to-cart/{rowId}', [WishListController::class, 'move_to_cart'])->name('wishlist.move.to.cart');

// USER WISHLIST ROUTE
Route::get('/user/wishlist', [WishListController::class, 'userWishlist'])->name('user.wishlist');
require __DIR__ . '/auth.php';



Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {
    Route::get('/admin/contact', [AdminController::class, 'contacts'])->name('admin.contact.index');
    Route::delete('/admin/contact/delete/{id}', [AdminController::class, 'delete_contact'])->name('admin.contact.destroy');
});

// BACKEND SEARCH ROUTE
Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {
    // admin search route
    /** */
    // admin product search route

});
// BACKEND Profile ROUTE
Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {
    // admin profile route









});

// Backend Role & Permission Route
Route::middleware(['auth', 'verified', AuthAdmin::class])->group(function () {




    // Create Role route

});


// Route for invoice download
Route::get('/invoice/{order}', [InvoiceController::class, 'download'])
    ->name('invoice.download');
