<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
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
            'vehicle_type' => ['required', 'string', 'unique:vehicle_types'],
            'fare_rate' => ['required', 'numeric', 'min:1', 'max:1000'],
        ]);

        $vehicleType = new VehicleType;
        $vehicleType -> vehicle_type = $request -> vehicle_type;
        $vehicleType -> fare_rate = $request -> fare_rate;
        $vehicleType -> save();

        return back()->withStatus(__('Vehicle type and rate successfully added.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $vehicleType = VehicleType::find($id);
        return view('vehicle_type.update', ['vehicle_type' => $vehicleType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request -> validate([
            'fare_rate' => ['required', 'numeric', 'min:1', 'max:1000'],
        ]);

        $vehicleType = VehicleType::find($id);
        $vehicleType -> fare_rate = $request -> fare_rate;
        $vehicleType -> save();

        return back()->withStatus(__('Price Successfully Updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleType $vehicleType)
    {
        //
    }
}
