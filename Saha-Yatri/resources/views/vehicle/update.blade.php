@extends('layouts.app', ['activePage' => 'update-driver', 'titlePage' => __('Update Vehicle Information')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-12 text-left">
                <a href="{{ route('manage.driver') }}" class="btn btn-sm btn-primary">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('vehicle.update') }}" autocomplete="off" class="form-horizontal">
                        @csrf
                        <div class="card ">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">{{ __('Add Vehicle') }}</h4>
                                <p class="card-category">{{ __('Driver\'s vehicle information') }}</p>
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
                                    <label class="col-sm-2 col-form-label">{{ __('Vehicle No') }}</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('vehicle_no') ? ' has-danger' : '' }}">
                                            <input
                                                class="form-control{{ $errors->has('vehicle_no') ? ' is-invalid' : '' }}"
                                                name="vehicle_no" id="vehicle_no" type="text"
                                                placeholder="{{ __('XX-X-AB-XXXX') }}"
                                                value="{{ old('vehicle_no', $vehicle->vehicle_no) }}" required="true"
                                                aria-required="true" />
                                            @if ($errors->has('vehicle_no'))
                                                <span id="name-error" class="error text-danger"
                                                    for="input-name">{{ $errors->first('vehicle_no') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <input class="form-control" name="id" id="id" type="hidden" value="{{ $vehicle->id }}"
                                    required />
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">{{ __('Vehicle Type') }}</label>
                                    <div class="col-sm-7 col-form-label">
                                        <select id="inputState" class="form-control" name="vehicle_type" required>
                                            @foreach ($vehicle_types as $vt)
                                                <option value="{{ $vt->id }}"
                                                    {{ old('vehicle_type', $vehicle->vehicle_type_id) == $vt->id ? 'selected' : '' }}>
                                                    {{ $vt->vehicle_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary">{{ __('Confirm') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
