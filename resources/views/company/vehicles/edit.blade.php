@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        {{dd($vehicle)}}
        <div class="sec1-style">
        <form method="post" action="{{route('vehicle.update',$vehicle->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="row pt-3">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Vehicle ID')}}</label>
                        <input type="text" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Vehicle ID" name="vehicle_id" value="{{$vehicle->vehicle_id}}"/>
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
                        <input type="text" required class="form-control login-input" id="vinInput" placeholder="Vin" name="vin" value="{{$vehicle->vin}}"/>
                    </div>
                    @error('vin')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <button type="button" id="checkVinBtn" class="btn btn-primary">Check VIN</button>
                </div>


                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Vehicle Model')}}</label>
                        <select name="year" id="year" class="form-control login-input">
                            <option value="">Select Year</option>
                            @for ($year = date('Y'); $year >= 1970; $year--)
                                <option value="{{ $year }}" {{ $vehicle->year == $year ? 'selected' : ''}}>{{ $year }}</option>
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
                            <option value="ford" {{ $vehicle->truck_make == 'ford' ? 'selected' : ''}}>Ford</option>
                            <option value="chevrolet" {{ $vehicle->truck_make == 'chevrolet' ? 'selected' : ''}}>Chevrolet</option>
                            <option value="ram" {{ $vehicle->truck_make == 'ram' ? 'selected' : ''}}>Ram</option>
                            <option value="gmc" {{ $vehicle->truck_make == 'gmc' ? 'selected' : ''}}>GMC</option>
                            <option value="jeep" {{ $vehicle->truck_make == 'jeep' ? 'selected' : ''}}>Jeep</option>
                            <option value="dodge" {{ $vehicle->truck_make == 'dodge' ? 'selected' : ''}}>Dodge</option>
                            <option value="international" {{ $vehicle->truck_make == 'international' ? 'selected' : ''}}>International</option>
                            <option value="peterbilt" {{ $vehicle->truck_make == 'peterbilt' ? 'selected' : ''}}>Peterbilt</option>
                            <option value="kenworth" {{ $vehicle->truck_make == 'kenworth' ? 'selected' : ''}}>Kenworth</option>
                            <option value="freightliner" {{ $vehicle->truck_make == 'freightliner' ? 'selected' : ''}}>Freightliner</option>
                            <option value="mack" {{ $vehicle->truck_make == 'mack' ? 'selected' : ''}}>Mack</option>
                            <option value="western-star" {{ $vehicle->truck_make == 'western-star' ? 'selected' : ''}}>Western Star</option>
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
                        <input type="text" required class="form-control login-input" id="vehicle_model_type" placeholder="Add Vehicle Model" name="vehicle_model" value="{{$vehicle->vehicle_model}}" />
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
                            <option value="gasoline" {{ $vehicle->fuel_type == 'gasoline' ? 'selected' : ''}}>Gasoline</option>
                            <option value="diesel" {{ $vehicle->fuel_type == 'diesel' ? 'selected' : ''}}>Diesel</option>
                        </select>
                    </div>
                    @error('fuel_type')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                @php
                $states = [
                    'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California',
                    'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'DC' => 'District Of Columbia',
                    'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois',
                    'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana',
                    'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan',
                    'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska',
                    'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico',
                    'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio',
                    'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island',
                    'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas',
                    'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington',
                    'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming'
                ];
                @endphp
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.License State')}}</label>
                        <select name="license_state" id="license_state" class="form-control login-input">
                            <option value="">Select License State</option>
                            <?php foreach ($states as $abbr => $name): ?>
                                <option value="<?= $abbr ?>" <?= $vehicle->license_state === $abbr ? 'selected' : '' ?>>
                                    <?= $name ?>
                                </option>
                            <?php endforeach; ?>
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
                        <input type="text" required  class="form-control login-input" id="exampleFormControlInput1" placeholder="Add License Number" name="license_number" value="{{$vehicle->license_number}}" />
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
                        <input type="text" required  class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Odometer Reading" name="odometer_reading" value="{{$vehicle->odometer_reading}}" />
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
                        <input type="text" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Add MPG" name="mpg" value="{{$vehicle->mpg}}" />
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
                        <input type="text" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Fuel Tank Capacity" name="fuel_tank_capacity" value="{{$vehicle->fuel_tank_capacity}}" />
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
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Secondary Fuel Tank Capacity" name="secondary_fuel_tank_capacity" value="{{$vehicle->secondary_fuel_tank_capacity}}" />
                    </div>
                    @error('secondary_fuel_tank_capacity')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Image')}}</label>
                        <input type="file"  name="image" class="form-control login-input" accept="image/png, image/jpg, image/jpeg">

                    </div>
                    @error('image')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                 @if($vehicle->image)
                                <img src="{{asset('images')}}/{{$vehicle->image}}" alt="ZeroIfta Image" style="height: 30px;border-radius:100%" />
                 @endif

            </div>
            <div class="buttons mt-5">
                <a href="{{route('allvehicles')}}" class="cancelBtn">{{__('messages.Cancel')}}</a>
                <button type="submit"  class="mainBtn">{{__('messages.Submit')}}</a>
            </div>
        </div>
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

        if (data.success) {
            // Populate vehicle details

            document.getElementById('truck_make').value = data.data.make.toLowerCase(); // Match make by value
            document.getElementById('year').value = data.data.year; // Match year by value
            document.getElementById('vehicle_model_type').value = data.data.model; // Set model input
        } else {

            alert(data.message);
            document.getElementById('truck_make').value = ''; // Match make by value
            document.getElementById('year').value =''; // Match year by value
            document.getElementById('vehicle_model_type').value = ''; // Set model input
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>
@endsection
