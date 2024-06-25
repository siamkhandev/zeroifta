@extends('layouts.main')
@section('content')
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
            @if(Session::has('success'))
                <div class="alert alert-success" style="color:white">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger" style="color:white">{{Session::get('error')}}</div>
            @endif
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Driver Vehicles table</h6>
              <a href="{{route('driver_vehicles.add')}}" class="btn btn-primary" style="float:right">Assign Vehicle</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Driver Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Vehicle Number</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Vehicle Image</th>
                     
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($vehicles) >0)
                    @foreach($vehicles as $vehicle)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                        <div>
                          @if($vehicle->driver->driver_image)
                          <img src="{{asset('drivers')}}/{{$vehicle->driver->driver_image}}" class="avatar avatar-sm me-3" alt="user1">
                          @else

                            <img src="{{asset('assets/img/team-2.jpg')}}" class="avatar avatar-sm me-3" alt="user1">
                            @endif
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{$vehicle->driver->name??'N/A'}}</h6>
                            <p class="text-xs text-secondary mb-0"></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$vehicle->vehicle->vehicle_number ?? 'N/A'}}</p>
                       
                      </td>
                      <td>
                        
                        <img src="{{asset('vehicles')}}/{{$vehicle->vehicle->vehicle_image}}" class="avatar avatar-sm me-3" alt="user1">
                        
                       
                      </td>
                     
                      <td class="align-middle">
                        <a href="{{route('driver_vehicles.edit',$vehicle->id)}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                        <a href="{{route('driver_vehicles.delete',$vehicle->id)}}"  class="btn btn-sm btn-danger" >
                          Delete
                        </a>
                      </td>
                    </tr>
                    
                   @endforeach
                   @else
                   <tr>
                    <td colspan="2" class="text-center">
                    <p>No records found</p>
                    </td>
                   </tr>
                  
                   @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    
    </div>
  @endsection