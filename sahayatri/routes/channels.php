<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//veryfing the incoming request to be connected with the private channels
Broadcast::channel('client.{userId}', function ($user, $userId) {
    return $user->id === User::find($userId)->id;
});

Broadcast::channel('driver.{userId}', function ($user, $userId) {
    return $user->id === User::find($userId)->id;
});
