@extends('layouts.new_main')
@section('content')
    <div class="dash-countMain">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                <div class="t-comp comm-counts">
                    <div class="dc_inn">
                        <div>
                            <img src="assets/img/company.png" alt="ZeroIfta Image" />
                        </div>
                        @if(Auth::user()->role=="admin")
                        <div class="count-content">
                            <h5 class="head-16Med grayMain">Total Companies</h5>
                            <h6 class="head-24Med blue">{{\App\Models\User::whereRole('company')->count()??0}}</h6>
                        </div>
                        @else
                        <div class="count-content">
                            <h5 class="head-16Med grayMain">Total Drivers</h5>
                            <h6 class="head-24Med blue">{{\App\Models\CompanyDriver::where('company_id',Auth::id())->count()??0}}</h6>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                <div class="t-subs comm-counts">
                    <div class="dc_inn">
                        <div>
                            <img src="assets/img/subscription.png" alt="ZeroIfta Image" />
                        </div>
                        @if(Auth::user()->role=="admin")
                        <div class="count-content">
                            <h5 class="head-16Med grayMain">Subscription</h5>
                            <h6 class="head-24Med blue">{{\App\Models\Payment::count()??0}}</h6>
                        </div>
                        @else
                        <div class="count-content">
                            <h5 class="head-16Med grayMain">Total Vehicles</h5>
                            <h6 class="head-24Med blue">{{\App\Models\Vehicle::where('company_id',Auth::id())->count()??0}}</h6>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                <div class="t-paym comm-counts">
                    <div class="dc_inn">
                        <div>
                            <img src="assets/img/payment.png" alt="ZeroIfta Image" />
                        </div>
                        @if(Auth::user()->role=="admin")
                        <div class="count-content">
                            <h5 class="head-16Med grayMain">Payments</h5>
                            <h6 class="head-24Med blue">{{\App\Models\Payment::count()??0}}</h6>
                        </div>
                        @else
                        <div class="count-content">
                            <h5 class="head-16Med grayMain">Driver Vehicles</h5>
                            <h6 class="head-24Med blue">{{\App\Models\DriverVehicle::where('company_id',Auth::id())->count()??0}}</h6>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-4">
                <div class="t-form comm-counts">
                    <div class="dc_inn">
                        <div>
                            <img src="assets/img/contact.png" alt="ZeroIfta Image" />
                        </div>
                        @if(Auth::user()->role=="admin")
                        <div class="count-content">
                            <h5 class="head-16Med grayMain">Contact Form</h5>
                            <h6 class="head-24Med blue">{{\App\Models\CompanyContactUs::count()??0}}</h6>
                        </div>
                        @else
                        <div class="count-content">
                            <h5 class="head-16Med grayMain">Contact Form</h5>
                            <h6 class="head-24Med blue">{{\App\Models\Contactus::where('company_id',Auth::id())->count()??0}}</h6>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dashbord-inner">
        <!-- Section 1 -->
        <div class="chart-area mb-4">
            <div class="sec1-style">
                <div class="inHead-span">
                    <h2 class="head-20Med">@if(Auth::user()->role=='admin')
                Companies overview
                @else
                Drivers overview
                @endif</h2>
                </div>
                <div>
                <div class="chart">
                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
              </div>
                </div>
            </div>
        </div>
        <!-- Section 2 -->
        <div class="table-area mb-4">
            <div class="row">
            @if(Auth::user()->role=='admin')
                <div class="col-lg-6 col-md-12 col.sm-12 col-12 mb-4">
                    @else
                    <div class="col-lg-12 col-md-12 col.sm-12 col-12 mb-4">
                    @endif
                    <div class="sec1-style">
                        <div class="inHead-span">
                            <h2 class="head-20Med">@if(Auth::user()->role=='admin')
                                Companies overview
                                @else
                                Drivers overview
                                @endif</h2>
                        </div>
                        @if(Auth::user()->role=='admin')
                        <div class="table-span table-responsive">
                            <table class="table table-comm">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $record)
                                    <tr>
                                        <td>{{$record->name}}</td>
                                        <td>{{$record->email}}</td>
                                        <td>{{$record->phone}}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="table-span table-responsive">
                            <table class="table table-comm">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $record)
                                    <tr>
                                        <td>{{$record->driver->name ??'N/A'}}</td>
                                        <td>{{$record->driver->email??'N/A'}}</td>
                                        <td>{{$record->driver->phone??'N/A'}}</td>
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
                <div class="col-lg-6 col-md-12 col.sm-12 col-12 mb-4">
                    <div class="sec1-style">
                        <div class="inHead-span">
                            <h2 class="head-20Med">Contact Forms</h2>
                        </div>
                        <div>
                        @foreach($contacts as $con)
                            <div class="form_div mb-3">
                                <div class="user-area">
                                    <div>
                                    @if($con->company->image)
                                        <img src="{{asset('images')}}/{{$con->company->image}}" alt="kal" class="border-radius-lg shadow" style="height: 50px;">
                                        @else
                                        <img src="{{asset('images/com.png')}}" alt="kal" class="border-radius-lg shadow" style="height: 50px;">
                                    @endif
                                    </div>
                                    <div class="fc-content">
                                        <h6 class="head-16 grayWhite">{{$con->company->name??'N/A'}}</h6>
                                        <p class="gray1 font-14">
                                        {{$con->description ? Str::limit($con->message,20,'...'):'N/A'}}
                                        </p>
                                    </div>
                                </div>
                                <div class="ub-div">
                                    <a class="blueBtn" href="{{route('admin.contactus')}}">
                                        <span class="">View Detail</span>
                                        <span class="grayfilled-svg">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="">
                                                <path d="m560-240-56-58 142-142H160v-80h486L504-662l56-58 240 240-240 240Z" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                           @endforeach

                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

@endsection
