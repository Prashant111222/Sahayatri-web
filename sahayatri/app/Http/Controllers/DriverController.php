<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Driver;
use App\Models\User;
use App\Models\Ride;
use App\Models\Rating;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //returning the specific driver with their ratings
        $drivers = User::where('type', 'driver')
        ->withAvg('rating', 'rating')
        ->with('driver')
        ->get();

        return view('drivers.index', ['data'  => $drivers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        //getting specific driver with their vehicle info
        $drivers = User::where('id', $id )
        ->with('driver.vehicle.vehicle_type')
        ->first();

        //getting the ride information of specific drivers
        $driver_id = Driver::where('user_id', $id)->first()['id'];

        //getting all the pending requests of a driver
        $ride = Ride::where('driver_id', $driver_id)
        ->with('client.user')
        ->with('location')
        ->orderByDesc('updated_at')
        ->get();

        return view('drivers.detail', ['data' => $drivers, 'ride' => $ride]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validating the input
        $request -> validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-z ]+$/i'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_no' => ['required', 'string', 'max:15', 'unique:users', 'regex:/((\+)?977)?(98)[0-9]{8}$/'],
            'license_no' => ['required', 'string', 'max:14', 'min:14', 'unique:drivers', 'regex:/[0-9]{2}-[0-9]{2}-[0-9]{8}$/'],
            'license' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        //getting the uploaded image file in the field
        $licenseImage = $request->file('license');
        $imageName = $request['license_no'].'.'.$licenseImage->getClientOriginalExtension(); //renaming the image file
        $license = $licenseImage->storeAs(
            'public/licenses', $imageName
        ); //storing the image file locally in public folder and storing address in the database
    
        //filling user information
        $user = new User;
        $user -> name = $request['name'];
        $user -> email = $request['email'];
        $user -> phone_no = $request['phone_no'];
        $user -> password = Hash::make(Str::random(12));
        $user -> type = 'driver';
        $user -> save();

        //sending E-mail for resetting the password
        Password::sendResetLink($request->only(['email']));

        //filling driver infrmation
        $driver = new Driver;
        $driver -> user_id = $user -> id;
        $driver -> license_no = $request['license_no'];
        $driver -> license = $imageName;
        $driver -> availability = 'off';
        $driver -> status = 'inactive';
        $driver -> save();

        //filling rating information i.e. 0 initially
        $rating = new Rating;
        $rating -> user_id = $user -> id;
        $rating -> rating = 5;
        $rating -> save();

        return redirect()->route('add.vehicle', $driver->id)->withStatus(__('Driver Successfully Added.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $drivers = User::where('id', $id )
        ->with('driver')
        ->first();

        return view('drivers.update', ['data' => $drivers]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validating user input
        $request -> validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-z ]+$/i'],
            'email' => ['required', 'string', 'email', 'max:255',  Rule::unique('users')->ignore($request->user_id)], //for checking unique email except inserted one
            'phone_no' => ['required', 'string', 'max:15', Rule::unique('users')->ignore($request->user_id), 'regex:/((\+)?977)?(98)[0-9]{8}$/'],
            'license_no' => ['required', 'string', 'max:14', 'min:14', Rule::unique('drivers')->ignore($request->driver_id), 'regex:/[0-9]{2}-[0-9]{2}-[0-9]{8}$/'],
            'license' => ['image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        //storing the license photo if uploaded by the client
        if($request->license != null){
            $licenseImage = $request->file('license');
            $imageName = $request['license_no'].'.'.$licenseImage->getClientOriginalExtension(); //renaming the image file name
            $license = $licenseImage->storeAs(
                'public/licenses', $imageName //storing image file inside the public folder
            );

            //updating the location of new image
            Driver::where('id', $request -> driver_id)->update([
                'license' => $imageName,
            ]);
        }

        //updating other respective information
        User::where('id', $request->user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
        ]);

        //updating the license number
        Driver::where('id', $request -> driver_id)->update([
            'license_no' => $request->license_no,
        ]);

        return redirect()->route('update.vehicle', $request -> driver_id)->withStatus(__('Driver Successfully Updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //deleting the specific driver
        User::where('id', $id)->delete();
        return back()->withStatus(__('Driver Successfully Deleted.'));
    }
}
