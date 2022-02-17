@extends('layouts.app', ['activePage' => 'update-rate', 'titlePage' => __('Update Fare Rates')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-12 text-left">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('vehicleType.update', $vehicle_type->id) }}" autocomplete="off"
                        class="form-horizontal">
                        @csrf
                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Update Fare Rates') }}</h4>
                                <p class="card-category">{{ __('Add new fare rate') }}</p>
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
                                                <option selected value="{{ $vehicle_type->vehicle_type }}">{{ $vehicle_type->vehicle_type }}</option>
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
                                                value="{{ $vehicle_type->fare_rate }}"
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
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
