@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        <div class="sec1-style">
        <form method="post" action="{{route('vehicle.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row pt-3">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Vehicle ID')}}</label>
                        <input type="text" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Vehicle ID" name="vehicle_id" value="{{old('vehicle_id')}}"/>
                    </div>
                    @error('vehicle_id')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.VIN')}}</label>
                        <input type="text" required class="form-control login-input" id="vinInput" placeholder="Vin" name="vin" value="{{old('vin')}}"/>
                    </div>
                    @error('vin')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button type="button" id="checkVinBtn" class="btn btn-primary">Check VIN</button>
                </div>

                <!-- <div id="vehicleInfo" style="display: none;">
                    <h3>Vehicle Information</h3>
                    <p><strong>Make:</strong> <span id="make"></span></p>
                    <p><strong>Model:</strong> <span id="model"></span></p>
                    <p><strong>Year:</strong> <span id="year"></span></p>
                </div> -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Vehicle Model')}}</label>
                        <select name="year" id="year" class="form-control login-input">
                            <option value="">Select Year</option>
                            @for ($year = date('Y'); $year >= 1970; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>

                    </div>
                    @error('year')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Vehicle Make')}}</label>
                        <select name="truck_make" id="truck_make" class="form-control login-input">
                            <option value="">Select Truck Make</option>
                            <option value="ford">Ford</option>
                            <option value="chevrolet">Chevrolet</option>
                            <option value="ram">Ram</option>
                            <option value="gmc">GMC</option>
                            <option value="jeep">Jeep</option>
                            <option value="dodge">Dodge</option>
                            <option value="international">International</option>
                            <option value="peterbilt">Peterbilt</option>
                            <option value="kenworth">Kenworth</option>
                            <option value="freightliner">Freightliner</option>
                            <option value="mack">Mack</option>
                            <option value="western-star">Western Star</option>
                        </select>
                    </div>
                    @error('truck_make')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Vehicle Model')}}</label>
                        <input type="text" required class="form-control login-input" id="vehicle_model_type" placeholder="Add Vehicle Model" name="vehicle_model" value="{{old('vehicle_model')}}" />
                    </div>
                    @error('vehicle_model')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Fuel Type')}}</label>
                        <select name="fuel_type" id="fuel_type" class="form-control login-input">
                            <option value="">Select Fuel Type</option>
                            <option value="gasoline">Gasoline</option>
                            <option value="diesel">Diesel</option>
                        </select>
                    </div>
                    @error('fuel_type')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.License State')}}</label>
                        <select name="license_state" id="license_state" class="form-control login-input">
                            <option value="">Select License State</option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>

                        </select>
                    </div>
                    @error('license_state')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.License Number')}}</label>
                        <input type="text" required  class="form-control login-input" id="exampleFormControlInput1" placeholder="Add License Number" name="license_number" value="{{old('license_number')}}" />
                    </div>
                    @error('license_number')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Odometer Reading')}}</label>
                        <input type="text" required  class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Odometer Reading" name="odometer_reading" value="{{old('odometer_reading')}}" />
                    </div>
                    @error('odometer_reading')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.MPG')}}</label>
                        <input type="text" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Add MPG" name="mpg" value="{{old('mpg')}}" />
                    </div>
                    @error('mpg')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Fuel Tank Capacity')}}</label>
                        <input type="text" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Fuel Tank Capacity" name="fuel_tank_capacity" value="{{old('fuel_tank_capacity')}}" />
                    </div>
                    @error('fuel_tank_capacity')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Secondary Fuel Tank Capacity')}}</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Secondary Fuel Tank Capacity" name="secondary_fuel_tank_capacity" value="{{old('secondary_fuel_tank_capacity')}}" />
                    </div>
                    @error('secondary_fuel_tank_capacity')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Profile Picture')}}</label>
                        <input type="file" required name="image" class="form-control login-input" accept="image/png, image/jpg, image/jpeg">

                    </div>
                    @error('image')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>


            </div>
            <div class="buttons mt-5">
                <a href="{{route('allvehicles')}}" class="cancelBtn">{{__('messages.Cancel')}}</a>
                <button type="submit"  class="mainBtn">{{__('messages.Submit')}}</a>
            </div>
        </div>
        </form>
    </div>
</div>


@endsection
@section('scripts')
<script>
document.getElementById('checkVinBtn').addEventListener('click', function () {
    const vin = document.getElementById('vinInput').value;

    fetch("{{ route('vehicle.checkVin') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ vin })
    })
    .then(response => response.json())
    .then(data => {
    console.log(data);
        if (data.success) {
            // Populate vehicle details
            $("#vehicleInfo").show();
            document.getElementById('truck_make').value = data.data.make.toLowerCase(); // Match make by value
            document.getElementById('year').value = data.data.year; // Match year by value
            document.getElementById('vehicle_model_type').value = data.data.model; // Set model input
        } else {
            $("#vehicleInfo").hide();
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>
@endsection
