@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('Registered Users')])

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
                            <h4 class="card-title ">User Details</h4>
                            <p class="card-category">Detailed Information of Users</p>
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
                                                    <i class="material-icons">star</i> Rating
                                                </th>
                                                <th class="text-right">
                                                    Actions
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
                                                        {{ $data->rating_avg_rating == 0 ? 'N/A' : round($data->rating_avg_rating, 1) }}
                                                    </td>
                                                    <td class="td-actions text-right">
                                                        <a href="{{ route('delete.client', $data->id) }}">
                                                            <button type="button" rel="tooltip" title="Remove User"
                                                                class="btn btn-danger btn-link btn-sm">
                                                                <i class="material-icons">delete</i>
                                                            </button>
                                                        </a>
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
