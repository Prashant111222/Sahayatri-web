@extends('layouts.app', ['activePage' => 'update-rate', 'titlePage' => __('Update Vehicle and Fare Rates')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-12 text-left">
                <a href="{{ route('home') }}" class="btn btn-sm btn-primary">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('vehicleType.store') }}" autocomplete="off"
                        class="form-horizontal">
                        @csrf
                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Add Vehicle') }}</h4>
                                <p class="card-category">{{ __('Vehicle and fare rate') }}</p>
                            </div>
                            <div class="card-body ">
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

                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Vehicle Type') }}</label>
                                    <div class="col-sm-7 col-form-label">
                                        <div class="form-group{{ $errors->has('vehicle_type') ? ' has-danger' : '' }}">
                                            <select id="inputState" class="form-control" name="vehicle_type" required>
                                                <option selected disabled value="">----Select vehicle type---</option>
                                                <option value="bike">Bike</option>
                                                <option value="cab">Cab</option>
                                                <option value="tempo">Tempo</option>
                                            </select>
                                            @if ($errors->has('vehicle_type'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-name">{{ $errors->first('vehicle_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Fare Rate') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('fare_rate') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('fare_rate') ? ' is-invalid' : '' }}"
                                                name="fare_rate" id="fare_rate" type="numeric"
                                                placeholder="{{ __('Rate per Km') }}" value="{{ old('fare_rate') }}"
                                                required="true" aria-required="true" />
                                            @if ($errors->has('fare_rate'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-name">{{ $errors->first('fare_rate') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Added Vehicles</h4>
                            <p class="card-category">Update Vehicles or Rates</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="col-md-12">
                                    <table class="table" id="dataTable">
                                        <thead class=" text-primary">
                                            <tr>
                                                <th>
                                                    Vehicle Type
                                                </th>
                                                <th>
                                                    Rate
                                                </th>
                                                <th class="text-right">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($vehicle_type as $vt)
                                                <tr>
                                                    <td>
                                                        {{ $vt->vehicle_type }}
                                                    </td>
                                                    <td>
                                                        {{ $vt->fare_rate }}
                                                    </td>
                                                    <td class="td-actions text-right">
                                                        <a href="{{ route('vehicleType.edit', $vt->id) }}"><button
                                                                type="button" rel="tooltip" title="Update Price"
                                                                class="btn btn-primary btn-link btn-sm">
                                                                <i class="material-icons">edit</i>
                                                            </button></a>
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
