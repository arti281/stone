<?php

use Illuminate\Support\Facades\Route;

// Catalog
use App\Http\Controllers\Catalog\HomeController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Admin\Setting\ApiController;
use App\Http\Controllers\Admin\Setting\SiteController;
use App\Http\Controllers\Admin\Design\BannerController;
use App\Http\Controllers\Admin\Common\ProfileController;
use App\Http\Controllers\Catalog\ReviewController;
use App\Http\Controllers\Catalog\ReviewReplyController;

//admin
use App\Http\Controllers\Admin\Setting\GeneralController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Storefront\SizeController;
use App\Http\Controllers\Catalog\Account\LoginController;
use App\Http\Controllers\Catalog\Account\OrderController;
use App\Http\Controllers\Catalog\Checkout\CartController;
use App\Http\Controllers\Admin\Storefront\ColorController;
use App\Http\Controllers\Catalog\Account\GoogleController;
use App\Http\Controllers\Admin\Common\AdminLoginController;
use App\Http\Controllers\Admin\Design\AdminMediaController;
use App\Http\Controllers\Catalog\Account\AccountController;
use App\Http\Controllers\Catalog\Account\AddressController;
use App\Http\Controllers\Catalog\Product\ProductController;
use App\Http\Controllers\Catalog\Account\WishlistController;
use App\Http\Controllers\Catalog\Product\CategoryController;
use App\Http\Controllers\Catalog\Checkout\CheckoutController;
use App\Http\Controllers\Admin\Common\AdminDashboardController;
use App\Http\Controllers\Admin\Setting\EcommerceLinkController;
use App\Http\Controllers\Admin\Storefront\AdminProductController;
use App\Http\Controllers\Admin\Storefront\AdminCategoryController;
use App\Http\Controllers\Catalog\Information\InformationController;
use App\Http\Controllers\Catalog\Information\ContactController;
use App\Http\Controllers\Admin\Storefront\ProductVariationController;
use App\Http\Controllers\Admin\Sales\OrderController as SalesOrderController;
use App\Http\Controllers\Catalog\Search\SearchController;

// Catalog
Route::name('catalog.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/product/{product_id}/{slug?}', [ProductController::class, 'productDetail'])->name('product-detail');
    Route::get('/products/{category_id?}/{category_slug?}', [ProductController::class, 'getAllProduct'])->name('product-all');
    Route::get('/category', [CategoryController::class, 'getAllCategories'])->name('getAllCategories');
    Route::get('/live-search', [SearchController::class, 'liveSearch'])->name('liveSearch');

    Route::get('/account', function () {
        return redirect()->route('catalog.user-login');
    });

    // Google Login
    Route::controller(GoogleController::class)->group(function(){
        Route::get('auth/google', 'redirectToGoogle')->name('googlelogin');
        Route::get('auth/google/callback', 'handleGoogleCallback');
    });

    Route::middleware('CatalogMiddlewareLogout')->group(function (){
        Route::prefix('account')->group(function (){
            Route::get('/login', [LoginController::class, 'index'])->name('user-login');
            Route::post('/login', [LoginController::class, 'login'])->name('user-login-account');
            Route::post('/register', [LoginController::class, 'register'])->name('user-register');
            Route::get('/verify-otp', [LoginController::class, 'verifyOtpPage'])->name('verifyOtpPage');
            Route::post('/registered-user-data', [LoginController::class, 'registeredUserData'])->name('registeredUserData');
            Route::get('/forgot-password', [LoginController::class, 'viewForgotPassword'])->name('viewForgotPassword');
            Route::post('/forgot-password', [LoginController::class, 'forgotPassword'])->name('forgotPassword');
            Route::get('/reset-password/{user_token?}', [LoginController::class, 'viewResetPassword'])->name('viewResetPassword');
            Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('resetPassword');
        });
    });
    
    Route::middleware('CatalogMiddlewareLogin')->group(function () {
        Route::get('/account/logout', [LoginController::class, 'logout'])->name('logout');

        Route::prefix('account')->group(function (){ 
            Route::get('/', [AccountController::class, 'index'])->name('front-user-account');
            Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
            Route::post('/profile', [AccountController::class, 'update'])->name('update-profile');
            Route::get('/change-password', [AccountController::class, 'viewChangePassword'])->name('viewChangePassword');
            Route::post('/change-password', [AccountController::class, 'changePassword'])->name('changePassword');
            
            Route::get('/order', [OrderController::class, 'index'])->name('order');
            Route::get('order-info/{order_id}', [OrderController::class, 'orderInfo'])->name('orderInfo');
            Route::get('get-order-history/{order_master_id}', [SalesOrderController::class, 'getOrderHistory'])->name('getOrderHistory');
            Route::get('invoice/{order_master_id}', [OrderController::class, 'invoice'])->name('invoice');

            Route::resource('/wishlist', WishlistController::class)->name('index','wishlist')->only('index', 'store', 'destroy');
            Route::resource('/address', AddressController::class)->name('index', 'address');
        });

        Route::prefix('checkout')->group(function (){
            Route::get('/cart',[CartController::class, 'index'])->name('cart');
            Route::post('/add-cart', [CartController::class, 'addCart'])->name('addCart');
            Route::get('/remove-cart/{product_id}/{color_id}/{size_id}/{product_name}', [CartController::class, 'removeCartProduct'])->name('removeCartProduct');
            Route::post('/increase-quantity', [CartController::class, 'increaseQunatity'])->name('increaseQunatity');
            Route::post('/decrease-quantity', [CartController::class, 'decreaseQunatity'])->name('decreaseQunatity');
            Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkoutIndex');
            Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
        });
    });

    Route::get('return-replacement-policy', [InformationController::class, 'privacyPolicy'])->name('privacyPolicy');
    Route::get('/aboutus', [InformationController::class, 'about'])->name('aboutus');
    Route::get('/contactus', [ContactController::class, 'show'])->name('contactus');
    Route::post('/contactus', [ContactController::class, 'submit']);
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews');
    Route::post('/review-replies', [ReviewReplyController::class, 'store'])->name('review-replies');
    
    


});

// Admin
Route::get('/admin', function () {
    return redirect()->route('admin-login');
});
Route::get('/admin/login', [AdminLoginController::class, 'index'])->name('admin-login')->middleware('AdminMiddlewareLogout');
Route::post('/admin/login', [AdminLoginController::class, 'AdminLogin'])->name('admin-login')->middleware('AdminMiddlewareLogout');
Route::post('/admin/logout', [AdminLoginController::class, 'adminLogout'])->name('admin-logout');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin-dashboard')->middleware('AdminMiddlewareLogin');

Route::middleware(['AdminMiddlewareLogin'])->prefix('admin/setting')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('admin-setting');
    Route::get('/ecommerce-links', [EcommerceLinkController::class, 'index'])->name('ecommerce-links');
    Route::post('/ecommerce-links-save', [EcommerceLinkController::class, 'save'])->name('ecommerce-links-save');
    Route::get('/site', [SiteController::class, 'index'])->name('site');
    Route::post('/site-save', [SiteController::class, 'save'])->name('site-save');
    Route::get('/general', [GeneralController::class, 'index'])->name('admin.general');
    Route::post('/general-save', [GeneralController::class, 'save'])->name('admin.generalSave');
});

Route::get('/admin/banner', [BannerController::class, 'index'])->name('admin-banner')->middleware('AdminMiddlewareLogin');
Route::post('/admin/banner', [BannerController::class, 'saveBanner'])->name('admin-banner')->middleware('AdminMiddlewareLogin');
Route::get('/admin/banner/getallbanner', [BannerController::class, 'getBanner'])->middleware('AdminMiddlewareLogin');
Route::get('/admin/banner/{banner_id}', [BannerController::class, 'getBannerById'])->middleware('AdminMiddlewareLogin');
Route::get('/admin/banner/delete/{banner_id}', [BannerController::class, 'deleteBanner'])->middleware('AdminMiddlewareLogin');

Route::middleware(['AdminMiddlewareLogin'])->prefix('admin/storefront')->group(function () {
    Route::get('product', [AdminProductController::class, 'index'])->name('admin-storefront-product');
    Route::get('product-form', [AdminProductController::class, 'form']);
    Route::post('product-save', [AdminProductController::class, 'save'])->name('admin-product-save');
    Route::get('product-edit/product_id={product_id}', [AdminProductController::class, 'editProduct'])->name("admin-product-edit");
    Route::post('product-update/product_id={product_id}', [AdminProductController::class, 'updateProduct'])->name("admin-product-update");
    Route::get('product-delete/product_id={product_id}', [AdminProductController::class, 'delete'])->name('admin-product-delete');
    Route::post('product-variation/', [ProductVariationController::class, 'addVariation'])->name('admin-addVariation');
    Route::get('product-get-variation/{product_id}', [ProductVariationController::class, 'getVariation'])->name('admin-getVariation');
    Route::post('deleteMultiSelection/', [AdminProductController::class, 'deleteMultiSelection']);
    
    Route::get('category/', [AdminCategoryController::class, 'index'])->name('category');
    Route::get('category-form/', [AdminCategoryController::class, 'form']);
    Route::post('category-save/', [AdminCategoryController::class, 'save'])->name('save-category');
    Route::get('category-edit/category_id={category_id}', [AdminCategoryController::class, 'edit'])->name('edit-category');
    Route::post('category-update/category_id={category_id}', [AdminCategoryController::class, 'update'])->name('update-category');
    Route::get('category-delete/category_id={category_id}', [AdminCategoryController::class, 'delete'])->name('delete-category');

    Route::get('color/', [ColorController::class, 'index'])->name('colors');
    Route::get('color-form',[ColorController::class, 'form']);
    Route::post('color-save',[ColorController::class, 'save'])->name('save-color');
    Route::get('color-edit/color_id={color_id}',[ColorController::class, 'edit'])->name('edit-color');
    Route::post('color-update/color_id={color_id}',[ColorController::class, 'update'])->name('update-color');
    Route::get('color-delete/color_id={color_id}',[ColorController::class, 'delete'])->name('delete-color');

    Route::get('size/', [SizeController::class, 'index'])->name('size');
    Route::get('size-form',[SizeController::class, 'form']);
    Route::post('size-save',[SizeController::class, 'save'])->name('save-size');
    Route::get('size-edit/size_id={size_id}',[SizeController::class, 'edit'])->name('edit-size');
    Route::post('size-update/size_id={size_id}',[SizeController::class, 'update'])->name('update-size');
    Route::get('size-delete/size_id={size_id}',[SizeController::class, 'delete'])->name('delete-size');
});

Route::get('/admin/media', [AdminMediaController::class, 'index'])->name('admin-media')->middleware('AdminMiddlewareLogin');
Route::post('/admin/media/uploadFile', [AdminMediaController::class, 'uploadFile'])->middleware('AdminMiddlewareLogin');
Route::get('/admin/media/getFiles', [AdminMediaController::class, 'getFiles'])->middleware('AdminMiddlewareLogin');
Route::post('/admin/media/createFolder', [AdminMediaController::class, 'createFolder'])->middleware('AdminMiddlewareLogin');
Route::post('/admin/media/delete', [AdminMediaController::class, 'delete'])->middleware('AdminMiddlewareLogin');

Route::middleware(['AdminMiddlewareLogin'])->prefix('admin/user')->group(function () {
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('user-form', [UserController::class, 'form'])->name('user-form');
    Route::get('user-edit/user_id={user_id}', [UserController::class, 'edit'])->name('user-edit');
    Route::post('user-save/{user_id?}', [UserController::class, 'save'])->name('user-save');
    Route::get('user-delete/{user_id}', [UserController::class, 'delete'])->name('user-delete');
    Route::post('deleteMultiSelection/', [UserController::class, 'deleteMultiSelection']);
});

Route::middleware(['AdminMiddlewareLogin'])->prefix('admin')->group(function(){
    Route::get('edit-profile', [ProfileController::class, 'editProfile'])->name('edit-profile');
    Route::post('save-profile', [ProfileController::class, 'saveProfile'])->name('save-profile');
    Route::get('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
    Route::post('save-password', [ProfileController::class, 'savePassword'])->name('save-password');
});


Route::middleware(['AdminMiddlewareLogin'])->prefix('admin/sales')->group(function(){
    Route::resource('order', SalesOrderController::class)->name('index', 'admin.order');
    Route::post('generate-invoice', [SalesOrderController::class, 'generateIncoice'])->name('admin.generateIncoice');
    Route::get('get-order-history/{order_master_id}', [SalesOrderController::class, 'getOrderHistory'])->name('admin.getOrderHistory');
});
