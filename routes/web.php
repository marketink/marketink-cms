<?php

use App\Http\Controllers\Auth\VerifyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Profile\AddressController;
use App\Http\Controllers\Profile\HomeController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [App\Http\Controllers\SiteController::class, 'index']);

Route::post('comment/{id}', [App\Http\Controllers\SiteController::class, 'postComment'])->middleware('auth')->name('comment.post');
Route::get("home", [HomeController::class, 'index'])->name('home')->middleware(["auth"]);

Auth::routes();

Route::prefix("/")
    ->controller(VerifyController::class)
    ->group(function () {
        Route::post('/verify-forget-password', 'verifyAndReset')->name("verifyAndReset");
        Route::post("/send-verification", "sendCode")->name("sendVerificationCode");
        Route::post("/verify-account", "verifyAccount")->name("verifyAccount");
    });

Route::prefix("profile")
    ->middleware(["auth"])
    ->group(function () {
        Route::prefix("/")
            ->controller(HomeController::class)
            ->group(function () {
                Route::get("/", "index")->name("profile");
                Route::post("/update", "update")->name('profile.update');
                Route::post("/update-password", "updatePassword")->name("user.update.password");
            });
        Route::prefix("address")
            ->controller(AddressController::class)
            ->group(function () {
                Route::get("/", "index")->name("user.address");
                Route::delete("/{id}", "delete")->name("user.address.delete");
                Route::post("/", "store")->name("user.address.store");
            });
        Route::prefix("orders")
            ->controller(OrderController::class)
            ->group(function () {
                Route::get("/current-cart", "getCurrentCart")->name("current.cart");
                Route::post("/current-cart", "postCurrentCart")->name("current.cart.post");
                Route::get("/", "index")->name("user.orders");
                Route::get("/{id}", "show")->name("user.orders.show");
                Route::delete('/remove-orders', 'deleteAllOrders')->name('deleteAllOrders');
                Route::post('/', 'create')->name('addNewOrder');
                Route::delete('/{id}', 'delete')->name('deleteOrder');
                Route::patch('/{id}/{key}}', 'updateField')->name('updateCart');
            });
    });

Route::prefix("payments")
    ->controller(PaymentController::class)
    ->group(function () {
        Route::any("/initiate", "initiate")->name("payments.initiate");
        Route::any("/verify", "verify")->name("payment.verify");
    });

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'admin'],
    'name' => 'admin.*'
], function () {
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'home'])->name('dashboard');
    Route::get('dashboard/contents/{type}', [App\Http\Controllers\Admin\DashboardController::class, 'contents'])->name('dashboard.contents');
    Route::get('dashboard/users', [App\Http\Controllers\Admin\DashboardController::class, 'users'])->name('dashboard.users');
    Route::delete('dashboard/contents/relations', [App\Http\Controllers\Admin\DashboardController::class, 'deleteRelation'])->name('dashboard.relations.destroy');
    Route::get('dashboard/setting', [App\Http\Controllers\Admin\DashboardController::class, 'setting'])->name('dashboard.setting');
    Route::post('dashboard/setting', [App\Http\Controllers\Admin\DashboardController::class, 'postSetting'])->name('dashboard.postSetting');
    Route::get('dashboard/carts', [App\Http\Controllers\Admin\DashboardController::class, 'carts'])->name('dashboard.carts');

    Route::group([
        'prefix' => 'api',
        'middleware' => ['api']
    ], function () {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class)->only([
            'index',
            'store',
            'show',
            'update',
            'destroy'
        ]);
        Route::resource('contents', App\Http\Controllers\Admin\ContentController::class)->only([
            'index',
            'store',
            'show',
            'update',
            'destroy'
        ]);
        Route::resource('files', App\Http\Controllers\Admin\FileController::class)->only([
            'store',
            'destroy'
        ]);
        Route::resource('carts', App\Http\Controllers\Admin\CartController::class)->only([
            'index',
            'show',
            'update'
        ]);
    });

});

Route::get('/{type}/{path?}', [App\Http\Controllers\SiteController::class, 'contents'])->where('path', '.*');