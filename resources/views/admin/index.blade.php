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
                      {{\App\Models\User::whereRole('company')->count()??0}}
                    </h5>
                   @else
                   <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Drivers</p>
                    <h5 class="font-weight-bolder">
                      {{\App\Models\User::whereRole('driver')->count()??0}}
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
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Fuel Taxes</p>
                    <h5 class="font-weight-bolder">
                    {{\App\Models\FuelTax::count()??0}}
                    </h5>
                   @else
                   <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Vehicles</p>
                    <h5 class="font-weight-bolder">
                    {{\App\Models\Vehicle::where('company_id',Auth::id())->count()??0}}
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
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Plans</p>
                    <h5 class="font-weight-bolder">
                   {{\App\Models\Plan::count()??0}}
                    </h5>
                   @else
                   <p class="text-sm mb-0 text-uppercase font-weight-bold">Driver Vehicles</p>
                    <h5 class="font-weight-bolder">
                    {{\App\Models\DriverVehicle::where('company_id',Auth::id())->count()??0}}
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
                    {{\App\Models\CompanyContactUs::count()??0}}
                    </h5>
                    @else
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Contact Forms</p>
                    <h5 class="font-weight-bolder">
                    {{\App\Models\Contactus::count()??0}}
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
        <div class="col-lg-12 mb-lg-0 mb-4">
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
          </div>
        </div>
        
</div>
@endsection