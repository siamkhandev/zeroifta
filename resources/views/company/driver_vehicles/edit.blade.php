@extends('layouts.main')
@section('content')
<style>
  .invalid-feedback{
    display: block;
  }
</style>
<div class="row">
  <div class="col-md-12">
  @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{Session::get('error')}}</strong> 
              
                </div>
                @endif
  </div>
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{route('driver_vehicles.update',$vehicle->id)}}" enctype="multipart/form-data" method="post">
            @csrf
                    <label>Driver</label>
                    <div class="mb-3">
                      <select name="driver_id" class="form-control" style="height: 40px;">
                        <option value="">Select</option>
                        @foreach($drivers as $driver)
                        <option value="{{$driver->id}}" {{$vehicle->driver_id == $driver->id ? 'selected':''}}>{{$driver->name}}</option>
                        @endforeach
                      </select>
                      @error('driver_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <label>Vehicle</label>
                    <div class="mb-3">
                      <select name="vehicle_id" class="form-control" style="height: 40px;">
                        <option value="">Select</option>
                        @foreach($vehicles as $veh)
                        <option value="{{$veh->id}}" {{$vehicle->vehicle_id ==$veh->id ? 'selected':''}}>{{$veh->name}}</option>
                        @endforeach
                      </select>
                      @error('vehicle_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    
              
                    <div class="text-center">
                      <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Update</button>
                     
                    </div>
                  </form>
    </div>
    <div class="col-md-2"></div>
</div>
@endsection