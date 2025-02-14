<style>
  .bell-icon svg {
    width: 24px;
    height: 24px;
    color: #333;
  }

  .notification-container {
    position: relative;
  }

  #notificationDropdown {
    display: none;
    min-width: 200px;
    background: white;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    padding: 10px;
  }

  #notificationDropdown.hidden {
    display: none;
  }

</style>
<!-- Bootstrap JS (Required for Dropdown) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="">
  <div class="header-main">
    <div>

    <div class="head-left">
    <div class="bread_crum">
    @php
        $currentSegment2 = Request::segment(2); // Second segment
        $currentSegment3 = Request::segment(3); // Third segment
        $currentSegment4 = Request::segment(4); // Third segment
    @endphp

    @if($currentSegment2 == '')
        <span class="bc-text">{{__('messages.Pages / Dashboard')}}</span>
        <h1 class="head-1">{{__('messages.Main Dashboard')}}</h1>

    @elseif($currentSegment2 == 'fleet')
        <span class="bc-text">{{__('messages.Pages / Fleet Management')}}</span>
        <h1 class="head-1">{{__('messages.Fleet Management')}}</h1>

    @elseif($currentSegment2 == 'profile')
        <span class="bc-text">{{__('messages.Pages / Profile Management')}}</span>
        <h1 class="head-1">{{__('messages.Profile Management')}}</h1>
        @elseif($currentSegment2 == 'payment-methods')
        <span class="bc-text">{{__('messages.Pages / Payment Methods')}}</span>
        <h1 class="head-1">{{__('messages.Payment Methods')}}</h1>
    @elseif($currentSegment2 == 'vehicles')
        <span class="bc-text">{{__('messages.Pages / Vehicles')}}</span>
        <h1 class="head-1">{{__('messages.Manage Vehicles')}}</h1>

    @elseif($currentSegment2 == 'vehicle' && $currentSegment3 == 'create')
        <span class="bc-text">{{__('messages.Pages / Vehicles')}}</span>
        <h1 class="head-1">{{__('messages.Create Vehicles')}}</h1>

    @elseif($currentSegment2 == 'drivers' && $currentSegment3 == 'all')
        <span class="bc-text">{{__('messages.Pages / Drivers')}}</span>
        <h1 class="head-1">{{__('messages.Manage Drivers')}}</h1>

    @elseif($currentSegment2 == 'driver' && $currentSegment3 == 'vehicles')
        <span class="bc-text">{{__('messages.Pages / Driver Vehicles')}}</span>
        <h1 class="head-1">{{__('messages.Manage Driver Vehicles')}}</h1>

    @elseif($currentSegment2 == 'driver' && $currentSegment3 == 'vehicles/add')
        <span class="bc-text">{{__('messages.Pages / Driver Vehicles')}}</span>
        <h1 class="head-1">{{__('messages.Add Driver Vehicles')}}</h1>
        @elseif($currentSegment2 == 'company' && $currentSegment3 == 'contactus' && $currentSegment4 == 'all')
        <span class="bc-text">{{__('messages.Pages / Contact Forms')}}</span>
        <h1 class="head-1">{{__('messages.Contact Forms')}}</h1>

    @elseif($currentSegment2 == 'subscribe')
        <span class="bc-text">{{__('messages.Pages / Subscribe')}}</span>
        <h1 class="head-1">{{__('messages.Subscriptions')}}</h1>

    @elseif($currentSegment2 == 'company.contactus')
        <span class="bc-text">{{__('messages.Pages / Contact Us')}}</span>
        <h1 class="head-1">{{__('messages.Contact Us')}}</h1>

    @elseif($currentSegment2 == 'allvehicles')
        <span class="bc-text">{{__('messages.Pages / All Vehicles')}}</span>
        <h1 class="head-1">{{__('messages.All Vehicles')}}</h1>

    @elseif(str_contains($currentSegment2, 'fuel_taxes'))
        <span class="bc-text">{{__('messages.Pages / Fuel Taxes')}}</span>
        <h1 class="head-1">{{__('messages.Fuel Taxes')}}</h1>

    @elseif(str_contains($currentSegment2, 'payments'))
        <span class="bc-text">{{__('messages.Pages / Payments')}}</span>
        <h1 class="head-1">{{__('messages.Payments')}}</h1>

    @elseif(str_contains($currentSegment2, 'companies'))
        <span class="bc-text">{{__('messages.Pages / Companies')}}</span>
        <h1 class="head-1">{{__('messages.Companies')}}</h1>

    @elseif(str_contains($currentSegment2, 'plans'))
        <span class="bc-text">{{__('messages.Pages / Subscriptions')}}</span>
        <h1 class="head-1">{{__('messages.Subscriptions')}}</h1>


    @elseif($currentSegment2 == 'drivers' && $currentSegment3 == 'create')
        <span class="bc-text">{{__('messages.Pages / Create Driver')}}</span>
        <h1 class="head-1">{{__('messages.Create Driver')}}</h1>
        @elseif($currentSegment2 == 'contactus' && $currentSegment3 == 'all')
        <span class="bc-text">{{__('messages.Pages / Contact Forms')}}</span>
        <h1 class="head-1">{{__('messages.Contact Forms')}}</h1>
        @elseif($currentSegment2 == 'subscribe')
        <span class="bc-text">{{__('messages.Pages / Subscriptions')}}</span>
        <h1 class="head-1">{{__('messages.Subscriptions')}} </h1>

    @else
        <!-- Default case -->
    @endif
</div>

</div>

    </div>
    <div class="right-opts">

      <div class="head-right">
        <!-- <div class="search-div">
          <div class="serch-tab">
            <input type="text" placeholder="Type Here" name="" id="" />
            <span class="s-icon hs-svg">
              <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                <circle cx="5" cy="5" r="4.3" stroke="" stroke-width="1.4" />
                <line x1="10.0101" y1="11" x2="8" y2="8.98995" stroke="" stroke-width="1.4" stroke-linecap="round" />
              </svg>
            </span>
          </div>
        </div> -->
        <div class="opt-div">
          <div class="mob-menu">
            <div class="mobLogo-div">
              <!-- <svg xmlns="http://www.w3.org/2000/svg" width="162" height="45" viewBox="0 0 162 45" fill="none">
                <path d="M16.8035 10.0819V19.744L26.4656 4.20068H2.52051V10.0819H16.8035Z" fill="#092E75" />
                <path d="M9.66205 29.8263L9.66205 20.1642L9.53674e-06 35.7075L23.9451 35.7075L23.9451 29.8263L9.66205 29.8263Z" fill="#092E75" />
                <path d="M37.4142 36.3938C35.3925 36.3938 33.6465 35.9737 32.1762 35.1336C30.7146 34.2846 29.59 33.0856 28.8024 31.5366C28.0147 29.9787 27.6209 28.1452 27.6209 26.036C27.6209 23.9618 28.0147 22.1414 28.8024 20.5749C29.5988 18.9995 30.7103 17.7743 32.1368 16.8991C33.5634 16.0152 35.2393 15.5732 37.1648 15.5732C38.4075 15.5732 39.5803 15.7745 40.683 16.1771C41.7945 16.5709 42.7747 17.1835 43.6236 18.015C44.4813 18.8464 45.1552 19.9054 45.6453 21.1919C46.1354 22.4696 46.3805 23.9925 46.3805 25.7603V27.2175H29.8526V24.0143H41.8251C41.8164 23.1042 41.6194 22.2946 41.2344 21.5857C40.8493 20.8681 40.311 20.3036 39.6196 19.8922C38.937 19.4809 38.1406 19.2752 37.2304 19.2752C36.2589 19.2752 35.4056 19.5115 34.6705 19.9841C33.9353 20.448 33.3621 21.0606 32.9507 21.822C32.5482 22.5747 32.3425 23.4017 32.3337 24.3032V27.0994C32.3337 28.2721 32.5482 29.2786 32.977 30.1188C33.4058 30.9502 34.0053 31.5891 34.7755 32.0354C35.5457 32.473 36.4471 32.6918 37.4798 32.6918C38.1712 32.6918 38.797 32.5955 39.3571 32.403C39.9172 32.2017 40.4029 31.9085 40.8143 31.5234C41.2256 31.1383 41.5363 30.6614 41.7463 30.0925L46.1835 30.5914C45.9035 31.7641 45.3696 32.7881 44.5819 33.6633C43.803 34.5297 42.8053 35.2036 41.5888 35.6849C40.3723 36.1575 38.9808 36.3938 37.4142 36.3938ZM50.4008 36V15.8357H55.0087V19.1965H55.2187C55.5863 18.0325 56.2164 17.1354 57.1091 16.5053C58.0106 15.8664 59.0389 15.5469 60.1942 15.5469C60.4567 15.5469 60.7499 15.5601 61.0737 15.5863C61.4063 15.6038 61.682 15.6344 61.9008 15.6782V20.0498C61.6995 19.9797 61.38 19.9185 60.9424 19.866C60.5136 19.8047 60.0979 19.7741 59.6953 19.7741C58.8289 19.7741 58.0499 19.9622 57.3586 20.3386C56.6759 20.7061 56.1377 21.2181 55.7438 21.8745C55.35 22.5309 55.1531 23.2879 55.1531 24.1456V36H50.4008ZM73.0233 36.3938C71.0541 36.3938 69.3475 35.9606 67.9034 35.0942C66.4594 34.2278 65.3391 33.0156 64.5427 31.4578C63.7551 29.9 63.3612 28.0796 63.3612 25.9966C63.3612 23.9137 63.7551 22.0889 64.5427 20.5224C65.3391 18.9558 66.4594 17.7393 67.9034 16.8728C69.3475 16.0064 71.0541 15.5732 73.0233 15.5732C74.9924 15.5732 76.699 16.0064 78.1431 16.8728C79.5872 17.7393 80.703 18.9558 81.4907 20.5224C82.2871 22.0889 82.6853 23.9137 82.6853 25.9966C82.6853 28.0796 82.2871 29.9 81.4907 31.4578C80.703 33.0156 79.5872 34.2278 78.1431 35.0942C76.699 35.9606 74.9924 36.3938 73.0233 36.3938ZM73.0495 32.5868C74.1172 32.5868 75.0099 32.2936 75.7276 31.7072C76.4452 31.1121 76.9791 30.3157 77.3292 29.318C77.688 28.3203 77.8674 27.2088 77.8674 25.9835C77.8674 24.7495 77.688 23.6336 77.3292 22.6359C76.9791 21.6295 76.4452 20.8287 75.7276 20.2335C75.0099 19.6384 74.1172 19.3409 73.0495 19.3409C71.9555 19.3409 71.0453 19.6384 70.3189 20.2335C69.6013 20.8287 69.0631 21.6295 68.7042 22.6359C68.3542 23.6336 68.1791 24.7495 68.1791 25.9835C68.1791 27.2088 68.3542 28.3203 68.7042 29.318C69.0631 30.3157 69.6013 31.1121 70.3189 31.7072C71.0453 32.2936 71.9555 32.5868 73.0495 32.5868Z" fill="#092E75" />
                <path d="M142.243 36.1279H137.044L146.509 9.24219H152.522L162 36.1279H156.801L149.62 14.7559H149.41L142.243 36.1279ZM142.413 25.5863H156.591V29.4983H142.413V25.5863Z" fill="#092E75" />
                <path d="M116.453 13.3249V9.24219H137.904V13.3249H129.594V36.1279H124.763V13.3249H116.453Z" fill="#092E75" />
                <path d="M95.9739 36.1279V9.24219H114.878V13.3249H100.844V20.624H117.897V24.7067H100.844V36.1279H95.9739Z" fill="#092E75" />
                <path d="M90.6997 9.24219V36.1279H85.8293V9.24219H90.6997Z" fill="#092E75" />
              </svg> -->
              <img src="assets/img/logo-blue.png" alt="ZeroIfta Logo">
            </div>
          </div>
          <div class="menu-opt">
          @php
    $notifications = App\Models\Notification::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();
@endphp

<div class="notification-container position-relative">
    <!-- Bell Icon -->
    <div id="notificationIcon" class="bell-icon cursor-pointer">
        <a href="#" id="notificationDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span class="badge bg-danger">{{ $notifications->where('is_read', false)->count() }}</span>
        </a>
    </div>

    <!-- Dropdown -->
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdownBtn">
        @forelse ($notifications as $notification)
            <li class="dropdown-item">
                <strong>{{ $notification->title }}</strong><br>
                <span>{{ $notification->body }}</span>
                <small class="text-muted d-block">{{ $notification->created_at->diffForHumans() }}</small>
            </li>
        @empty
            <li class="dropdown-item text-center">No notifications</li>
        @endforelse
    </ul>
</div>

            <div id="dark-themeIcon" class="dark-themeIcon hf-svg">
              <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 17 18" fill="none">
                <path
                  d="M9 18C11.776 18 14.3114 16.737 15.9911 14.6675C16.2396 14.3613 15.9686 13.9141 15.5846 13.9872C11.2181 14.8188 7.20819 11.4709 7.20819 7.06303C7.20819 4.52398 8.5674 2.18914 10.7765 0.931992C11.117 0.738211 11.0314 0.221941 10.6444 0.150469C10.102 0.0504468 9.55158 8.21369e-05 9 0C4.03211 0 0 4.02578 0 9C0 13.9679 4.02578 18 9 18Z"
                  fill="" />
              </svg>
              </a>
            </div>

            <div id="light-themeIcon" class="light-themeIcon hf-svg" >
            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path
                  d="M11 4V1H13V4H11ZM11 23V20H13V23H11ZM20 13V11H23V13H20ZM1 13V11H4V13H1ZM18.7 6.7L17.3 5.3L19.05 3.5L20.5 4.95L18.7 6.7ZM4.95 20.5L3.5 19.05L5.3 17.3L6.7 18.7L4.95 20.5ZM19.05 20.5L17.3 18.7L18.7 17.3L20.5 19.05L19.05 20.5ZM5.3 6.7L3.5 4.95L4.95 3.5L6.7 5.3L5.3 6.7ZM12 18C10.3333 18 8.91667 17.4167 7.75 16.25C6.58333 15.0833 6 13.6667 6 12C6 10.3333 6.58333 8.91667 7.75 7.75C8.91667 6.58333 10.3333 6 12 6C13.6667 6 15.0833 6.58333 16.25 7.75C17.4167 8.91667 18 10.3333 18 12C18 13.6667 17.4167 15.0833 16.25 16.25C15.0833 17.4167 13.6667 18 12 18ZM12 16C13.1167 16 14.0625 15.6125 14.8375 14.8375C15.6125 14.0625 16 13.1167 16 12C16 10.8833 15.6125 9.9375 14.8375 9.1625C14.0625 8.3875 13.1167 8 12 8C10.8833 8 9.9375 8.3875 9.1625 9.1625C8.3875 9.9375 8 10.8833 8 12C8 13.1167 8.3875 14.0625 9.1625 14.8375C9.9375 15.6125 10.8833 16 12 16Z"
                  fill="" />
              </svg>
            </a>
            </div>

            <!-- Language -->
            <div class="lag-span">
              <div class="dropdown-center">
              @if(LaravelLocalization::getCurrentLocaleName()=="English")
                <button class="lang_btn" type="" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="dropbtn">
                    <img src="{{asset('assets/img/us2.png')}}" alt="Lang_icon">
                  </span>
                  <span class="dropbtn lang-text">English</span>
                </button>
                @else
                <button class="lang_btn" type="" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="dropbtn">
                    <img src="{{asset('assets/img/spanish.png')}}" alt="Lang_icon">
                  </span>
                  <span class="dropbtn lang-text">Spanish</span>
                </button>
                @endif
                <ul class="dropdown-menu">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @if($properties['native'] == "English")
                  <li>
                    <a class="dropdown-item" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                      <span class="dropbtn">
                        <img src="{{asset('assets/img/us2.png')}}" alt="Lang_icon">
                      </span>
                      <span class="dropbtn lang-text">English</span>
                    </a>
                  </li>
                  @else
                  <li>
                    <a class="dropdown-item" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                      <span class="">
                        <img src="{{asset('assets/img/spanish.png')}}" alt="Lang_icon">
                      </span>
                      <span class="ps-2 lang-text">Spanish</span>
                    </a>
                  </li>
                  @endif
                  @endforeach
                </ul>
              </div>
            </div>





            <div class="up-img main_menuDD">
              <!-- New Drop Down -->
              <div class="dropdown">
                <span class=" dropdown-toggle" type="" data-bs-toggle="dropdown" aria-expanded="false">
                  @if(Auth::user()->image)
                  <img src="{{asset('images')}}/{{Auth::user()->image}}" alt="ZeroIfta Image" onclick="toggleDropdown()" style="height: 30px;border-radius:100%" />
                  @else
                  <img src="{{asset('assets/img/user-img.png')}}" alt="ZeroIfta Image" onclick="toggleDropdown()" />
                  @endif
                </span>
                <ul id="" class="dropdown-menu myDropdown">
                  <li class="dropdown-content">
                    <div class="hdd-inn">
                      <div>
                        <svg id="Layer_2" enable-background="new 0 0 32 32" height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg">
                          <g>
                            <path d="m3.39502 8.13934c.00006-.00018-.4527-1.27716-.4527-1.27716-.18451-.52142-.75628-.79291-1.27624-.60833-.52045.18451-.79291.7558-.60834 1.27625l1.22302 3.44983c.1601.44965.63568.71906 1.1015.6532 0 .00006 3.79846-.61218 3.79846-.61218.54535-.08789.91589-.6015.828-1.14636-.08782-.54488-.60345-.91884-1.14635-.82808l-1.8675.30078c2.31226-3.85901 6.48474-6.26794 11.08197-6.26794 7.12433 0 12.92066 5.79632 12.92066 12.92065 0 .55267.4472.99988.99988.99988s.99993-.44721.99993-.99988c-.1267-15.00305-19.67486-20.50073-27.60229-7.86066z" />
                            <path d="m29.71619 21.02002c-.15845-.44067-.63696-.72394-1.1015-.65326l-3.79749.61224c-.54486.08789-.91589.6015-.828 1.14636.08783.54486.59857.91693 1.14636.82806l1.86603-.30078c-2.31128 3.85901-6.48376 6.26801-11.08099 6.26801-7.12434 0-12.92066-5.79632-12.92066-12.92065 0-.55273-.44769-.99994-.99988-.99994s-.99994.44721-.99994.99994c.12622 15.00299 19.6756 20.50067 27.60217 7.86066.27972.65143.43121 1.99127 1.39508 1.94299.6731.01056 1.18225-.69867.94232-1.3338z" />
                            <path d="m16 8.51996c-2.34003 0-4.25 1.91003-4.25 4.25v1h-1.31c-.54999 0-1 .45001-1 1v7.71002c0 .54999.45001 1 1 1h11.12c.54999 0 1-.45001 1-1v-7.71002c0-.54999-.45001-1-1-1h-1.31v-1c0-2.33997-1.90997-4.25-4.25-4.25zm2.25 5.25h-4.5v-1c0-1.23999 1.01001-2.25 2.25-2.25s2.25 1.01001 2.25 2.25z" />
                          </g>
                        </svg>
                      </div>
                      <div>
                        <span>
                          <a href="{{route('password.change')}}"><span>{{__('messages.change_password')}}</span></a>
                        </span>

                      </div>

                    </div>
                  </li>
                  <li class="dropdown-content">
                  <a href="{{route('logout')}}">
                    <div class="hdd-inn">
                      <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16" fill="red">
                          <path d="M13.5625 11.4375H12.4641C12.3891 11.4375 12.3188 11.4703 12.2719 11.5281C12.1625 11.661 12.0453 11.7891 11.9219 11.911C11.417 12.4163 10.819 12.8191 10.1609 13.0969C9.47915 13.3849 8.74636 13.5326 8.00625 13.5313C7.25781 13.5313 6.53281 13.3844 5.85156 13.0969C5.19347 12.8191 4.59547 12.4163 4.09063 11.911C3.58487 11.4073 3.1816 10.8103 2.90313 10.1531C2.61406 9.4719 2.46875 8.74846 2.46875 8.00002C2.46875 7.25159 2.61563 6.52815 2.90313 5.8469C3.18125 5.18909 3.58125 4.5969 4.09063 4.08909C4.6 3.58127 5.19219 3.18127 5.85156 2.90315C6.53281 2.61565 7.25781 2.46877 8.00625 2.46877C8.75469 2.46877 9.47969 2.61409 10.1609 2.90315C10.8203 3.18127 11.4125 3.58127 11.9219 4.08909C12.0453 4.21252 12.1609 4.34065 12.2719 4.4719C12.3188 4.52971 12.3906 4.56252 12.4641 4.56252H13.5625C13.6609 4.56252 13.7219 4.45315 13.6672 4.37034C12.4688 2.50784 10.3719 1.27502 7.98906 1.28127C4.24531 1.29065 1.24375 4.32971 1.28125 8.06877C1.31875 11.7485 4.31563 14.7188 8.00625 14.7188C10.3828 14.7188 12.4703 13.4875 13.6672 11.6297C13.7203 11.5469 13.6609 11.4375 13.5625 11.4375ZM14.9516 7.90159L12.7344 6.15159C12.6516 6.08596 12.5312 6.14534 12.5312 6.25002V7.43752H7.625C7.55625 7.43752 7.5 7.49377 7.5 7.56252V8.43752C7.5 8.50627 7.55625 8.56252 7.625 8.56252H12.5312V9.75002C12.5312 9.85471 12.6531 9.91409 12.7344 9.84846L14.9516 8.09846C14.9665 8.08677 14.9786 8.07183 14.9869 8.05477C14.9952 8.03772 14.9995 8.019 14.9995 8.00002C14.9995 7.98105 14.9952 7.96233 14.9869 7.94527C14.9786 7.92822 14.9665 7.91328 14.9516 7.90159Z" />
                        </svg>
                      </div>
                      <div>
                        <span>
                          <span>{{__('messages.Logout')}}</span>
                        </span>

                      </div>

                    </div>
                </a>
                  </li>
                </ul>
                </d>

              </div>
              <div class="mob-menu">
                <!-- <div id="hamburgerIcon" class="hamburger-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M4 5H16M4 12H20M4 19H12" stroke="#979797" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </div> -->
                <a class="" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M4 5H16M4 12H20M4 19H12" stroke="#979797" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </a>

                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                  <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                  </div>
                  <div class="offcanvas-body">
                    <div>
                      Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
                    </div>
                    <div class="dropdown mt-3">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                        Dropdown button
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
