<?php

use App\Models\User;
use App\Models\Client;
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

    $user = new User;
    $user -> name = $request['name'];
    $user -> email = $request['email'];
    $user -> phone_no = $request['phone_no'];
    $user -> password = Hash::make($request['password']);
    $user -> type = 'client';
    $user -> save();

    $client = new Client;
    $client -> user_id = $user -> id;
    $client -> status = 'active';
    $client -> save();
    
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

    return $user->createToken($request->device_name)->plainTextToken;
});