<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SubFeaturesController;
use App\Http\Controllers\Admin\SubPlanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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



Route::prefix('admin')->group(function() {
  //------------ ADMIN LOGIN SECTION ------------

  Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('admin.login');
  Route::post('/login',[LoginController::class, 'login'])->name('admin.login.submit');
  Route::get('/forgot',[LoginController::class, 'showForgotForm'])->name('admin.forgot');
  Route::post('/forgot',[LoginController::class, 'forgot'])->name('admin.forgot.submit');
  Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
  

  Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

  Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
  Route::post('/profile/update',[AdminController::class, 'profileupdate'] )->name('admin.profile.update');


 // Vendor Social
  Route::get('/social', [AdminController::class, 'social'])->name('admin.social');
  Route::post('/social/update',[AdminController::class, 'socialupdate'])->name('admin.social.update');

  Route::get('/generalsettings',[AdminController::class, 'generalsettings'])->name('admin.generalsettings');
  Route::post('/generalsettings',[AdminController::class, 'generalsettingsupdate'])->name('admin.generalsettings.update');
  
  Route::get('/password/',[AdminController::class, 'passwordreset'])->name('admin.password');
  Route::post('/password/update',[AdminController::class, 'changepass'])->name('admin.password.update');



  Route::get('/subplan/datatables',[SubPlanController::class, 'datatables'])->name('admin.subplan.datatables');
  Route::get('/subplan',[SubPlanController::class, 'index'])->name('admin.subplan.index');
  Route::get('/subplan/create', [SubPlanController::class, 'create'])->name('admin.subplan.create');
  Route::post('/subplan/create',[SubPlanController::class, 'store'])->name('admin.subplan.store');
  Route::get('/subplan/edit/{id}',[SubPlanController::class, 'edit'])->name('admin.subplan.edit');
  Route::post('/subplan/edit/{id}', [SubPlanController::class, 'update'])->name('admin.subplan.update');
  Route::get('/subplan/delete/{id}',[SubPlanController::class, 'destroy'])->name('admin.subplan.delete');
  Route::get('/subplan/status/{id1}/{id2}',[SubPlanController::class, 'status'])->name('admin.subplan.status');

  
  Route::get('/subfeatures/datatables',[SubFeaturesController::class, 'datatables'])->name('admin.subfeature.datatables');
  Route::get('/subfeature',[SubFeaturesController::class, 'index'])->name('admin.subfeature.index');
  Route::get('/subfeatures/create', [SubFeaturesController::class, 'create'])->name('admin.subfeature.create');
  Route::post('/subfeatures/create',[SubFeaturesController::class, 'store'])->name('admin.subfeature.store');
  Route::get('/subfeatures/edit/{id}',[SubFeaturesController::class, 'edit'])->name('admin.subfeature.edit');
  Route::post('/subfeatures/edit/{id}', [SubFeaturesController::class, 'update'])->name('admin.subfeature.update');
  Route::get('/subfeatures/delete/{id}',[SubFeaturesController::class, 'destroy'])->name('admin.subfeature.delete');
  Route::get('/subfeatures/status/{id1}/{id2}',[SubFeaturesController::class, 'status'])->name('admin.subfeature.status');
  

  Route::get('/category/datatables',[CategoryController::class, 'datatables'])->name('admin.category.datatables');
  Route::get('/category',[CategoryController::class, 'index'])->name('admin.category.index');
  Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
  Route::post('/category/create',[CategoryController::class, 'store'])->name('admin.category.store');
  Route::get('/category/edit/{id}',[CategoryController::class, 'edit'])->name('admin.category.edit');
  Route::post('/category/edit/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
  Route::get('/category/delete/{id}',[CategoryController::class, 'destroy'])->name('admin.category.delete');
  Route::get('/category/status/{id1}/{id2}',[CategoryController::class, 'status'])->name('admin.category.status');



  Route::get('/listing/datatables',[App\Http\Controllers\Admin\ProductController::class, 'datatables'])->name('admin.product.datatables');
  Route::get('/listing',[App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.product.index');

  Route::get('/listing/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.product.create');
  Route::post('/listing/create',[App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.product.store');

  Route::get('/listing/import', [App\Http\Controllers\Admin\ProductController::class, 'createImport'])->name('admin.product.import.create');
  Route::post('/listing/import',[App\Http\Controllers\Admin\ProductController::class, 'importSubmit'])->name('admin.product.import.store');

  Route::get('/listing/edit/{id}',[App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.product.edit');
  Route::post('/listing/edit/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.product.update');
  Route::get('/listing/delete/{id}',[App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.product.delete');
  Route::get('/listing/status/{id1}/{id2}',[App\Http\Controllers\Admin\ProductController::class, 'status'])->name('admin.product.status');

  Route::get('/users/datatables',[App\Http\Controllers\Admin\UserController::class, 'usersDataTables'])->name('admin.users.datatables');
  Route::get('/users',[App\Http\Controllers\Admin\UserController::class, 'users'])->name('admin.users.index');

  Route::get('/subscribed/users/datatables',[App\Http\Controllers\Admin\UserController::class, 'subscribedusersDataTables'])->name('admin.users.subscribed.datatables');
  Route::get('/subscribed/users',[App\Http\Controllers\Admin\UserController::class, 'subscribedusers'])->name('admin.users.subscribed.index');

    Route::get('/users/transactions/datatables/{id?}',[App\Http\Controllers\Admin\UserController::class, 'userstransactionsDataTables'])->name('admin.users.transactions.datatables');
  Route::get('/users/transactions/{id?}',[App\Http\Controllers\Admin\UserController::class, 'userstransactions'])->name('admin.users.transactions.index');

});

Route::prefix('user')->group(function() {

  Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');

  // User Password Reset 
  Route::post('/reset',[App\Http\Controllers\User\DashboardController::class, 'reset'])->name('user.reset.submit');
  // User Profile

  Route::get('/profile',[App\Http\Controllers\User\DashboardController::class, 'profile'])->name('user.profile');
  Route::post('/profile',[App\Http\Controllers\User\DashboardController::class, 'profileupdate'])->name('user.profile.update');
  
  Route::get('/earnings/datatables',[App\Http\Controllers\User\EarningController::class, 'datatables'])->name('user.earnings.datatables');
  Route::get('/earnings',[App\Http\Controllers\User\EarningController::class, 'index'])->name('user.earnings');


    // Add Stripe Payouts Gateway
  Route::get('/add/payment/gateway',[App\Http\Controllers\User\EarningController::class, 'addPayGateway'])->name('user.addpayment.gateway');
  Route::get('/return/payment/gateway/status',[App\Http\Controllers\User\EarningController::class, 'returnConnectStatus'])->name('user.returnpayment.gateway.status');
  Route::get('/send/payment/user',[App\Http\Controllers\User\EarningController::class, 'sendPayUser'])->name('user.sendpayment');


  //Route::post('/profile',[App\Http\Controllers\User\DashboardController::class, 'profileupdate'])->name('user.profile.update');

  // Route::get('/product/datatables',[App\Http\Controllers\User\ProductController::class, 'datatables'])->name('user.product.datatables');

  // Route::get('/product',[App\Http\Controllers\User\ProductController::class, 'index'])->name('user.product.index');

  // Route::get('/product/create', [App\Http\Controllers\User\ProductController::class, 'create'])->name('user.product.create');
  // Route::post('/product/create',[App\Http\Controllers\User\ProductController::class, 'store'])->name('user.product.store');

  // Route::get('/product/import', [App\Http\Controllers\User\ProductController::class, 'createImport'])->name('user.product.import.create');
  // Route::post('/product/import',[App\Http\Controllers\User\ProductController::class, 'storeImport'])->name('user.product.import.store');

  // Route::get('/product/edit/{id}',[App\Http\Controllers\User\ProductController::class, 'edit'])->name('user.product.edit');
  // Route::post('/product/edit/{id}', [App\Http\Controllers\User\ProductController::class, 'update'])->name('user.product.update');
  // Route::get('/product/delete/{id}',[App\Http\Controllers\User\ProductController::class, 'destroy'])->name('user.product.delete');
  // Route::get('/product/status/{id1}/{id2}',[App\Http\Controllers\User\ProductController::class, 'status'])->name('user.product.status');

});


  // User Auth Routes
  Route::get('/login',[App\Http\Controllers\User\LoginController::class, 'showLoginForm'])->name('user.login');
  Route::post('/login', [App\Http\Controllers\User\LoginController::class, 'login'])->name('user.login.submit');
  Route::get('/logout', [App\Http\Controllers\User\LoginController::class, 'logout'])->name('user.logout');

  Route::get('/register',[App\Http\Controllers\User\RegisterController::class, 'showRegisterForm'])->name('user.register');
  Route::post('/register',[App\Http\Controllers\User\RegisterController::class, 'register'])->name('user.register.submit');

  Route::get('/forgot',[App\Http\Controllers\User\ForgotController::class, 'showForgotForm'])->name('user.forgot');
  Route::post('/forgot',[App\Http\Controllers\User\ForgotController::class, 'forgot'])->name('user.forgot.submit');

    Route::get('/reset-password/{token}',[App\Http\Controllers\User\ForgotController::class, 'getPassword'])->name('user.password.rreset');
  Route::post('/reset-password',[App\Http\Controllers\User\ForgotController::class, 'updatePassword'])->name('user.password.rreset.sub');
  // User Auth Routes ends

  //Website Routes
  Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index'])->name('front.index');

  Route::get('/category', [App\Http\Controllers\Front\ProductController::class, 'category'])->name('front.category');
  Route::get('/category/{category}', [App\Http\Controllers\Front\ProductController::class, 'categorydetail'])->name('front.category.detail');

  Route::get('/product/{slug}', [App\Http\Controllers\Front\ProductController::class, 'productdetail'])->name('front.product.detail');

  // Stripe & Subscription Routes
  Route::get('/pricing', [App\Http\Controllers\Front\StripeController::class, 'pricing'])->name('front.pricing');
  Route::get('/subscription/{id}', [App\Http\Controllers\Front\StripeController::class, 'pricingDetails'])->name('front.subplan.detail');
  Route::get('/subscription/cancel/{id}', [App\Http\Controllers\Front\StripeController::class, 'subplanCancel'])->name('front.subplan.cancel');
  Route::post('/subscription/{id}', [App\Http\Controllers\Front\StripeController::class, 'activateplan'])->name('front.subplan.submit');

  // Stripe Webhook
  Route::post('stripe/webhook',[App\Http\Controllers\Front\StripeWebHookController::class, 'handleWebhook']);



  // // User Reset
  // Route::get('/reset',[App\Http\Controllers\User\DashboardController::class, 'resetform'])->name('user.reset');




// Auth::routes();


//Language Translation
// Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// Route::get('/user', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// //Update User Details
// Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
// Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


