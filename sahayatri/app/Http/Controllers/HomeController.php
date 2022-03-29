<?php

namespace App\Http\Controllers;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //getting the top 5 drivers from the income point of view using DB query
        $drivers = DB::table('rides')
        ->select('users.name',
            DB::raw('sum(rides.total_fare) as total_fare'),
            DB::raw('sum(locations.total_distance) as total_distance'),
            DB::raw('count(*) as ride_count, drivers.id'))
        ->join('locations', 'rides.id', 'locations.ride_id')
        ->join('drivers', 'drivers.id', 'rides.driver_id')
        ->join('users', 'users.id', 'drivers.user_id')
        ->where('rides.status', 'completed')
        ->groupBy('users.name', 'rides.total_fare', 'locations.total_distance', 'drivers.id')
        ->orderByDesc('total_fare')
        ->limit(5)
        ->get();

        //getting the top five clients from the income point of view using DB query
        $clients = DB::table('rides')
        ->select('users.name',
            DB::raw('sum(rides.total_fare) as total_fare'),
            DB::raw('sum(locations.total_distance) as total_distance'),
            DB::raw('count(*) as ride_count, clients.id'))
        ->join('locations', 'rides.id', 'locations.ride_id')
        ->join('clients', 'clients.id', 'rides.client_id')
        ->join('users', 'users.id', 'clients.user_id')
        ->where('rides.status', 'completed')
        ->groupBy('users.name', 'rides.total_fare', 'locations.total_distance', 'clients.id')
        ->orderByDesc('total_fare')
        ->limit(5)
        ->get();

        return view('dashboard', ['drivers' => $drivers, 'clients' => $clients]);
    }
}
