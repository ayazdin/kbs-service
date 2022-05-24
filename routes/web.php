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


// web.php
//can add file for routes
//Route::prefix('admin')->group(base_path('routes/admin.php'));

// Switch between the included languages
Route::get('lang/{lang}', 'LanguageController@swap');

Route::get('/test', function () {
    return view('test');
});

Route::prefix('admin')->namespace('Auth\Admin')->group(function(){
  Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
  Route::post('login', 'LoginController@login');
  Route::post('logout', 'LoginController@logout')->name('admin.logout');
});

Auth::routes();
Route::get('/', 'HomeController@index')->name('admin.dashboard')->middleware('auth:admin');


//Route::get('/', 'HomeController@index')->name('user.dashboard')->middleware('auth:user');
Route::get('/user/dashboard', 'HomeController@index')->name('user.dashboard')->middleware('auth:user');
Route::get('/products', 'HomeController@getProductList')->name('user.getProductList')->middleware('auth:user');
Route::get('/product/{slug}', 'HomeController@getProductDetail')->name('user.getProductDetail')->middleware('auth:user');
Route::get('/category/{slug}', 'HomeController@getProductList')->name('user.getProductList')->middleware('auth:user');
Route::get('/supplier/{id}', 'HomeController@getProductList')->name('user.getProductList')->middleware('auth:user');
Route::post('/product/get-product-details', 'HomeController@getProductDetails')->name('user.getProductDetails')->middleware('auth:user');
Route::post('/product/add-to-cart', 'CartController@storeCart')->name('user.storeCart')->middleware('auth:user');
Route::get('/contact', 'HomeController@getContactPage')->name('user.contact')->middleware('auth:user');
Route::get('/cart/remove/{id}', 'CartController@removeCart')->name('user.removeCart')->middleware('auth:user');
Route::get('/cart', 'CartController@getCart')->name('user.getCart')->middleware('auth:user');
Route::post('/cart/change-quantity', 'CartController@getQuantityChanged')->name('user.getQuantityChanged')->middleware('auth:user');
Route::get('/checkout', 'CartController@getCheckout')->name('user.getCheckout')->middleware('auth:user');

//Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard')->middleware('auth:admin');
//Route::get('/admin/login', 'Auth\LoginController@showAdminLoginForm')->name('showAdminLoginForm');
//Route::post('/admin/login', 'Auth\LoginController@adminLogin')->name('adminLogin');
//Route::get('/admin/logout', 'AdminController@logout')->name('adminlogout');
//Route::post('/login', 'Auth\LoginController@customerLogin')->name('customerLogin');
//Route::get('/customer/dashboard', 'AdminController@customerDashboard')->name('customerDashboard')->middleware('auth');




//Route::get('/admin/user/list', 'UserController@index')->name('userlist')->middleware('auth');
Route::prefix('/admin/user/')->group(function () {
    Route::get('list', 'UserController@index')->name('userlist')->middleware('auth:admin');
    Route::get('add', 'UserController@createUser')->name('createuser')->middleware('auth:admin');
    Route::get('edit/{id}', 'UserController@createUser')->name('createuser')->middleware('auth:admin');
    Route::post('store', 'UserController@store')->name('store')->middleware('auth:admin');
    Route::get('delete/{id}', 'UserController@delete')->name('delete')->middleware('auth:admin');
});

Route::prefix('/admin/supplier/')->group(function () {
    Route::get('list', 'SupplierController@index')->name('supplierlist')->middleware('auth:admin');
    Route::get('add', 'SupplierController@createSupplier')->name('createsupplier')->middleware('auth:admin');
    Route::get('edit/{id}', 'SupplierController@createSupplier')->name('createsupplier')->middleware('auth:admin');
    Route::post('store', 'SupplierController@store')->name('store')->middleware('auth:admin');
    Route::get('delete/{id}', 'SupplierController@delete')->name('delete')->middleware('auth:admin');
});

Route::prefix('/admin/race/')->group(function () {
    Route::get('list-racers', 'RaceController@index')->name('racerlist')->middleware('auth:admin');
    Route::get('add', 'UserController@createUser')->name('createuser')->middleware('auth:admin');
    Route::get('edit/{id}', 'UserController@createUser')->name('createuser')->middleware('auth:admin');
    Route::post('store', 'UserController@store')->name('store')->middleware('auth:admin');
    Route::get('delete/{id}', 'UserController@delete')->name('delete')->middleware('auth:admin');
});

Route::prefix('/admin/product/')->group(function () {
    Route::get('list', 'ProductController@index')->name('productList')->middleware('auth:admin');
    Route::get('add', 'ProductController@createProduct')->name('createProduct')->middleware('auth:admin');
    Route::get('edit/{id}', 'ProductController@createProduct')->name('createProduct')->middleware('auth:admin');
    Route::get('copy/{id}', 'ProductController@copyProduct')->name('copyProduct')->middleware('auth:admin');
    Route::post('store', 'ProductController@storeProduct')->name('storeProduct')->middleware('auth:admin');
    Route::get('delete/{id}', 'ProductController@delete')->name('delete')->middleware('auth:admin');
    Route::get('delete-image/{id}', 'ProductController@deleteImage')->name('deleteImage')->middleware('auth:admin');
    Route::post('updatefield', 'ProductController@ajaxUpdateField')->name('ajaxUpdateField')->middleware('auth:admin');
    Route::post('updatevalue', 'ProductController@ajaxUpdateValue')->name('ajaxUpdateValue')->middleware('auth:admin');
    Route::post('deletevalue', 'ProductController@ajaxDeleteValue')->name('ajaxDeleteValue')->middleware('auth:admin');
    Route::post('deletefield', 'ProductController@ajaxDeleteField')->name('ajaxDeleteField')->middleware('auth:admin');
    Route::post('store-inventory', 'ProductController@ajaxStoreInventory')->name('ajaxStoreInventory')->middleware('auth:admin');
    Route::post('get-purchase-order', 'ProductController@ajaxGetPurchaseOrder')->name('ajaxGetPurchaseOrder')->middleware('auth:admin');
});

Route::prefix('/admin/purchase/')->group(function () {
  Route::post('get-purchase-order', 'ProductController@ajaxGetPurchaseOrder')->name('ajaxGetPurchaseOrder')->middleware('auth:admin');
  Route::get('list-purchase/{id}', 'ProductController@getAllPurchase')->name('getAllPurchase')->middleware('auth:admin');
  Route::get('delete/{lot}', 'ProductController@deletePurchase')->name('deletePurchase')->middleware('auth:admin');
  Route::get('delete-item/{pid}', 'ProductController@deletePurchaseItem')->name('deletePurchaseItem')->middleware('auth:admin');
  Route::get('order', 'OrderController@orderList')->name('orderList')->middleware('auth:admin');
  Route::get('purchase-list', 'ProductController@getPurchaseList')->name('getPurchaseList')->middleware('auth:admin');
  Route::get('purchase-detail/{lot}', 'ProductController@getPurchaseDetail')->name('getPurchaseDetail')->middleware('auth:admin');
  Route::get('purchase-order', 'ProductController@getPurchaseOrder')->name('getPurchaseOrder')->middleware('auth:admin');
  Route::post('purchase-order', 'ProductController@setPurchaseOrder')->name('setPurchaseOrder')->middleware('auth:admin');
  Route::post('change-quantity', 'ProductController@changePurchaseQuantity')->name('changePurchaseQuantity')->middleware('auth:admin');
});

Route::prefix('/admin/accounts/')->group(function () {
    Route::get('list-customers', 'AccountController@getAllCustomers')->name('getAllCustomers')->middleware('auth:admin');
    Route::post('customer-trans', 'AccountController@setCustomerTransaction')->name('setCustomerTransaction')->middleware('auth:admin');
    Route::get('customer/{id}', 'AccountController@getCustomerDetail')->name('getCustomerDetail')->middleware('auth:admin');
});

Route::prefix('/admin/orders/')->group(function () {
  Route::get('list', 'OrderController@index')->name('orderList')->middleware('auth:admin');
  Route::get('add', 'OrderController@placeOrder')->name('placeOrder')->middleware('auth:admin');
  Route::get('edit/{id}', 'OrderController@placeOrder')->name('placeOrder')->middleware('auth:admin');
  Route::post('store', 'OrderController@storeOrder')->name('storeOrder')->middleware('auth:admin');
  Route::get('delete/{id}', 'OrderController@deleteOrder')->name('deleteOrder')->middleware('auth:admin');
  Route::get('view-order/{oid}', 'OrderController@viewOrder')->name('viewOrder')->middleware('auth:admin');
  //Route::get('complete/{oid}', 'OrderController@statusChangedDone')->name('statusChangedDone')->middleware('auth:admin');
  Route::get('change-status/{oid}/{status}', 'OrderController@statusChanged')->name('statusChanged')->middleware('auth:admin');
  Route::post('change-quantity', 'CartController@getQuantityChanged')->name('getQuantityChanged')->middleware('auth:admin');
});

Route::prefix('/admin/sales/')->group(function () {
  Route::get('list', 'OrderController@salesList')->name('salesList')->middleware('auth:admin');
});

Route::prefix('/admin/ajax/')->group(function () {
    Route::get('list', 'ProductController@index')->name('productList')->middleware('auth:admin');
});

Route::prefix('/admin/category/')->group(function () {
    Route::get('', 'CategoryController@index')->name('categorylist')->middleware('auth:admin');
    Route::get('add', 'CategoryController@createCategory')->name('createCategory')->middleware('auth:admin');
    Route::get('edit/{id}', 'CategoryController@createCategory')->name('createCategory')->middleware('auth:admin');
    Route::post('store', 'CategoryController@store')->name('store')->middleware('auth:admin');
    Route::get('delete/{id}', 'CategoryController@delete')->name('delete')->middleware('auth:admin');
});
