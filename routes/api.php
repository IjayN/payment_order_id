<?php
$api = app('Dingo\Api\Routing\Router');
/*
 * Auth
 */
$api->version('v1' , ['namespace' => 'App\Http\Controllers\Api\Auth' , 'middleware' => 'api'] , function ($api) {
	$api->post('/auth/login' , 'AuthController@login');
	$api->post('/auth/register' , 'AuthController@register');
	$api->post('/auth/logout' , 'AuthController@logout')->middleware('jwt.auth');
	$api->post('/auth/validate' , 'AuthController@validateOtp')->middleware('jwt.auth');
	$api->post('/auth/update' , 'AuthController@update')->middleware(['jwt.auth' , 'otp']);
	$api->post('/auth/reset-token', 'AuthController@initResetPassword');
	$api->post('/auth/reset-password', 'AuthController@resetPassword');
	$api->get('/auth/user/authenticated', 'AuthController@checkAuth');

});

$api->version('v1' , ['namespace' => 'App\Http\Controllers\Api' , 'middleware' => ['api' , 'jwt.auth' , 'otp']] , function ($api) {
	/*
	 * Products
	 */
	$api->post('products' , 'ProductController@products');
	$api->post('products/category' , 'ProductController@categoryProducts');
	$api->post('product' , 'ProductController@product');

	/*
	 * Business
	 */
	$api->post('businesses' , 'BusinessController@index');
	$api->post('business/create' , 'BusinessController@create');
	$api->post('business' , 'BusinessController@business');
	$api->put('business/update' , 'BusinessController@update');
	$api->post('business/delete' , 'BusinessController@delete');
	/*
	 * Order
	 */
	$api->post('order/create' , 'OrderController@create');
	$api->post('order' , 'OrderController@order');

	$api->post('orders' , 'OrderController@orders');
	$api->post('orders/history' , 'OrderController@history');
	$api->put('order/edit' , 'OrderController@edit');
	$api->post('order/cancel' , 'OrderController@cancel');

	/*
	 * Payments
	 */
	$api->post('user/payments' , 'PaymentController@index');
});

$api->version('v1' , ['namespace' => 'App\Http\Controllers\Api' , 'middleware' => ['api' , 'jwt.auth' , 'otp']] , function ($api) {
	$api->post('cart' , 'CartController@cart');
	$api->post('cart/add' , 'CartController@add');
	$api->post('cart/item/edit' , 'CartController@editItem');
	$api->post('cart/item/remove' , 'CartController@removeItem');
	$api->post('cart/destroy' , 'CartController@destroy');
	$api->post('cart/complete/order' , 'CartController@makeOrder');


	/*
	 * Order Routes
	 */
	$api->post('customer/orders' , 'OrderController@orders');
	$api->post('customer/order' , 'OrderController@order');
	$api->post('customer/cancel/order' , 'OrderController@cancelOrder');
});

$api->version('v1' , ['namespace' => 'App\Http\Controllers\Api\Marketer' , 'middleware' => ['api' , 'jwt.auth' , 'otp' , 'marketer']] , function ($api) {
	$api->post('marketer/users' , 'UserController@users');
	$api->post('marketer/user/businesses' , 'UserController@businesses');
	$api->post('marketer/create/business' , 'UserController@createBusiness');
	$api->post('marketer/create/user' , 'UserController@createUser');
	$api->post('marketer/search/user' , 'UserController@searchUser');
	$api->post('marketer/verify/code' , 'UserController@verifyCode');
	/*
	 *Marketer Order
	 */
	$api->post('marketer/cart/add' , 'OrderController@add');
	$api->post('marketer/cart/item/edit' , 'OrderController@editItem');
	$api->post('marketer/cart/item/remove' , 'OrderController@removeItem');
	$api->post('marketer/cart/destroy' , 'OrderController@destroy');
	$api->post('marketer/cart/complete/order' , 'OrderController@makeOrder');
});

$api->version('v1' , ['namespace' => 'App\Http\Controllers\Api\Driver' , 'middleware' => ['api' , 'jwt.auth' , 'otp' , 'driver']] , function ($api) {
	$api->post('driver/orders' , 'DriverController@assigned');
	$api->post('driver/order' , 'DriverController@order');
	$api->post('driver/send/delivery/code' , 'DriverController@sendDeliveryCode');
	$api->post('driver/confirm/delivery/code' , 'DriverController@confirmDeliveryCode');
	$api->post('driver/deliver/without/confirmation' , 'DriverController@continueWithoutConfirmation');
});

/*
 * Student
 */

$api->version('v1' , ['namespace' => 'App\Http\Controllers\Api\Student' , 'middleware' => ['api' , 'jwt.auth' , 'otp' , 'student']] , function ($api) {
	$api->post('student/file/upload' , 'StudentController@fileUpload');
	$api->post('student/files' , 'StudentController@files');
	$api->post('student/file/delete' , 'StudentController@deleteFile');

});

Route::post('pay', 'PaymentController@pay');
