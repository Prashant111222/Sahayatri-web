<?php

use App\Events\Test;
use App\Events\RideRequest;
use App\Models\VehicleType;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/broadcast', function () {
	//  $request = ["initial_lat" => 26.7061702, "driver_id" => 4,"client_id" => 3];
	// broadcast(new RideRequest($request));
    broadcast(new Test(User::find(3)));
});

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
	Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
	Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('client/app', function () {
		return view('application.client');
	})->name('client.app');

	Route::get('driver/app', function () {
		return view('application.driver');
	})->name('driver.app');

	Route::get('driver/add', function(){
		return view('drivers.add');
	})->name('add.driver');

	Route::get('vehicle/type', function(){
		return view('vehicle_type.add', ['vehicle_type' => VehicleType::all()]);
	})->name('add.vehicleType');

	Route::get('vehicle/store/{id}', function($id){
		return view('vehicle.add', ['driver_id' => $id, 'vehicle_types' => VehicleType::all()]);
	})->name('add.vehicle');

	Route::get('vehicle/update/{id}', function($id){
		return view('vehicle.update', ['vehicle' => Vehicle::where('driver_id', $id)->first(), 'vehicle_types' => VehicleType::all()]);
	})->name('update.vehicle');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::post('driver/store', ['as' => 'driver.store', 'uses' => 'App\Http\Controllers\DriverController@store']);
	Route::post('vehicle/store/', ['as' => 'vehicle.store', 'uses' => 'App\Http\Controllers\VehicleController@store']);
	Route::get('driver/index/', ['as' => 'manage.driver', 'uses' => 'App\Http\Controllers\DriverController@index']);
	Route::get('driver/detail/{id}', ['as' => 'driver.detail', 'uses' => 'App\Http\Controllers\DriverController@detail']);
	Route::get('driver/display/{id}', ['as' => 'display.driver', 'uses' => 'App\Http\Controllers\DriverController@show']);
	Route::post('driver/update/', ['as' => 'driver.update', 'uses' => 'App\Http\Controllers\DriverController@update']);
	Route::post('vehicle/update/', ['as' => 'vehicle.update', 'uses' => 'App\Http\Controllers\VehicleController@update']);
	Route::get('driver/delete/{id}', ['as' => 'delete.driver', 'uses' => 'App\Http\Controllers\DriverController@destroy']);

	Route::get('user/index/', ['as' => 'user.index', 'uses' => 'App\Http\Controllers\ClientController@index']);
	Route::get('user/delete/{id}', ['as' => 'delete.client', 'uses' => 'App\Http\Controllers\ClientController@destroy']);

	Route::post('vehicle/type/store', ['as' => 'vehicleType.store', 'uses' => 'App\Http\Controllers\VehicleTypeController@store']);
	Route::get('vehicle/type/edit/{id}', ['as' => 'vehicleType.edit', 'uses' => 'App\Http\Controllers\VehicleTypeController@edit']);
	Route::post('vehicle/type/update/{id}', ['as' => 'vehicleType.update', 'uses' => 'App\Http\Controllers\VehicleTypeController@update']);
});



