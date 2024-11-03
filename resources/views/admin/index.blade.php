@extends('layouts.main')
@section('content')
<div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    @if(Auth::user()->role=="admin")
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Companies</p>
                    <h5 class="font-weight-bolder">
                      <a href="{{route('companies')}}">{{\App\Models\User::whereRole('company')->count()??0}}</a>

                    </h5>
                   @else
                   <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Drivers</p>
                    <h5 class="font-weight-bolder">
                   
                    <a href="{{route('drivers.all')}}"> {{\App\Models\CompanyDriver::where('company_id',Auth::id())->count()??0}}</a>
                    </h5>
                   @endif
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-circle-08 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                  @if(Auth::user()->role=="admin")
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Subscriptions</p>
                    <h5 class="font-weight-bolder">
                  <a href="{{route('plans')}}">{{\App\Models\Payment::count()??0}}</a>
                    </h5>
                   @else
                   <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Vehicles</p>
                    <h5 class="font-weight-bolder">
                    <a href="{{route('allvehicles')}}"> {{\App\Models\Vehicle::where('company_id',Auth::id())->count()??0}}</a>
                    </h5>
                   @endif
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                  @if(Auth::user()->role=="admin")
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                    @else
                    <i class="ni ni-delivery-fast text-lg opacity-10" aria-hidden="true"></i>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                  @if(Auth::user()->role=="admin")
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Payments</p>
                    <h5 class="font-weight-bolder">
                    <a href="{{route('payments')}}">{{\App\Models\Payment::count()??0}}</a>
                    </h5>
                   @else
                   <p class="text-sm mb-0 text-uppercase font-weight-bold">Driver Vehicles</p>
                    <h5 class="font-weight-bolder">
                    <a href="{{route('driver_vehicles')}}"> {{\App\Models\DriverVehicle::where('company_id',Auth::id())->count()??0}}</a>
                    </h5>
                   @endif
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                  @if(Auth::user()->role=="admin")  
                  <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                    @else
                    <i class="ni ni-bus-front-12 text-lg opacity-10" aria-hidden="true"></i>
                   @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                  @if(Auth::user()->role=="admin")
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Contact Forms</p>
                    <h5 class="font-weight-bolder">
                    <a href="{{route('admin.contactus')}}">{{\App\Models\CompanyContactUs::count()??0}}</a>
                    </h5>
                    @else
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Contact Forms</p>
                    <h5 class="font-weight-bolder">
                    <a href="{{route('contactus')}}">{{\App\Models\Contactus::where('company_id',Auth::id())->count()??0}}</a>
                    </h5>
                    @endif
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-email-83 text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">
                @if(Auth::user()->role=='admin')
                Companies overview
                @else
                Drivers overview
                @endif
              </h6>
              
            </div>
            <div class="card-body p-3">
              <div class="chart">
                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      <div class="row mt-4">
        @if(Auth::user()->role=='admin')
        <div class="col-lg-7 mb-lg-0 mb-4">
          @else
          <div class="col-lg-12 mb-lg-0 mb-4">
          @endif
          <div class="card ">
            <div class="card-header pb-0 p-3">
              <div class="d-flex justify-content-between">
                <h6 class="mb-2">
                @if(Auth::user()->role=='admin')
                Companies 
                @else
                Drivers 
                @endif
                  
                </h6>
              </div>
            </div>
            @if(Auth::user()->role=='admin')
            <div class="table-responsive">
              <table class="table align-items-center ">
                <tbody>
                  @foreach($data as $record)
                  <tr>
                    <td class="w-30">
                      <div class="d-flex px-2 py-1 align-items-center">
                        
                        <div class="ms-4">
                          <p class="text-xs font-weight-bold mb-0">Name:</p>
                          <h6 class="text-sm mb-0">{{$record->name}}</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Email:</p>
                        <h6 class="text-sm mb-0">{{$record->email}}</h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Phone</p>
                        <h6 class="text-sm mb-0">{{$record->phone}}</h6>
                      </div>
                    </td>
                    
                  </tr>
                  @endforeach
                 
                </tbody>
              </table>
            </div>
            @else
            <div class="table-responsive">
              <table class="table align-items-center ">
                <tbody>
                  @foreach($data as $record)
                  <tr>
                    <td class="w-30">
                      <div class="d-flex px-2 py-1 align-items-center">
                        
                        <div class="ms-4">
                          <p class="text-xs font-weight-bold mb-0">Name:</p>
                          <h6 class="text-sm mb-0">{{$record->driver->name ??'N/A'}}</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Email:</p>
                        <h6 class="text-sm mb-0">{{$record->driver->email??'N/A'}}</h6>
                      </div>
                    </td>
                    <td>
                      <div class="text-center">
                        <p class="text-xs font-weight-bold mb-0">Phone</p>
                        <h6 class="text-sm mb-0">{{$record->driver->phone??'N/A'}}</h6>
                      </div>
                    </td>
                    
                  </tr>
                  @endforeach
                 
                </tbody>
              </table>
            </div>
            @endif
          </div>
        </div>
        @if(Auth::user()->role=='admin')
        @php 
        $contacts = \App\Models\CompanyContactUs::with('company')->take(5)->latest()->get();
        @endphp
        <div class="col-lg-5 col-xl-5">
          <div class="card h-100">
            <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Contact Forms</h6>
            </div>
            <div class="card-body p-3">
              <ul class="list-group">
                @foreach($contacts as $con)
                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                  <div class="avatar me-3">
                    @if($con->company->image)
                    <img src="{{asset('images')}}/{{$con->company->image}}" alt="kal" class="border-radius-lg shadow">
                    @else
                    <img src="{{asset('images/com.png')}}" alt="kal" class="border-radius-lg shadow">
                  @endif
                  </div>
                  <div class="d-flex align-items-start flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">{{$con->company->name??'N/A'}}</h6>
                    <p class="mb-0 text-xs">{{$con->description ? Str::limit($con->message,20,'...'):'N/A'}}</p>
                  </div>
                  <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="{{route('admin.contactus')}}">Detail</a>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        @endif
</div>
@endsection