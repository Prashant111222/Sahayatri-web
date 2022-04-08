<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request -> validate([
            'vehicle_no' => ['required', 'string', 'max:12', 'min:12', 'unique:vehicles', 'regex:/[A-Z]{2}-[ABC]{1}-(AB)-[0-9]{4}$/'],
            'id' => ['required', 'string', 'max:255', 'unique:vehicles,driver_id'],
        ]);

        $vehicle = new Vehicle;
        $vehicle -> vehicle_no = $request -> vehicle_no;
        $vehicle -> status = 'active';
        $vehicle -> driver_id = $request -> id;
        $vehicle -> vehicle_type_id = $request -> vehicle_type;
        $vehicle -> save();

        Driver::where('id', $request -> id)->update(['status' => 'active']);

        return back()->withStatus(__('Driver and Vehicle Information Successfully Added.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $request -> validate([
            'vehicle_no' => ['required', 'string', 'max:12', 'min:12', Rule::unique('vehicles')->ignore($request->id), 'regex:/[A-Z]{2}-[ABC]{1}-(AB)-[0-9]{4}$/'],
        ]);

        //updating the vehicle info
        Vehicle::where('id', $request->id)->update([
            'vehicle_no' => $request->vehicle_no,
            'vehicle_type_id' => $request->vehicle_type,
        ]);

        return back()->withStatus(__('Vehicle Information Successfully Updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
