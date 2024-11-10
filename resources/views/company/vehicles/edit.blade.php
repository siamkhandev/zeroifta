@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        <div class="sec1-style">
        <form method="post" action="{{route('vehicle.update',$vehicle->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="row pt-3">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Vehicle Type</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="Vehicle Type" name="vehicle_type" value="{{$vehicle->vehicle_type}}"/>
                    </div>
                    @error('vehicle_type')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Vehicle Number</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Vehicle Number" name="vehicle_number" value="{{$vehicle->vehicle_number}}" />
                    </div>
                    @error('vehicle_number')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Odometer Reading</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Odometer Reading" name="odometer_reading" value="{{$vehicle->odometer_reading}}" />
                    </div>
                    @error('odometer_reading')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">MPG</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="Add MPG" name="mpg" value="{{$vehicle->mpg}}" />
                    </div>
                    @error('mpg')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Fuel Tank Capacity</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Fuel Tank Capacity" name="fuel_tank_capacity" value="{{$vehicle->fuel_tank_capacity}}" />
                    </div>
                    @error('fuel_tank_capacity')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Profile Picture</label>
                        <input type="file" name="image" class="form-control login-input" accept="image/png, image/jpg, image/jpeg">

                    </div>
                    @error('image')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        @if($vehicle->vehicle_image)
                    <img src="{{asset('vehicles')}}/{{$vehicle->vehicle_image}}" style="height: 100px;">
                @endif
                </div>


            </div>
            <div class="buttons mt-5">
                <a href="{{route('allvehicles')}}" class="cancelBtn">Cancel</a>
                <button type="submit"  class="mainBtn">Submit</a>
            </div>
        </div>
    </div>
</div>


@endsection
