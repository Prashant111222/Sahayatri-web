@extends('layouts.app', ['activePage' => 'update-driver', 'titlePage' => __('Driver Details')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-12 text-left">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-tabs card-header-primary">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <span class="nav-tabs-title">Driver Information</span>
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#profile" data-toggle="tab">
                                                <i class="material-icons">account_box</i> Profile
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#vehicle" data-toggle="tab">
                                                <i class="material-icons">local_taxi</i> Vehicle Info
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#ride" data-toggle="tab">
                                                <i class="material-icons">departure_board</i> Ride Info
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="profile">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="nav-link" href="#">
                                                <h3><i class="material-icons">person_outlined</i>{{ $data->name }}</h3>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="nav-link" href="#">
                                                <h5><i class="material-icons">star_</i>4.8</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="nav-link" href="#">
                                                <h5><i class="material-icons">mail_outlined</i>{{ $data->email }}</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="nav-link" href="#">
                                                <h5><i class="material-icons">phone_</i>{{ $data->phone_no }}</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="nav-link" href="#">
                                                <h5><i class="material-icons">badge_</i>License No -  {{ $data->driver->license_no }}
                                                </h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <img src="{{ asset('storage/licenses/'.$data->driver->license) }}" alt="{{ $data->name }}'s License">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: right;">
                                            <h6>Registered by: {{ Auth::user()->name }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="vehicle">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="nav-link" href="#">
                                                <h5><i
                                                        class="material-icons">confirmation_number_</i>Vehicle No -  {{ $data->driver->vehicle->vehicle_no }}
                                                </h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a class="nav-link" href="#">
                                                <h5><i
                                                        class="material-icons">category_</i>Vehicle Type -  {{ $data->driver->vehicle->vehicle_type->vehicle_type }}
                                                    @if ($data->driver->vehicle->vehicle_type->vehicle_type == 'cab')
                                                        <i class="material-icons">drive_eta</i>
                                                    @elseif ($data->driver->vehicle->vehicle_type->vehicle_type == 'bike')
                                                        <i class="material-icons">two_wheeler</i>
                                                    @else
                                                        <i class="material-icons">moped</i>
                                                    @endif
                                                </h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="text-align: right;">
                                            <h6>Registered by: {{ Auth::user()->name }}</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
