@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        <div class="sec1-style">
        <form method="post" action="{{route('driver_vehicles.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row pt-3">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Driver')}}</label>
                        <select name="driver_id" class="form-control login-input" required>
                              <option value="">Select</option>
                              @foreach($drivers as $driver)
                              <option value="{{$driver->driver->id}}">{{$driver->driver->name}}</option>
                              @endforeach
                            </select>
                    </div>
                    @error('driver_id')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Vehicle')}}</label>
                        <select name="vehicle_id" class="form-control login-input" required>
                        <option value="">Select</option>
                        @foreach($vehicles as $vehicle)
                        <option value="{{$vehicle->id}}">{{$vehicle->license_plate_number}} - {{$vehicle->make}} - {{$vehicle->model}} - {{$vehicle->make_year}}</option>
                        @endforeach
                      </select>
                    </div>
                    @error('vehicle_id')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

            </div>
            <div class="buttons mt-5">
                <a href="{{route('driver_vehicles')}}" class="cancelBtn">{{__('messages.Cancel')}}</a>
                <button type="submit"  class="mainBtn">{{__('messages.Submit')}}</a>
            </div>
        </div>
    </div>
</div>

@endsection
