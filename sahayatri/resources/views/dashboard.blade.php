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
                                Rs.{{ round(DB::table('rides')->where('status', 'completed')->sum('total_fare'), 0) }}
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
                                <i class="material-icons">access_time</i> weekly updates
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
                                Inrease or Decrease in the weekly income.
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> updated for the latest week
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
        //initializing data from JSON to be used inside the charts
        var weeklyIncome = @json($weeklyIncome);
        var weeklyDistance = @json($weeklyDistance);
        var weeklyUsers = @json($weeklyUsers);

        $(document).ready(function() {
            // Javascript method's body
            md.initDashboardPageCharts();
        });

        //delaying few seconds before displaying the chart for animation
        setTimeout(function() {
            initDashboardPageCharts();
        }, 500);

        //function for displaying overall chart
        function initDashboardPageCharts() {

            if ($('#clientSubscriptionsChart').length != 0 || $('#distanceCoveredChart').length != 0 || $(
                    '#dailyRevenueChart').length != 0) {
                /* ----------==========    Client Subscriptions Chart initialization    ==========---------- */

                dataclientSubscriptionsChart = {
                    labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    series: [
                        weeklyUsers
                    ]
                };

                optionsclientSubscriptionsChart = {
                    lineSmooth: Chartist.Interpolation.cardinal({
                        tension: 0
                    }),
                    low: 0,
                    high: 8,
                    chartPadding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    },
                }

                var clientSubscriptionsChart = new Chartist.Line('#clientSubscriptionsChart',
                    dataclientSubscriptionsChart, optionsclientSubscriptionsChart);

                md.startAnimationForLineChart(clientSubscriptionsChart);



                /* ----------==========     Distance Covered chart initialization    ==========---------- */

                datadistanceCoveredChart = {
                    labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    series: [
                        weeklyDistance
                    ]
                };

                optionsdistanceCoveredChart = {
                    lineSmooth: Chartist.Interpolation.cardinal({
                        tension: 0
                    }),
                    low: 0,
                    high: 300, //for differentiating the views of chart data
                    chartPadding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    }
                }

                var distanceCoveredChart = new Chartist.Line('#distanceCoveredChart', datadistanceCoveredChart,
                    optionsdistanceCoveredChart);

                // start animation for the Completed Tasks Chart - Line Chart
                md.startAnimationForLineChart(distanceCoveredChart);


                /* ----------==========     Daily Revenue initialization    ==========---------- */

                var datadailyRevenueChart = {
                    labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    series: [
                        weeklyIncome

                    ]
                };
                var optionsdailyRevenueChart = {
                    axisX: {
                        showGrid: false
                    },
                    low: 0,
                    high: 10000,
                    chartPadding: {
                        top: 0,
                        right: 5,
                        bottom: 0,
                        left: 0
                    }
                };
                var responsiveOptions = [
                    ['screen and (max-width: 640px)', {
                        seriesBarDistance: 5,
                        axisX: {
                            labelInterpolationFnc: function(value) {
                                return value[0];
                            }
                        }
                    }]
                ];
                var dailyRevenueChart = Chartist.Bar('#dailyRevenueChart', datadailyRevenueChart,
                    optionsdailyRevenueChart, responsiveOptions);

                //start animation for the daily revenue Chart
                md.startAnimationForBarChart(dailyRevenueChart);
            }
        };
    </script>
@endpush
