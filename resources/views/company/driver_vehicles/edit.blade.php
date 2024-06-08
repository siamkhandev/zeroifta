@extends('layouts.main')
@section('content')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Assign Driver</p>
              </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('driver_vehicles.update',$vehicle->id)}}" enctype="multipart/form-data">
                    @csrf
                   
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Driver</label>
                            <select name="driver_id" class="form-control" style="height: 40px;">
                              <option value="">Select</option>
                              @foreach($drivers as $driver)
                              <option value="{{$driver->id}}" {{$vehicle->driver_id ==$driver->id ? 'selected':'' }}>{{$driver->name}}</option>
                              @endforeach
                            </select>
                            @error('driver_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Vehicle</label>
                                <select name="vehicle_id" class="form-control" style="height: 40px;">
                                  <option value="">Select</option>
                                  @foreach($vehicles as $vehicle1)
                                  <option value="{{$vehicle1->id}}" {{$vehicle->vehicle_id ==$vehicle1->id ? 'selected':'' }}>{{$vehicle1->vehicle_number}}</option>
                                  @endforeach
                                </select>
                            </div>
                            @error('vehicle_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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