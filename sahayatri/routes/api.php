<?php

use App\Models\User;
use App\Models\Rating;
use App\Models\Client;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\Ride;
use App\Models\Location;
use App\Events\RideRequest;
use App\Events\CancelRequest;
use App\Events\ConfirmPayment;
use App\Events\CancelTrip;
use App\Events\ConfirmRequest;
use App\Events\NotifyClient;
use App\Events\RideCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

//for returning the data related to user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return User::where('id', $request->user()->id)
    ->withAvg('rating', 'rating')
    ->first();
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
    $user = User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'phone_no' => $request['phone_no'],
        'password' => Hash::make($request['password']),
        'type' => 'client',
    ]);

    //storing specific client details
    $client = new Client;
    $client->user_id = $user->id;
    $client->status = 'active';
    $client->save();
    
    //storing initial rating i.e. 5
    $rating = new Rating;
    $rating->user_id = $user->id;
    $rating->rating = 5;
    $rating->save();
    
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

    Driver::where('user_id', $user->id)
    ->update(['availability' => 'off']);

    return 'success';
});

//changing driver status to online
Route::middleware('auth:sanctum')->get('/online', function (Request $request) {
    $user = $request->user();

    Driver::where('user_id', $user->id)
    ->update(['availability' => 'on']);

    return 'success';
});

//rating for users
Route::middleware('auth:sanctum')->post('/rate/user', function (Request $request) {
    $rating = new Rating;
    $rating->user_id = $request->user_id;
    $rating->rating = $request->rate;
    $rating->save();
    return 'success';
});

//storing the ride information
Route::middleware('auth:sanctum')->post('/request/driver', function (Request $request) {
    //storing ride details
    $ride = new Ride;
    $ride->client_id = Client::where('user_id', $request->client_id)->first()['id']; //getting the client ID from the user ID
    $ride->driver_id = Driver::where('user_id', $request->driver_id)->first()['id'];
    $ride->ride_type = $request->ride_type;
    $ride->scheduled_date = $request->scheduled_date;
    $ride->scheduled_time = $request->scheduled_time;
    $ride->total_fare = $request->total_fare;
    $ride->status = 'cancelled';
    $ride->save();

    //storing location details
    $location = new Location;
    $location->ride_id = $ride->id;
    $location->initial_lat = $request->initial_lat;
    $location->initial_lng = $request->initial_lng;
    $location->destination_lat = $request->destination_lat;
    $location->destination_lng = $request->destination_lng;
    $location->origin = $request->origin;
    $location->destination = $request->destination;
    $location->total_distance = $request->total_distance;
    $location->save();
    
    $details = ['driver_id' => $request->driver_id, 'client_id' => $request->client_id, 'ride_id' => $ride->id];

    //broadcasting the request to the driver
    broadcast(new RideRequest($details));

    return 'success';
});

//receiving the response from the driver
Route::middleware('auth:sanctum')->post('/driver/response', function (Request $request) {
    //accessing user name from the id
    $name = User::select('name')->where('id', $request->driver_id)->first();
    //storing name and id in the compact array
    $details = ['name' => $name, 'id' => $request->client_id, 'ride' => $request->ride_id];

    if($request->response == 'accepted'){
        //updating the status
        Ride::where('id', $request->ride_id)->update(['status' => 'pending']);
        //broadcasting to the client
        broadcast(new ConfirmRequest($details));
    }
    else if($request->response == 'rejected') {
        //deleting the details
        Ride::where('id', $request->ride_id)->delete();
        //broadcasting to the client
        broadcast(new CancelRequest($details));
    }
    return 'success';
});

//cancelling the trip by client
Route::middleware('auth:sanctum')->post('/cancel/trip', function (Request $request) {
    $name = User::select('name')->where('id', $request->client_id)->first();
    $details = ['name' => $name, 'id' => $request->driver_id];

    Ride::where('id', $request->ride_id)->update(['status' => 'cancelled']);
    broadcast(new CancelTrip($details));
    return 'success';
});

//on completion of the ride
Route::middleware('auth:sanctum')->post('/ride/completed', function (Request $request) {
    //getting the name of the driver
    $name = User::select('name')->where('id', $request->driver_id)->first();

    $details = ['client_id' => $request->client_id, 'name' => $name, 'driver_id' => $request->driver_id];

    //when the ride is completed
    Ride::where('id', $request->ride_id)->update(['status' => 'completed']);

    //broadcasting to the client
    broadcast(new RideCompleted($details));
    return 'success';
});

//getting all the pending trips for driver
Route::middleware('auth:sanctum')->get('/pending/requests', function (Request $request) {
    //getting the driver id
    $driver_id = Driver::where('user_id', $request->user()->id)->first()['id'];

    //getting all the pending requests of a driver
    $ride = Ride::where('driver_id', $driver_id)
    ->where('status', 'pending')
    ->with('client.user')
    ->with('location')
    ->with('payment')
    ->orderBy('scheduled_date')
    ->get();

    return $ride;
});

//getting all the upcoming trips for client
Route::middleware('auth:sanctum')->get('/upcoming/trips', function (Request $request) {
    //getting the client id
    $client_id = Client::where('user_id', $request->user()->id)->first()['id'];

    //getting all the upcoming trips of a client
    $trips = Ride::where('client_id', $client_id)
    ->where('status', 'pending')
    ->with('driver.user')
    ->with('location')
    ->with('payment')
    ->orderBy('scheduled_date')
    ->get();

    return $trips;
});

//getting all the completed trips of client
Route::middleware('auth:sanctum')->get('/client/history', function (Request $request) {
    //getting the client id
    $client_id = Client::where('user_id', $request->user()->id)->first()['id'];

    //getting all the upcoming trips of a client
    $trips = Ride::where('client_id', $client_id)
    ->where('status', 'completed')
    ->with('location')
    ->orderByDesc('updated_at')
    ->get();

    return $trips;
});

//getting all the completed trips of driver
Route::middleware('auth:sanctum')->get('/driver/history', function (Request $request) {
    //getting the driver id
    $driver_id = Driver::where('user_id', $request->user()->id)->first()['id'];

    //getting all the upcoming trips of a client
    $trips = Ride::where('driver_id', $driver_id)
    ->where('status', 'completed')
    ->with('location')
    ->orderByDesc('updated_at')
    ->get();

    return $trips;
});

//For notifying the client before starting the trip
Route::middleware('auth:sanctum')->post('/notify/client', function (Request $request) {
    //broadcasting to the client channel
    broadcast(new NotifyClient($request->client_id));

    return 'success';
});

//for resetting the password
Route::post('/forgot/password', function (Request $request) {
    //sending password reset link to user email
    Password::sendResetLink($request->only(['email']));

    return 'success';
});

//For online payment
Route::middleware('auth:sanctum')->post('/online/payment', function (Request $request) {
    
    //getting client id
    $client_id = Client::where('user_id', $request->user()->id)->first()['id'];

    //creating online payment
    $payment = new Payment;
    $payment->client_id = $client_id;
    $payment->ride_id = $request->ride_id;
    $payment->payment_method = 'online';
    $payment->amount = $request->amount;
    $payment->save();

    //getting user id for driver
    $id = DB::table('users')
    ->select('users.id')
    ->join('drivers', 'drivers.user_id', 'users.id')
    ->join('rides', 'rides.driver_id', 'drivers.id')
    ->where('rides.id', $request->ride_id)
    ->first();

    //getting client name
    $name = DB::table('users')
    ->select('users.name')
    ->join('clients', 'clients.user_id', 'users.id')
    ->join('rides', 'rides.client_id', 'clients.id')
    ->where('rides.id', $request->ride_id)
    ->first();

    //broadcasting to the driver
    broadcast(new ConfirmPayment(compact('id', 'name')));

    return 'success';
});

//For cash payment
Route::middleware('auth:sanctum')->post('/cash/payment', function (Request $request) {

    //getting client id
    $client_id = Client::where('user_id', $request->user()->id)->first()['id'];

    //creating cash payment
    $payment = new Payment;
    $payment->client_id = $client_id;
    $payment->ride_id = $request->ride_id;
    $payment->payment_method = 'cash';
    $payment->amount = $request->amount;
    $payment->save();
    return 'success';
});