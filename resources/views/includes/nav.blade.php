<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            @if(Request::is('/'))
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
          @elseif(Request::is('profile'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Profile</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Profile</h6>
          @elseif(Request::is('companies'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Companies</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Companies</h6>
          @elseif(Request::is('plans'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Subscriptions</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Subscriptions</h6>
          @elseif(Request::is('payments'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Payments</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Payments</h6>
          @elseif(Request::is('fuel_taxes'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Fuel Taxes</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Fuel Taxes</h6>
          @elseif(Request::is('contactus/all'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Contact Us</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Contact Us</h6>
          @elseif(Request::is('drivers'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Drivers</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Drivers</h6>
          @elseif(Request::is('vehicles/all'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Vehicles</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Vehicles</h6>
          @elseif(Request::is('driver/vehicles'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Driver Vehicles</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Driver Vehicles</h6>
          @elseif(Request::is('subscribe'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Subscribe</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Subscribe</h6>
          @elseif(Request::is('contactus'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Contact us</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Contact us</h6>
          @elseif(Request::is('plans/create'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Create Plan</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Create Plan</h6>
          @elseif(Route::is('plans.edit'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Edit Plan</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Edit Plan</h6>
          @elseif(Route::is('companies.edit'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Edit Company</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Edit Company</h6>
          @elseif(Route::is('fuel_taxes.create'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Create Fuel Tax</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Create Fuel Tax</h6>
          @elseif(Route::is('fuel_taxes.edit'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Edit Fuel Tax</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Edit Fuel Tax</h6>
          @elseif(Route::is('vehicles.create'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Create Vehicle</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Create Vehicle</h6>
          @elseif(Route::is('vehicles.edit'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Edit Vehicle</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Edit Vehicle</h6>
          @elseif(Route::is('driver_vehicles.add'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Assign Vehicle</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Assign Vehicle</h6>
          @elseif(Route::is('driver_vehicles.edit'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Edit Assign Vehicle</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Edit Assign Vehicle</h6>
          @elseif(Route::is('contactform.detail'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Read Contact Form</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Read Contact Form</h6>
          @elseif(Route::is('drivers.create'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Create Driver</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Create Driver</h6>
          @elseif(Route::is('drivers.edit'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Edit Driver</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Edit Driver</h6>
          @elseif(Route::is('vehicle.edit'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Edit Vehicle</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Edit Vehicle</h6>
          @elseif(Route::is('purchase'))
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Purchase Subscription</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">>Purchase Subscription</h6>
          @endif
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              
            
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            @if(Auth::user())
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                
                <span class="d-sm-inline d-none">
                    <a href="{{route('logout')}}" style="color: white;">Logout</a>
                </span>
              </a>
            </li>
            @endif
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
           
          </ul>
        </div>
      </div>
    </nav>