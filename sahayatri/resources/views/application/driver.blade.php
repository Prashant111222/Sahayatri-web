@extends('layouts.app', ['activePage' => 'driver-app', 'titlePage' => __('Driver Application')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-12 text-left">
                <a href="{{ route('home') }}" class="btn btn-sm btn-primary">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-body ">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
