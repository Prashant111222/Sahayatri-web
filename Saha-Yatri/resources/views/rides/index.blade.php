@extends('layouts.app', ['activePage' => 'rides', 'titlePage' => __('Manage Driver')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-12 text-left">
                <a href="{{ route('home') }}" class="btn btn-sm btn-primary">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Ride Details</h4>
                            <p class="card-category">Detailed information of rides</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="col-md-12">
                                    <table class="table" id="dataTable">
                                        <thead class=" text-primary">
                                            <tr>
                                                <th>
                                                    Driver
                                                </th>
                                                <th>
                                                    Client
                                                </th>
                                                <th>
                                                    Origin
                                                </th>
                                                <th>
                                                    Destination
                                                </th>
                                                <th>
                                                    Total Distance
                                                </th>
                                                <th>
                                                    Total Price
                                                </th>
                                                <th>
                                                    Type
                                                </th>
                                                <th class="text-right">
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $data)
                                                <tr>
                                                    <td>
                                                        {{ $data->driver->user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $data->client->user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $data->location->origin }}
                                                    </td>
                                                    <td>
                                                        {{ $data->location->destination }}
                                                    </td>
                                                    <td>
                                                        {{ $data->location->total_distance }}
                                                    </td>
                                                    <td>
                                                        {{ $data->total_fare }}
                                                    </td>
                                                    <td class="td-actions">
                                                        @if ($data->ride_type == 'intercity')
                                                            <button type="button" rel="tooltip" title="Intercity"
                                                                class="btn btn-primary btn-link btn-sm">
                                                                <i class="material-icons">local_taxi</i>
                                                            </button>
                                                        @else
                                                            <button type="button" rel="tooltip" title="Parcel"
                                                                class="btn btn-primary btn-link btn-sm">
                                                                <i class="material-icons">local_shipping</i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td class="td-actions">
                                                        @if ($data->status == 'completed')
                                                            <div class="btn btn-sm btn-success" rel="tooltip"
                                                                title="Completed Ride">
                                                                Completed
                                                            </div>
                                                        @elseif ($data->status == 'pending')
                                                            <div class="btn btn-sm btn-info" rel="tooltip"
                                                                title="Pending Ride">
                                                                Pending
                                                            </div>
                                                        @else
                                                            <div class="btn btn-sm btn-danger" rel="tooltip"
                                                                title="Cancelled Ride">
                                                                Cancelled
                                                            </div>
                                                        @endif
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
@endsection
