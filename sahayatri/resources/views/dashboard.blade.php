@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">engineering</i>
                            </div>
                            <p class="card-category">Drivers</p>
                            <h3 class="card-title">{{ DB::table('drivers')->count() }}
                                <small>new</small>
                            </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons text-primary">info</i>
                                <a href="#">See Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">taxi_alert</i>
                            </div>
                            <p class="card-category">Revenue for Rides</p>
                            <h3 class="card-title">
                                Rs.{{ round(DB::table('rides')->where('status', 'completed')->sum('total_fare') * 0.25,2) }}
                            </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Last 7 days
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">account_box</i>
                            </div>
                            <p class="card-category">User Info</p>
                            <h3 class="card-title">{{ DB::table('clients')->count() }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">local_offer</i> Registered online
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">flag</i>
                            </div>
                            <p class="card-category">Distance Covered</p>
                            <h3 class="card-title">
                                {{-- adding total distance of completed rides --}}
                                {{ DB::table('rides')->join('locations', 'rides.id', 'locations.ride_id')->where('status', 'completed')->sum('total_distance') }}
                                Km</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">update</i> Upto Date
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-chart">
                        <div class="card-header card-header-success">
                            <div class="ct-chart" id="clientSubscriptionsChart"></div>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Client Subscriptions</h4>
                            <p class="card-category">Latest client registrations</p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> updates from last 7 days
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-chart">
                        <div class="card-header card-header-warning">
                            <div class="ct-chart" id="dailyRevenueChart"></div>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Daily Revenue</h4>
                            <p class="card-category">
                                <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in
                                rides.
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> updated 4 minutes ago
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-chart">
                        <div class="card-header card-header-danger">
                            <div class="ct-chart" id="distanceCoveredChart"></div>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Distance Covered</h4>
                            <p class="card-category">Daily distance travelled</p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> rides from last 7 days
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-tabs card-header-primary">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#driver" data-toggle="tab">
                                                <i class="material-icons">engineering</i> Top Drivers
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="driver">
                                    <div class="table-responsive">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead class=" text-primary">
                                                    <tr>
                                                        <th>
                                                            Name
                                                        </th>
                                                        <th>
                                                            Rides
                                                        </th>
                                                        <th>
                                                            Total Distance
                                                        </th>
                                                        <th>
                                                            Revenue
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($drivers as $data)
                                                        <tr>
                                                            <td>
                                                                {{ $data->name }}
                                                            </td>
                                                            <td>
                                                                {{ $data->ride_count }}
                                                            </td>
                                                            <td>
                                                                {{ $data->total_distance }} Km
                                                            </td>
                                                            <td>
                                                                Rs. {{ $data->total_fare }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-tabs card-header-primary">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul class="nav nav-tabs" data-tabs="tabs">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#client" data-toggle="tab">
                                                <i class="material-icons">account_box</i> Top Clients
                                                <div class="ripple-container"></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="client">
                                    <div class="table-responsive">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead class=" text-primary">
                                                    <tr>
                                                        <th>
                                                            Name
                                                        </th>
                                                        <th>
                                                            Rides
                                                        </th>
                                                        <th>
                                                            Total Distance
                                                        </th>
                                                        <th>
                                                            Revenue
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($clients as $data)
                                                        <tr>
                                                            <td>
                                                                {{ $data->name }}
                                                            </td>
                                                            <td>
                                                                {{ $data->ride_count }}
                                                            </td>
                                                            <td>
                                                                {{ $data->total_distance }} Km
                                                            </td>
                                                            <td>
                                                                Rs. {{ $data->total_fare }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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

@push('js')
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/js/demos.js
            md.initDashboardPageCharts();
        });
    </script>
@endpush
