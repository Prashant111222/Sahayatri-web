<?php

use App\Models\User;
use App\Models\Rating;
use App\Events\Test;
use App\Models\Client;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\Ride;
use App\Models\Location;
use App\Events\RideRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

//for returning the data related to user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return User::where('id', $request->user()->id)->withAvg('rating', 'rating')->first();
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
    //storing ride details
    $ride = new Ride;
    $ride -> client_id = Client::where('user_id', $request -> client_id)->first()['id'];
    $ride -> driver_id = Driver::where('user_id', $request -> driver_id)->first()['id'];
    $ride -> ride_type = $request -> ride_type;
    $ride -> scheduled_date = $request -> scheduled_date;
    $ride -> scheduled_time = $request -> scheduled_time;
    $ride -> total_fare = $request -> total_fare;
    $ride -> status = 'pending';
    $ride -> save();

    //storing location details
    $location = new Location;
    $location -> ride_id = $ride -> id;
    $location -> initial_lat = $request -> initial_lat;
    $location -> initial_lng = $request -> initial_lng;
    $location -> destination_lat = $request -> destination_lat;
    $location -> destination_lng = $request -> destination_lng;
    $location -> origin = $request -> origin;
    $location -> destination = $request -> destination;
    $location -> total_distance = $request -> total_distance;
    $location -> save();
    
    $details = ['driver_id' => $request->driver_id, 'client_id' => $request->client_id, 'ride_id' => $ride->id];
    // broadcast(new RideRequest($details));

    $details = User::where('id', $request->client_id)
        ->withAvg('rating', 'rating')
        ->first()
        ->toArray();

        $rideInfo = Ride::where('id', $ride->id)
        ->with('location')
        ->first()
        ->toArray();

        return ['user' => $details, 'ride' => $rideInfo];
    return 'success';
});