@extends('layouts.main')
@section('content')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Add Vehicle</p>
              </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('vehicle.store')}}" enctype="multipart/form-data">
                    @csrf
                    <p class="text-uppercase text-sm">Vehicle Information</p>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Vehicle Type</label>
                            <input class="form-control" type="text" name="vehicle_type" placeholder="Vehicle Type">
                            @error('vehicle_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Vehicle Number</label>
                                <input class="form-control" type="text" name="vehicle_number" placeholder="Vehicle Number" value="{{old('vehicle_number')}}">
                            </div>
                            @error('vehicle_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Odometer Reading</label>
                                <input class="form-control" type="text" name="odometer_reading" placeholder="Odometer Reading" value="{{old('odometer_reading')}}">
                            </div>
                            @error('odometer_reading')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">MPG</label>
                                <input class="form-control" type="text" name="mpg" placeholder="MPG" value="{{old('mpg')}}">
                            </div>
                            @error('mpg')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Fuel Tank Capacity</label>
                                    <input class="form-control" type="text" name="fuel_tank_capacity" placeholder="Fuel Tank Capacity" value="{{old('fuel_tank_capacity')}}">
                                </div>
                            @error('fuel_tank_capacity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Image (PNG,JPG,JPEG only)</label>
                            <input type="file" name="image" class="form-control" accept="image/png, image/jpg, image/jpeg">
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        
                        </div>
                        
                        
                        
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" >Submit</button>
                </form>
              
             
            </div>
          </div>
        </div>
        
      </div>
     
    </div>

@endsection