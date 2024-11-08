@extends('layouts.main')
@section('content')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Edit Vehicle</p>
              </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('vehicle.update',$vehicle->id)}}" enctype="multipart/form-data">
                    @csrf
                    <p class="text-uppercase text-sm">Vehicle Information</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Vehicle Type</label>
                                <input class="form-control" type="text" name="vehicle_type" value="{{$vehicle->vehicle_type}}">
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
                                <input class="form-control" type="text" name="vehicle_number" value="{{$vehicle->vehicle_number}}">
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
                                <input class="form-control" type="text" name="odometer_reading" value="{{$vehicle->odometer_reading}}">
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
                                <input class="form-control" type="text" name="mpg" value="{{$vehicle->mpg}}">
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
                                    <input class="form-control" type="text" name="fuel_tank_capacity" value="{{$vehicle->fuel_tank_capacity}}">
                                </div>
                            @error('fuel_tank_capacity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/png, image/jpg, image/jpeg">
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            @if($vehicle->vehicle_image)
                                <img src="{{asset('vehicles')}}/{{$vehicle->vehicle_image}}" style="height: 100px;">
                            @endif
                        
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