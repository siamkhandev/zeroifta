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
              <h6>Drivers table</h6>
              <a href="{{route('drivers.create')}}" class="btn btn-primary" style="float:right">Add Driver</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">DOT</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">MC</th>
                     
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($drivers) > 0)
                    @foreach($drivers as $driver)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                        <!-- <div>
                            <img src="{{asset('vehicles')}}/{{$driver->vehicle_image}}" class="avatar avatar-sm me-3" alt="user1">
                          </div> -->
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{$driver->driver->name ?? 'N/A'}}</h6>
                            <p class="text-xs text-secondary mb-0"></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{$driver->driver->email ?? 'N/A'}}</p>
                       
                      </td>
                      <td class="align-middle ">
                        <span class="text-secondary text-xs font-weight-bold">{{$driver->driver->phone}}</span>
                      </td>
                      <td class="align-middle ">
                        <span class="text-secondary text-xs font-weight-bold">{{$driver->driver->dot}}</span>
                      </td>
                      <td class="align-middle ">
                        <span class="text-secondary text-xs font-weight-bold">{{$driver->driver->mc}}</span>
                      </td>
                      <td class="align-middle">
                        <a href="{{route('driver.edit',$driver->driver->id)}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                        <a href="{{route('driver.delete',$driver->driver->id)}}"  class="btn btn-sm btn-danger" >
                          Delete
                        </a>
                        <a href="{{route('driver.track',$driver->driver->id)}}" class="btn btn-sm btn-warning" data-user-id="{{ $driver->driver->id }}">
                          Track Driver
                        </a>
                      </td>
                    </tr>
                    
                   @endforeach
                   @else
                   <tr>
                    <td colspan="5" class="text-center">
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
 