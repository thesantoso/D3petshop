<?php

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

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'front::',
    'namespace' => 'Front',
], function() {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/products', 'ProductController@index')->name('products.index');
    Route::get('/products/{slug}', 'ProductController@show')->name('products.show');

    Route::get('/cart', 'CartController@items')->name('cart.items');
    Route::post('/cart/add', 'CartController@add')->name('cart.add');
    Route::post('/cart/update', 'CartController@update')->name('cart.update');
    Route::post('/cart/delete', 'CartController@delete')->name('cart.delete');

    Route::get('/login', 'LoginController@form')->name('login.form');
    Route::post('/login', 'LoginController@submit')->name('login.submit');
    Route::get('/logout', 'LoginController@logout')->name('logout');

    Route::get('/register', 'RegisterController@form')->name('register.form');
    Route::post('/register', 'RegisterController@submit')->name('register.submit');

    Route::get('/region/provinces', 'RegionController@provinces')->name('region.provinces');
    Route::get('/region/regencies', 'RegionController@regencies')->name('region.regencies');
    Route::get('/region/districts', 'RegionController@districts')->name('region.districts');
    Route::get('/region/subdistricts', 'RegionController@subdistricts')->name('region.subdistricts');

    Route::get('/shipping-cost/{regency_id}', 'ShippingCostController@cost')->name('shipping-cost.cost');

    Route::group([
        'middleware' => 'member',
    ], function() {
        Route::get('/checkout', 'CheckoutController@form')->name('checkout.form');
        Route::post('/checkout', 'CheckoutController@submit')->name('checkout.submit');
        Route::get('/checkout/success/{order_code}', 'CheckoutController@success')->name('checkout.success');

        Route::post('/rating', 'RatingController@rating')->name('rating');

        Route::get('/confirm-payment', 'PaymentConfirmationController@form')->name('payment-confirmation.form');
        Route::post('/confirm-payment', 'PaymentConfirmationController@submit')->name('payment-confirmation.submit');
        Route::get('/confirm-payment/success', 'PaymentConfirmationController@success')->name('payment-confirmation.success');

        Route::get('/account', 'AccountController@index')->name('account.index');
        Route::get('/account/change-password', 'AccountController@changePassword')->name('account.change-password');
        Route::post('/account/change-password', 'AccountController@submitChangePassword')->name('account.submit-change-password');
        Route::get('/account/orders', 'AccountController@orders')->name('account.orders');
        Route::get('/account/orders/{id}', 'AccountController@orderDetail')->name('account.order-detail');

        Route::get('/account/addresses', 'MemberAddressController@index')->name('member-address.index');
        Route::get('/account/addresses/all', 'MemberAddressController@all')->name('member-address.all');
        Route::get('/account/addresses/find/{id}', 'MemberAddressController@find')->name('member-address.find');
        Route::post('/account/addresses/add', 'MemberAddressController@add')->name('member-address.add');
        Route::post('/account/addresses/set-default/{id}', 'MemberAddressController@setDefault')->name('member-address.set-default');
        Route::post('/account/addresses/update/{id}', 'MemberAddressController@update')->name('member-address.update');
        Route::post('/account/addresses/delete/{id}', 'MemberAddressController@delete')->name('member-address.delete');
    });
});

Route::group([
    'prefix' => '/admin',
    'as' => 'admin::',
    'namespace' => 'Admin',
], function() {
    Route::get('/login', 'LoginController@form')->name('login.form');
    Route::post('/login', 'LoginController@submit')->name('login.submit');
    Route::get('/logout', 'LoginController@logout')->name('logout');

    Route::group([
        'middleware' => 'admin',
    ], function() {
        Route::get('/', 'DashboardController@index')->name('dashboard.index');

        // CRUD BUKU
        Route::get('/products', 'ProductController@index')->name('products.index');
        Route::get('/products/create', 'ProductController@create')->name('products.create');
        Route::post('/products/create', 'ProductController@store')->name('products.store');
        Route::get('/products/edit/{id}', 'ProductController@edit')->name('products.edit');
        Route::post('/products/edit/{id}', 'ProductController@update')->name('products.update');
        Route::post('/products/delete/{id}', 'ProductController@delete')->name('products.delete');

        // CRUD User
        Route::get('/users', 'UserController@index')->name('users.index');
        Route::get('/users/create', 'UserController@create')->name('users.create');
        Route::post('/users/create', 'UserController@store')->name('users.store');
        Route::get('/users/edit/{id}', 'UserController@edit')->name('users.edit');
        Route::post('/users/edit/{id}', 'UserController@update')->name('users.update');
        Route::post('/users/delete/{id}', 'UserController@delete')->name('users.delete');

        // CRUD KATEGORI
        Route::get('/categories', 'CategoryController@index')->name('categories.index');
        Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
        Route::post('/categories/create', 'CategoryController@store')->name('categories.store');
        Route::get('/categories/edit/{id}', 'CategoryController@edit')->name('categories.edit');
        Route::post('/categories/edit/{id}', 'CategoryController@update')->name('categories.update');
        Route::post('/categories/delete/{id}', 'CategoryController@delete')->name('categories.delete');

        // KELOLA PESANAN
        Route::get('/orders', 'OrderController@index')->name('orders.index');
        Route::get('/orders/{id}', 'OrderController@show')->name('orders.show');
        Route::post('/orders/set-status/{id}', 'OrderController@setStatus')->name('orders.set-status');
        Route::post('/orders/delete/{id}', 'OrderController@delete')->name('orders.delete');
    });
});

Route::get('/dev', 'DevController@index');
Route::post('/dev/ratings', 'DevController@submitRatings');
Route::post('/dev/ratings/reset', 'DevController@resetRatings');
Route::get('/dev/pearson-correlation', 'DevController@pearsonCorrelation');
Route::get('/dev/prediction', 'DevController@prediction');
