<?php
Route::get('work', function () {
    Artisan::command('down', function () {

    });
});
Auth::routes();
Route::get('sembe-bootstrap', 'Admin\BootstrapController@initApp');
Route::post('admin/login', 'AdminController@login');
Route::get('/pay', 'PaymentController@sendPayment');
Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', 'Admin\ChartController@index');
    Route::get('/products', 'AdminController@products')->name('products');
    Route::get('new-product', 'AdminController@newProduct');
    Route::post('post-product/', 'AdminController@postProduct');
    /*
     * User Routes
     */
    Route::get('new-user', 'UserController@index');
    Route::post('new-user', 'UserController@createUser');
    Route::get('all-users', 'UserController@allUsers')->name('users');
    Route::get('marketers', 'UserController@marketers');
    Route::get('shop-owners', 'UserController@users');
    Route::get('drivers', 'UserController@drivers');
    Route::get('admin', 'UserController@admin');
    Route::get('accountant', 'UserController@accountant');
    Route::get('production', 'UserController@production');
    Route::get('admin/user/{id}', 'UserController@user');

    Route::get('/user-edit/{id}', 'UserController@edit');
    Route::post('edit-user/{id}', 'UserController@editUser');
    Route::get('/user-profile/{id}', 'UserController@profile');

    Route::get('logout', 'UserController@logout');

    Route::get('send-sms', 'SmsUSSD@sendSms');

    /*
     * Production Manager
     */
    Route::get('daily-production', 'ProductionManager@getProducts');
    Route::post('daily-production', 'ProductionManager@addProducts');


});
/*
 * Orders
 */
Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/orders', 'OrderController@orders');
    Route::get('/order/{id}', 'OrderController@order');
    Route::get('/orders/canceled', 'OrderController@canceled');
    Route::get('/orders/delivered', 'OrderController@delivered');
    Route::get('/orders/pending', 'OrderController@pending');
    Route::post('/cancel/order/{id}', 'OrderController@cancelOrder');
    Route::get('/revert/order/{id}', 'OrderController@revertOrderCancellation');
    Route::post('/assign/order/{id}', 'OrderController@assignOrder');

    Route::get('/dispatch/items/{id}', 'OrderController@massDispatch');
    Route::get('/dispatch/item/{id}', 'OrderController@dispatchSingleItem');
    Route::get('/revert/item/{id}', 'OrderController@revertItem');

    /*
     * Business Orders
     */
    Route::get('/business/orders/{id}', 'OrderController@businessOrders');

});
/*
 * Categories
 */
Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/categories', 'CategoriesController@categories');
    Route::post('/category', 'CategoriesController@createCategory');
    Route::post('/edit/category/{id}', 'CategoriesController@editCategory');
    Route::get('/category/delete/{id}', 'CategoriesController@deleteCategory');
    Route::get('category/products/{id}', 'CategoriesController@categoryProducts');
});
/*
 * Product Actions
 */
Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/product/{id}', 'ProductController@product');
    Route::post('product/edit/{id}', 'ProductController@update');
    Route::get('product/delete/{id}', 'ProductController@destroy');

    /*
     * Profile
     */
    Route::get('profile/{id}', 'ProfileController@index');
    Route::post('profile/{id}', 'ProfileController@update');

    /*
     *
     */
    Route::get('system-logs', 'BootstrapController@logs');
    /*
     * Analytics
     */
    Route::get('/analytics/users', 'ChartController@usersChart');
    Route::get('/analytics/sales', 'ChartController@salesChart');
    /*
     * Students
     *
     */

    Route::get('students', 'JijengeController@students')->name('students');
    Route::get('verified/students', 'JijengeController@verified')->name('verified/students');
    Route::get('students/pending/verification', 'JijengeController@unverified')->name('pending/students');
    Route::get('student/{id}', 'JijengeController@student');
    Route::get('verify/student/{id}', 'JijengeController@verify');
    Route::get('unverify/student/{id}', 'JijengeController@unverify');
    Route::get('students/download/data/{id}', 'JijengeController@downloadFile');


    // mpesa


});
