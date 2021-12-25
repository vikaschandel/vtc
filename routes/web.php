<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionData;
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
Route::get('/',  [LoginController::class,'showLoginForm'])->name('login');


Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::get('password/forget',  function () { 
	return view('pages.forgot-password'); 
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');


Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout']);
	Route::get('/clear-cache', [HomeController::class,'clearCache']);

	// dashboard route  
	Route::get('/dashboard', function () { 
		return view('pages.dashboard'); 
	})->name('dashboard');

	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user|manage_user'], function(){
	Route::get('/users', [UserController::class,'index']);
	Route::get('/user/get-list', [UserController::class,'getUserList']);
		Route::get('/user/create', [UserController::class,'create']);
		Route::post('/user/create', [UserController::class,'store'])->name('create-user');
		Route::get('/user/{id}', [UserController::class,'edit']);
		Route::post('/user/update', [UserController::class,'update']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::post('/role/create', [RolesController::class,'create']);
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});


	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);


});


//Route::get('/register', function () { return view('pages.register'); });

/*App*/
Route::get('/add-new-trans', function () {
    return view('home');
});

/***************** Warehouse ****************/
Route::get('/warehouses', function () {
    return view('warehouse');
});
Route::get('/warehouseList', function () {
    return view('warehouse-list');
});
Route::get('/warehouses/get-list', [TransactionController::class,'getWareList']);
Route::post('/warehouse/add-warehouse', [TransactionController::class,'add_warehouse']);
Route::get('/warehouse/delete/{id}', [TransactionController::class,'delete']);

/***************** Vehicles ****************/
Route::get('/create-vehicle', function () {
    return view('create-vehicle');
});
Route::get('/vehiclesList', function () {
    return view('vehicles');
});
Route::post('/vehicle/add-vehicle', [TransactionController::class,'add_vehicle']);
Route::get('/vehicle/getvlist', [TransactionController::class,'getvlist']);
Route::get('/vehicle/delete/{id}', [TransactionController::class,'delete_vehicle']);

/***************** Transporter ****************/
Route::get('/create-transporter', function () {
    return view('create-transporter');
});

Route::get('/transportList', function () {
    return view('transporters');
});
Route::get('/transporter/tagging', [TransactionController::class,'create_tagging']);
Route::post('/transporter/add-transporter', [TransactionController::class,'add_transporter']);
Route::get('/transporter/trnplist', [TransactionController::class,'trnplist']);
Route::get('/transporter/delete/{id}', [TransactionController::class,'delete_transporter']);
Route::post('/transporter/add-tagging', [TransactionController::class,'add_tagging']);
Route::get('/transporter/get-tagged', [TransactionController::class,'getTaged']);
Route::get('/tags/edit/{id}', [TransactionController::class,'edit_tags']);
Route::post('/transporter/update-tagging', [TransactionController::class,'update_tagging']);
/***************** Lanes ****************/
Route::get('/create-lanes', [TransactionController::class,'create_lanes']);
Route::post('/lanes/add-lane', [TransactionController::class,'add_lane']);
Route::get('/lanesList', function () {
    return view('lanes');
});
Route::get('/lanes/lanelist', [TransactionController::class,'lanelist']);
Route::get('/lanes/delete/{id}', [TransactionController::class,'delete_lane']);
/***************** Products ****************/
Route::get('/products', function () {
    return view('products');
});
Route::get('/products/productlist', [TransactionController::class,'productlist']);
Route::get('/products/delete/{id}', [TransactionController::class,'delete_product']);
Route::post('/products/add-product', [TransactionController::class,'add_product']);
/***************** Imports ****************/
Route::get('/allImports', function () {
    return view('imports');
});
Route::post('/imports/all-import', [TransactionController::class,'imports']);

/*************** Transactions **************/

Route::get('/transactions', function () {
    return view('transactions');
});
Route::get('/create-transaction', [TransactionController::class,'create_transaction']);
Route::get('/warehouse/suggested-lanes', [TransactionController::class,'suggested_lanes']);
Route::get('/warehouse/suggested-desti', [TransactionController::class,'suggested_desti']);
Route::get('/warehouse/getLanes', [TransactionController::class,'getLanes']);
Route::get('/vehicle/check-vehicles', [TransactionController::class,'check_vehicles']);

/******************************* Transactions Data Routes ******************************/
Route::post('/transaction/add-new-transaction', [TransactionData::class,'add_new_transaction']);
Route::get('/transactions/outgoing', [TransactionData::class,'outgoing_transactions']);
Route::get('/transactions/outgoing-dt', [TransactionData::class,'outgoing_dt']);
Route::get('/transactions/incoming', function () {
    return view('incoming-trans');
});
Route::get('/transactions/incoming-trn-dt', [TransactionData::class,'incoming_trans_dt']);
Route::get('/transactions/entry/{id}', [TransactionData::class,'vehicle_entry']);
Route::post('/warehouses/get-assigned', [TransactionData::class,'get_assigned']);
Route::post('/warehouses/get-destination', [TransactionData::class,'get_destination']);
