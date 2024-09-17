<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SiteController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\NotifyController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::prefix(LaravelLocalization::setLocale())->group(function(){
    Route::prefix('admin')->name('admin.')->middleware('auth', 'user_type', 'verified')->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
        Route::get('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::get('categories/{id}/forcedelete', [CategoryController::class, 'forcedelete'])->name('categories.forcedelete');
        Route::resource('categories', CategoryController::class);

        Route::get('products/trash', [ProductController::class, 'trash'])->name('products.trash');
        Route::get('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
        Route::get('products/{id}/forcedelete', [ProductController::class, 'forcedelete'])->name('products.forcedelete');
        Route::resource('products', ProductController::class);
        Route::get('delete-image/{id}', [ProductController::class, 'delete_image'])->name('products.delete_image');

        Route::get('notify', [NotifyController::class, 'index'])->name('notify.index');

        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::delete('payments/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Auth::routes(['verify' => true]);

    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::view('no-access', 'no_access');

    Route::get('/', [SiteController::class, 'index'])->name('site.index')->middleware('verified');
    Route::get('/about', [SiteController::class, 'about'])->name('site.about')->middleware('verified');
    Route::get('/shop', [SiteController::class, 'shop'])->name('site.shop')->middleware('verified');
    Route::get('/contact', [SiteController::class, 'contact'])->name('site.contact')->middleware('verified');
    Route::get('/category/{id}', [SiteController::class, 'category'])->name('site.category')->middleware('verified');
    Route::get('/search', [SiteController::class, 'search'])->name('site.search')->middleware('verified');
    Route::get('/product/{slug}', [SiteController::class, 'product'])->name('site.product')->middleware('verified');
    Route::post('/product/{slug}/review', [SiteController::class, 'product_review'])->name('site.product_review')->middleware('verified');

    Route::post('/add-to-cart', [CartController::class, 'add_to_cart'])->name('site.add_to_cart')->middleware('verified');
    Route::get('/cart', [CartController::class, 'cart'])->name('site.cart')->middleware('auth')->middleware('verified');
    Route::post('/update-cart', [CartController::class, 'update_cart'])->name('site.update_cart')->middleware('auth','verified');
    Route::get('/cart/{id}', [CartController::class, 'remove_cart'])->name('site.remove_cart')->middleware('auth','verified');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('site.checkout')->middleware('auth','verified');
    Route::get('/payment', [CartController::class, 'payment'])->name('site.payment')->middleware('auth','verified');
    Route::get('/payment/success', [CartController::class, 'success'])->name('site.success')->middleware('auth','verified');
    Route::get('/payment/fail', [CartController::class, 'fail'])->name('site.fail')->middleware('auth','verified');
});

Route::get('send-notification', function() {

    // $user = Auth::user();

    // Mail::to($user->email)->send( new InvoiceMail() );

    // $user->notify(new NewOrderNotification());

});

include 'test.php';
