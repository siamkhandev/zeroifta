@extends('layouts.new_main')
@section('content')

<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        <div class="sec1-style">
        <form method="post" action="{{route('driver_vehicles.update',$vehicle->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="row pt-3">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Driver')}}</label>
                        <select name="driver_id" class="form-control login-input" >
                              <option value="">Select</option>
                              @foreach($drivers as $driver)
                              <option value="{{$driver->driver->id}}" {{$vehicle->driver_id ==$driver->driver->id ? 'selected':'' }}>{{$driver->driver->name}}</option>
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
                        <select name="vehicle_id" class="form-control login-input" >
                        <option value="">Select</option>
                        @foreach($vehicles as $vehicle1)
                        <option value="{{$vehicle1->id}}" {{$vehicle->vehicle_id ==$vehicle1->id ? 'selected':'' }}>{{$vehicle1->vehicle_number}}</option>
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
                <a href="{{route('driver_vehicles')}}" class="cancelBtn">Cancel</a>
                <button type="submit"  class="mainBtn">Submit</a>
            </div>
        </div>
    </div>
</div>
@endsection
