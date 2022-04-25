<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //adding preifix to every incoming routes
        Broadcast::routes(['prefix' => 'api', 'middleware' => ['auth:sanctum']]);

        require base_path(path: 'routes/channels.php');
    }
}
