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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('user/verify/{verification_code}', 'AuthController@verifyUser');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');

Route::get('costumer', 'Costumer\\CostumersController@index');
// Route::resource('order/orders', 'Order\\OrdersController');
// Route::resource('costumer/costumers', 'Models\Costumer\\CostumersController');
// Route::resource('vehicle/vehicles', 'Models\Vehicle\\VehiclesController');
// Route::resource('Models\vehicle/vehicles', 'Vehicle\\VehiclesController');
// Route::resource('vehicle/vehicles', 'Vehicle\\VehiclesController');
// Route::resource('vehicle/vehicles', 'Vehicle\\VehiclesController');
// Route::resource('product/products', 'Product\\ProductsController');
// Route::resource('installer/installers', 'Installer\\InstallersController');
// Route::resource('intervention/interventions', 'Intervention\\InterventionsController');
// Route::resource('interventiondetails/interventiondetails', 'Interventiondetail\\InterventiondetailsController');
// Route::resource('interventiondetailsproduct/interventiondetailsproduct', 'Interventiondetailsproduct\\InterventiondetailsproductController');
// Route::resource('installerproduct/installerproduct', 'Installerproduct\\InstallerproductController');