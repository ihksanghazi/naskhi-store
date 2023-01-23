<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\DashboardTransactionController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductGalleryController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\CheckoutController;

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

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/products', [ProductController::class,'index'])->name('products');
Route::get('/detail/{product:slug}/{id}', [DetailController::class,'index'])->name('detail');
Route::post('/detail/{id}', [DetailController::class,'add'])->name('detail-add');

Route::post('/checkout/callback', [CheckoutController::class,'callback'])->name('midtrans-callback');

Route::get('/success', [CartController::class,'success'])->name('success');

Route::get('/register/success', [RegisterController::class,'success'])->name('register-success');


Route::group(['middleware' => ['auth']], function(){
  
  Route::get('/cart', [CartController::class,'index'])->name('cart');
  Route::delete('/cart/{cart:id}', [CartController::class,'delete'])->name('cart-delete');

  Route::post('/checkout', [CheckoutController::class,'process'])->name('checkout');

  Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
  Route::get('/dashboard/products', [DashboardProductController::class,'index'])->name('dashboard-product');
  Route::get('/dashboard/products/create', [DashboardProductController::class, 'create'])->name('dashboard-product-create');
  Route::post('/dashboard/products/', [DashboardProductController::class, 'store'])->name('dashboard-product-store');
  Route::get('/dashboard/products/{product:id}', [DashboardProductController::class,'detail'])->name('dashboard-product-detail');
  Route::post('/dashboard/products/{product:id}', [DashboardProductController::class,'update'])->name('dashboard-product-update');
  
  Route::post('/dashboard/products/gallery/upload', [DashboardProductController::class,'uploadGallery'])->name('dashboard-product-gallery-upload');
  Route::delete('/dashboard/products/gallery/delete/{product_gallery:id}', [DashboardProductController::class,'deleteGallery'])->name('dashboard-product-gallery-delete');
  Route::get('/dashboard/transactions', [DashboardTransactionController::class,'index'])->name('dashboard-transaction');
  Route::get('/dashboard/transactions/{transactionDetail:id}', [DashboardTransactionController::class,'detail'])->name('dashboard-transaction-detail');
  Route::post('/dashboard/transactions/{transactionDetail:id}', [DashboardTransactionController::class,'update'])->name('dashboard-transaction-update');

  Route::get('/dashboard/setting', [DashboardSettingController::class,'store'])->name('dashboard-setting-store');
  Route::get('/dashboard/account', [DashboardSettingController::class,'account'])->name('dashboard-setting-account');
  Route::post('/dashboard/account/{redirect}', [DashboardSettingController::class,'update'])->name('dashboard-setting-redirect');

  Route::post('/dashboard/profile/photo', [DashboardSettingController::class,'uploadPhoto'])->name('dashboard-setting-photo');

});

Route::prefix('admin')
  ->middleware(['auth','admin'])
  ->group(function(){
    Route::get('/', [AdminDashboardController::class,'index'])->name('admin-dashboard');
    Route::resource('category', AdminCategoryController::class);
    Route::resource('user', AdminUserController::class);
    Route::resource('product', AdminProductController::class);
    Route::resource('product-gallery', AdminProductGalleryController::class);
  });


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
