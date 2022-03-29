@extends('layouts.app', ['activePage' => 'update-driver', 'titlePage' => __('Manage Driver')])

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
                            <h4 class="card-title ">Driver Details</h4>
                            <p class="card-category">Manage driver details</p>
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-label="Close">
                                                <i class="material-icons">close</i>
                                            </button>
                                            <span>{{ session('status') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <div class="col-md-12">
                                    <table class="table" id="dataTable">
                                        <thead class=" text-primary">
                                            <tr>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Phone
                                                </th>
                                                <th>
                                                    Availability
                                                </th>
                                                <th>
                                                    Actions
                                                </th>
                                                <th class="text-right">
                                                    Updating Details
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $data)
                                                <tr>
                                                    <td>
                                                        {{ $data->name }}
                                                    </td>
                                                    <td>
                                                        {{ $data->email }}
                                                    </td>
                                                    <td>
                                                        {{ $data->phone_no }}
                                                    </td>
                                                    <td>
                                                        @if ($data->driver->availability == 'on')
                                                            <div class="btn btn-sm btn-success" rel="tooltip"
                                                                title="online">
                                                                On
                                                            </div>
                                                        @else
                                                            <div class="btn btn-sm btn-danger" rel="tooltip"
                                                                title="offline">
                                                                Off
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="td-actions">
                                                        @if ($data->driver->status == 'active')
                                                            <a href="{{ route('display.driver', $data->id) }}"><button
                                                                    type="button" rel="tooltip" title="Update Driver"
                                                                    class="btn btn-primary btn-link btn-sm">
                                                                    <i class="material-icons">edit</i>
                                                                </button></a>
                                                        @else
                                                            <a href="#"><button type="button" rel="tooltip"
                                                                    title="Update Driver"
                                                                    class="btn btn-primary btn-link btn-sm" disabled>
                                                                    <i class="material-icons">edit</i>
                                                                </button></a>
                                                        @endif
                                                        <a href="{{ route('delete.driver', $data->id) }}">
                                                            <button type="button" rel="tooltip" title="Remove Driver"
                                                                class="btn btn-danger btn-link btn-sm">
                                                                <i class="material-icons">delete</i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                    <td class="td-actions text-right">
                                                        @if ($data->driver->status == 'active')
                                                            <a href="{{ route('driver.detail', $data->id) }}"
                                                                class="btn btn-sm btn-danger"><button type="button"
                                                                    rel="tooltip" title="Complete Details"
                                                                    class="btn btn-white btn-link btn-sm">
                                                                    <i class="material-icons">visibility</i>
                                                                    Details</button></a>
                                                        @else
                                                            <a href="{{ route('add.vehicle', $data->driver->id) }}"
                                                                class="btn btn-sm btn-info"><button type="button"
                                                                    rel="tooltip" title="Continue Updating"
                                                                    class="btn btn-white btn-link btn-sm">
                                                                    Continue</button></a>
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
