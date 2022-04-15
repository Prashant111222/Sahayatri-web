<?php

namespace App\Http\Controllers;
use DB;
use Carbon\Carbon;

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
        //storing data for income in each day of a week
        $weeklyIncome = array(0, 0, 0, 0, 0, 0, 0);

        //traversing for seven days of a week
        for($i = 0; $i < 7; $i++){
            $weeklyIncome[$i] = $this->getDailyIncomeData($i)->total_fare ?? 0; //zero income if null value returned
        }

        //storing data for distance travelled in each day of a week
        $weeklyDistance = array(0, 0, 0, 0, 0, 0, 0);

        for($i = 0; $i < 7; $i++){
            $weeklyDistance[$i] = $this->getDailyDistanceData($i)->total_distance ?? 0; //zero if returned distance is null
        }

        //storing the data for total user subscriptions in each day of a week
        $weeklyUsers = array(0, 0, 0, 0, 0, 0, 0);

        for($i = 0; $i < 7; $i++){
            $weeklyUsers[$i] = $this->getDailyUsersData($i)->total_users ?? 0; //zero if no users are created on a specific date
        }

        //getting the top 5 drivers from the income point of view using DB query
        $drivers = DB::table('rides')
        ->select('users.name',
            DB::raw('sum(rides.total_fare) as total_fare'),
            DB::raw('sum(locations.total_distance) as total_distance'), //using the aggegate function
            DB::raw('count(*) as ride_count, drivers.id'))
        ->join('locations', 'rides.id', 'locations.ride_id')
        ->join('drivers', 'drivers.id', 'rides.driver_id')
        ->join('users', 'users.id', 'drivers.user_id')
        ->where('rides.status', 'completed')
        ->groupBy('users.name', 'drivers.id')
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
        ->groupBy('users.name', 'clients.id')
        ->orderByDesc('total_fare')
        ->limit(5)
        ->get();

        //data to be returned
        $details = [
            'drivers' => $drivers, 
            'clients' => $clients, 
            'weeklyIncome' => $weeklyIncome,
            'weeklyDistance' => $weeklyDistance,
            'weeklyUsers' => $weeklyUsers 
        ];

        return view('dashboard', $details);
    }

    //returns total income based upon the day of the week provided
    public function getDailyIncomeData($day){
        return  DB::table('rides')
        ->select(DB::raw('sum(total_fare) as total_fare'),
        DB::raw('DATE(updated_at) as date'))
        ->whereDay('updated_at', Carbon::now()->subWeek()->startOfWeek(Carbon::SUNDAY)->addWeekDays($day - 7))
        ->where('status', 'completed')
        ->groupBy('date')
        ->first();
    }

    //returns total distance travelled by drivers on each provided day of a week
    public function getDailyDistanceData($day){
        return  DB::table('rides')
        ->select(DB::raw('sum(locations.total_distance) as total_distance'), 
        DB::raw('DATE(rides.updated_at) as date'))
        ->join('locations', 'locations.ride_id', 'rides.id')
        ->whereDay('rides.updated_at', Carbon::now()->subWeek()->startOfWeek(Carbon::SUNDAY)->addWeekDays($day - 7))
        ->where('rides.status', 'completed')
        ->groupBy('date')
        ->first();
    }

    //returns total number of registered users in each provided day of week
    public function getDailyUsersData($day){
        return  DB::table('users')
        ->select(DB::raw('count(*) as total_users'), 
        DB::raw('DATE(created_at) as date'))
        ->whereDay('created_at', Carbon::now()->subWeek()->startOfWeek(Carbon::SUNDAY)->addWeekDays($day - 7))
        ->where('type', 'client')
        ->groupBy('date')
        ->first();
    }
}
