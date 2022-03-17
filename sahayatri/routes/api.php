<?php

use App\Models\User;
use App\Models\Rating;
use App\Events\Test;
use App\Models\Client;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

//for returning the data related to user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//for registering new users
Route::post('/register', function (Request $request) {
    $request -> validate([
        'name' => ['required', 'string', 'max:255', 'regex:/^[a-z ]+$/i'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'phone_no' => ['required', 'string', 'max:15', 'unique:users', 'regex:/((\+)?977)?(98)[0-9]{8}$/'],
        'password' => ['required', 'string', 'min:8'],
    ]);

    //storing user details
    $user = new User;
    $user -> name = $request['name'];
    $user -> email = $request['email'];
    $user -> phone_no = $request['phone_no'];
    $user -> password = Hash::make($request['password']);
    $user -> type = 'client';
    $user -> save();

    //storing specific client details
    $client = new Client;
    $client -> user_id = $user -> id;
    $client -> status = 'active';
    $client -> save();
    
    //storing initial rating i.e. 0
    $rating = new Rating;
    $rating -> user_id = $user -> id;
    $rating -> rating = 0;
    $rating -> save();
    
    return 'success';
});

//for deleting the personal access tokens
Route::middleware('auth:sanctum')->get('/user/revoke', function (Request $request) {
    $user =  $request->user();
    $user->tokens()->delete();
    return 'Tokens Deleted';
});

//for authenticating the user
Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return ['token' => $user->createToken($request->device_name)->plainTextToken, 'type' => $user->type];
});

//sending driver details on request if available
Route::middleware('auth:sanctum')->get('/request/ride', function (Request $request) {
    $drivers = User::where('type', 'driver')
    ->withAvg('rating', 'rating')
    ->with('driver.vehicle.vehicle_type')
    ->orderByDesc('rating_avg_rating')
    ->get()
    ->where('driver.availability', 'on')
    ->values();

    return $drivers;
});

//changing driver status to offline
Route::middleware('auth:sanctum')->get('/offline', function (Request $request) {
    $user = $request->user();

    Driver::where('user_id', $user -> id)->update(['availability' => 'off']);

    return 'success';
});

//changing driver status to online
Route::middleware('auth:sanctum')->get('/online', function (Request $request) {
    $user = $request->user();

    Driver::where('user_id', $user -> id)->update(['availability' => 'on']);

    return 'success';
});

//rating for users
Route::middleware('auth:sanctum')->get('/rate/user', function (Request $request) {
    $rating = new Rating;
    $rating -> user_id = $request -> user_id;
    $rating -> rating = $request -> rate;
    $rating -> save();
    return 'success';
});

Route::middleware('auth:sanctum')->post('/request/driver', function (Request $request) {
    $request->driver_id;
    $request->client_id;
    return ['client' => User::find($request->driver_id)];
});