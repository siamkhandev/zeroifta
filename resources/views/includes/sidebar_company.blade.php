<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="# " target="_blank">
        <img src="{{asset('assets/img/logo-ct-dark.png')}}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Zeroifta</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('fleet') ? 'active' : '' }}" href="{{route('fleet')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-bus-front-12 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Fleet View</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{route('profile')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Profile Management</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('drivers.all') ? 'active' : '' }}" href="{{route('drivers.all')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Drivers</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('vehicles/all*') ? 'active' : '' }}" href="{{route('allvehicles')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-delivery-fast text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Vehicles</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('driver/vehicles*') ? 'active' : '' }}" href="{{route('driver_vehicles')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-bus-front-12 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Driver Vehicles</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('subscribe') ? 'active' : '' }}" href="{{route('subscribe')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-collection text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Subscriptions</span>
          </a>
        </li>
       
        <li class="nav-item">
          <a class="nav-link {{ Route::is('company.contactus') ? 'active' : '' }} " href="{{route('company.contactus')}}">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-email-83 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Contact Us</span>
          </a>
        </li>
        
        
      </ul>
    </div>
   
  </aside>