<div class="container-fluid">
  <div class="header-main">
    <div>
      <div class="head-left">
        <div class="bread_crum">
          @if(Request::is('/'))
          <span class="bc-text">Pages / Dashboard</span>
          <h1 class="head-1">Main Dashboard</h1>
          @elseif(Request::is('fleet'))
          <span class="bc-text">Pages / Fleet Management</span>
          <h1 class="head-1">Fleet Management</h1>
          @elseif(Request::is('profile'))
          <span class="bc-text">Pages / Profile Management</span>
          <h1 class="head-1">Profile Management</h1>

          @elseif(Request::is('vehicles*'))
          <span class="bc-text">Pages / Vehicles</span>
          <h1 class="head-1">Manage Vehicles</h1>
          @elseif(Request::is('vehicle/create'))
          <span class="bc-text">Pages / Vehicles</span>
          <h1 class="head-1">Create Vehicles</h1>
          @elseif(Request::is('drivers/all'))
          <span class="bc-text">Pages / Drivers</span>
          <h1 class="head-1">Manage Drivers</h1>
          @elseif(Request::is('driver/vehicles*'))
          <span class="bc-text">Pages / Driver Vehicles</span>
          <h1 class="head-1">Manage Driver Vehicles</h1>
          @elseif(Request::is('subscribe'))
          <span class="bc-text">Pages / Subscribe</span>
          <h1 class="head-1">Subscriptions</h1>
          @elseif(Request::is('company.contactus'))
          <span class="bc-text">Pages / Contact Us</span>
          <h1 class="head-1">Contact Us</h1>
          @elseif(Request::is('fuel_taxes*'))
          <span class="bc-text">Pages / Fuel Taxes</span>
          <h1 class="head-1">Fuel Taxes</h1>
          @elseif(Request::is('payments*'))
          <span class="bc-text">Pages / Payments</span>
          <h1 class="head-1">Payments</h1>
          @elseif(Request::is('companies*'))
          <span class="bc-text">Pages / Companies</span>
          <h1 class="head-1">Companies</h1>
          @elseif(Request::is('plans*'))
          <span class="bc-text">Pages / Subscriptions</span>
          <h1 class="head-1">Subscriptions</h1>
          @elseif(Request::is('contactus/all*'))
          <span class="bc-text">Pages / Contact Forms</span>
          <h1 class="head-1">Contact Forms</h1>
          @elseif(Request::is('company/contactus/all'))
          <span class="bc-text">Pages / Contact Us</span>
          <h1 class="head-1">Contact Us</h1>
          @elseif(Request::is('drivers/create'))
          <span class="bc-text">Pages / Create Driver</span>
          <h1 class="head-1">Create Driver</h1>

          @else
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
              <!-- <img src="{{asset('assets_new/img/logo-blue.png')}}" alt="ZeroIfta Logo" /> -->
              <svg xmlns="http://www.w3.org/2000/svg" width="162" height="45" viewBox="0 0 162 45" fill="none">
                <path d="M16.8035 10.0819V19.744L26.4656 4.20068H2.52051V10.0819H16.8035Z" fill="white" />
                <path d="M9.66205 29.8263L9.66205 20.1642L9.53674e-06 35.7075L23.9451 35.7075L23.9451 29.8263L9.66205 29.8263Z" fill="white" />
                <path d="M37.4142 36.3938C35.3925 36.3938 33.6465 35.9737 32.1762 35.1336C30.7146 34.2846 29.59 33.0856 28.8024 31.5366C28.0147 29.9787 27.6209 28.1452 27.6209 26.036C27.6209 23.9618 28.0147 22.1414 28.8024 20.5749C29.5988 18.9995 30.7103 17.7743 32.1368 16.8991C33.5634 16.0152 35.2393 15.5732 37.1648 15.5732C38.4075 15.5732 39.5803 15.7745 40.683 16.1771C41.7945 16.5709 42.7747 17.1835 43.6236 18.015C44.4813 18.8464 45.1552 19.9054 45.6453 21.1919C46.1354 22.4696 46.3805 23.9925 46.3805 25.7603V27.2175H29.8526V24.0143H41.8251C41.8164 23.1042 41.6194 22.2946 41.2344 21.5857C40.8493 20.8681 40.311 20.3036 39.6196 19.8922C38.937 19.4809 38.1406 19.2752 37.2304 19.2752C36.2589 19.2752 35.4056 19.5115 34.6705 19.9841C33.9353 20.448 33.3621 21.0606 32.9507 21.822C32.5482 22.5747 32.3425 23.4017 32.3337 24.3032V27.0994C32.3337 28.2721 32.5482 29.2786 32.977 30.1188C33.4058 30.9502 34.0053 31.5891 34.7755 32.0354C35.5457 32.473 36.4471 32.6918 37.4798 32.6918C38.1712 32.6918 38.797 32.5955 39.3571 32.403C39.9172 32.2017 40.4029 31.9085 40.8143 31.5234C41.2256 31.1383 41.5363 30.6614 41.7463 30.0925L46.1835 30.5914C45.9035 31.7641 45.3696 32.7881 44.5819 33.6633C43.803 34.5297 42.8053 35.2036 41.5888 35.6849C40.3723 36.1575 38.9808 36.3938 37.4142 36.3938ZM50.4008 36V15.8357H55.0087V19.1965H55.2187C55.5863 18.0325 56.2164 17.1354 57.1091 16.5053C58.0106 15.8664 59.0389 15.5469 60.1942 15.5469C60.4567 15.5469 60.7499 15.5601 61.0737 15.5863C61.4063 15.6038 61.682 15.6344 61.9008 15.6782V20.0498C61.6995 19.9797 61.38 19.9185 60.9424 19.866C60.5136 19.8047 60.0979 19.7741 59.6953 19.7741C58.8289 19.7741 58.0499 19.9622 57.3586 20.3386C56.6759 20.7061 56.1377 21.2181 55.7438 21.8745C55.35 22.5309 55.1531 23.2879 55.1531 24.1456V36H50.4008ZM73.0233 36.3938C71.0541 36.3938 69.3475 35.9606 67.9034 35.0942C66.4594 34.2278 65.3391 33.0156 64.5427 31.4578C63.7551 29.9 63.3612 28.0796 63.3612 25.9966C63.3612 23.9137 63.7551 22.0889 64.5427 20.5224C65.3391 18.9558 66.4594 17.7393 67.9034 16.8728C69.3475 16.0064 71.0541 15.5732 73.0233 15.5732C74.9924 15.5732 76.699 16.0064 78.1431 16.8728C79.5872 17.7393 80.703 18.9558 81.4907 20.5224C82.2871 22.0889 82.6853 23.9137 82.6853 25.9966C82.6853 28.0796 82.2871 29.9 81.4907 31.4578C80.703 33.0156 79.5872 34.2278 78.1431 35.0942C76.699 35.9606 74.9924 36.3938 73.0233 36.3938ZM73.0495 32.5868C74.1172 32.5868 75.0099 32.2936 75.7276 31.7072C76.4452 31.1121 76.9791 30.3157 77.3292 29.318C77.688 28.3203 77.8674 27.2088 77.8674 25.9835C77.8674 24.7495 77.688 23.6336 77.3292 22.6359C76.9791 21.6295 76.4452 20.8287 75.7276 20.2335C75.0099 19.6384 74.1172 19.3409 73.0495 19.3409C71.9555 19.3409 71.0453 19.6384 70.3189 20.2335C69.6013 20.8287 69.0631 21.6295 68.7042 22.6359C68.3542 23.6336 68.1791 24.7495 68.1791 25.9835C68.1791 27.2088 68.3542 28.3203 68.7042 29.318C69.0631 30.3157 69.6013 31.1121 70.3189 31.7072C71.0453 32.2936 71.9555 32.5868 73.0495 32.5868Z" fill="white" />
                <path d="M142.243 36.1279H137.044L146.509 9.24219H152.522L162 36.1279H156.801L149.62 14.7559H149.41L142.243 36.1279ZM142.413 25.5863H156.591V29.4983H142.413V25.5863Z" fill="white" />
                <path d="M116.453 13.3249V9.24219H137.904V13.3249H129.594V36.1279H124.763V13.3249H116.453Z" fill="white" />
                <path d="M95.9739 36.1279V9.24219H114.878V13.3249H100.844V20.624H117.897V24.7067H100.844V36.1279H95.9739Z" fill="white" />
                <path d="M90.6997 9.24219V36.1279H85.8293V9.24219H90.6997Z" fill="white" />
              </svg>
            </div>
          </div>
          <div class="menu-opt">
            <div id="dark-themeIcon" class="dark-themeIcon hf-svg">
              <svg xmlns="http://www.w3.org/2000/svg" width="17" height="18" viewBox="0 0 17 18" fill="none">
                <path
                  d="M9 18C11.776 18 14.3114 16.737 15.9911 14.6675C16.2396 14.3613 15.9686 13.9141 15.5846 13.9872C11.2181 14.8188 7.20819 11.4709 7.20819 7.06303C7.20819 4.52398 8.5674 2.18914 10.7765 0.931992C11.117 0.738211 11.0314 0.221941 10.6444 0.150469C10.102 0.0504468 9.55158 8.21369e-05 9 0C4.03211 0 0 4.02578 0 9C0 13.9679 4.02578 18 9 18Z"
                  fill="" />
              </svg>
            </div>
            <div id="light-themeIcon" class="light-themeIcon hf-svg" style="display: none">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path
                  d="M11 4V1H13V4H11ZM11 23V20H13V23H11ZM20 13V11H23V13H20ZM1 13V11H4V13H1ZM18.7 6.7L17.3 5.3L19.05 3.5L20.5 4.95L18.7 6.7ZM4.95 20.5L3.5 19.05L5.3 17.3L6.7 18.7L4.95 20.5ZM19.05 20.5L17.3 18.7L18.7 17.3L20.5 19.05L19.05 20.5ZM5.3 6.7L3.5 4.95L4.95 3.5L6.7 5.3L5.3 6.7ZM12 18C10.3333 18 8.91667 17.4167 7.75 16.25C6.58333 15.0833 6 13.6667 6 12C6 10.3333 6.58333 8.91667 7.75 7.75C8.91667 6.58333 10.3333 6 12 6C13.6667 6 15.0833 6.58333 16.25 7.75C17.4167 8.91667 18 10.3333 18 12C18 13.6667 17.4167 15.0833 16.25 16.25C15.0833 17.4167 13.6667 18 12 18ZM12 16C13.1167 16 14.0625 15.6125 14.8375 14.8375C15.6125 14.0625 16 13.1167 16 12C16 10.8833 15.6125 9.9375 14.8375 9.1625C14.0625 8.3875 13.1167 8 12 8C10.8833 8 9.9375 8.3875 9.1625 9.1625C8.3875 9.9375 8 10.8833 8 12C8 13.1167 8.3875 14.0625 9.1625 14.8375C9.9375 15.6125 10.8833 16 12 16Z"
                  fill="" />
              </svg>
            </div>
            <!-- Bell Icon -->
            <!-- <div class="hf-svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" viewBox="0 0 16 20" fill="none">
              <path
                d="M15.2901 15.29L14.0001 14V9C14.0001 5.93 12.3601 3.36 9.50005 2.68V2C9.50005 1.17 8.83005 0.5 8.00005 0.5C7.17005 0.5 6.50005 1.17 6.50005 2V2.68C3.63005 3.36 2.00005 5.92 2.00005 9V14L0.710051 15.29C0.0800515 15.92 0.520051 17 1.41005 17H14.5801C15.4801 17 15.9201 15.92 15.2901 15.29ZM12.0001 15H4.00005V9C4.00005 6.52 5.51005 4.5 8.00005 4.5C10.4901 4.5 12.0001 6.52 12.0001 9V15ZM8.00005 20C9.10005 20 10.0001 19.1 10.0001 18H6.00005C6.00005 19.1 6.89005 20 8.00005 20Z"
                fill="" />
            </svg>
          </div> -->
            <!-- language Popup -->
            <div class="lang-icon">
              <!-- Button trigger modal -->
              <div type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <span class="pe-1">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M2 12C2 17.523 6.477 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2C6.477 2 2 6.477 2 12Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12.9999 2.05005C12.9999 2.05005 15.9999 6.00005 15.9999 12C15.9999 18 12.9999 21.9501 12.9999 21.9501M10.9999 21.9501C10.9999 21.9501 7.99988 18 7.99988 12C7.99988 6.00005 10.9999 2.05005 10.9999 2.05005M2.62988 15.5H21.3699M2.62988 8.50005H21.3699" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </span>
                <span>Lang</span>

              </div>

              <!-- Modal -->
              <div class="language-modal">
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="text-center">

                          <div class="pt-3">
                            <p class="gray1">Switch the language of your choice</p>
                          </div>
                          <div>
                            <div class="py-3">
                              <!-- Spanish -->
                              <div class="form-group">
                                <label for="remember-me" class="text-info">
                                  <span>
                                    <input id="remember-me" type="radio" name="remember">
                                  </span>
                                  <span class="rf-text">
                                    <!-- <img src="assets/img/spanish.png" alt=""> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="29" viewBox="0 0 50 29" fill="none">
                                      <rect x="0.739746" y="0.0974121" width="48.6895" height="27.9266" fill="url(#pattern0_2582_1738)" />
                                      <defs>
                                        <pattern id="pattern0_2582_1738" patternContentUnits="objectBoundingBox" width="1" height="1">
                                          <use xlink:href="#image0_2582_1738" transform="matrix(0.00363636 0 0 0.00633994 0 -0.0801042)" />
                                        </pattern>
                                        <image id="image0_2582_1738" width="275" height="183" xlink:href="data:image/png;base64,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" />
                                      </defs>
                                    </svg>
                                  </span>
                                </label>
                              </div>
                              <!-- English -->
                              <div class="form-group pt-3">
                                <label for="remember-me" class="text-info">
                                  <span>
                                    <input id="remember-me" type="radio" name="remember">
                                  </span>
                                  <span class="rf-text">
                                    <!-- <img src="assets/img/spanish.png" alt=""> -->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="41" viewBox="0 0 50 41" fill="none">
                                      <rect x="0.739746" y="0.711182" width="48.6895" height="40.1723" fill="url(#pattern0_2582_1732)" />
                                      <defs>
                                        <pattern id="pattern0_2582_1732" patternContentUnits="objectBoundingBox" width="1" height="1">
                                          <use xlink:href="#image0_2582_1732" transform="matrix(0.00195312 0 0 0.00236722 0 -0.106008)" />
                                        </pattern>
                                        <image id="image0_2582_1732" width="512" height="512" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAYAAAD0eNT6AAAAAXNSR0IArs4c6QAAIABJREFUeAHt3fuPbWd93/EBUy4pCEIrgpRGCmkaYwNGQeWSQiJ+gMgUpDhAY0OBmkKAQotMSGogDXKrggG5lSGqcBpUuS1xU8UUg2xj+3Ax+MLxhQMY+3jmeLCPz/06M//BU+2xn8PMnL33PLP386zLs16WRuvMnjVr7/V+Pt/v97PW/njPwoL/EEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEBgM4HvX3b1qVPHT/y/tbW1v6vl6/6lozf+wWd3P/K7n7rjoC8M5tHAdbc/9t2SdfHzf3bxoSF/lWQ7Wrt51t7v6h1taOAdV927uPj4yW+UrI21U6euP/zJq+5fWFw4Nzz8G28Md33+q2Ftba2aryMnVsIV1z0Ynv3Ob4WFt97oC4OZNPCVWx8pWhOj+hvyV8meM1o7ta/39UUDz3v3Lesz69jJlaI958QNt4Xll75lve+sG4DYgB549TvCnq/fUfTJSxb8uGM/vP9EuPSL94dz3n6TZsAE7FgDDEBZgzKuZnM9xgAY/n0Y/n/vX9y0PqOWD54sOntP3fPjsP/C92264NhkANaNwFPPC3ve8IGw986fFX0xuYo89Ti79x4Jv3/F3TseAH0QkNdYrtExAAyA+ipXX0Nne+F/ujvs2Xe06KxdWVwOBy69PCyec/6m4T+a92cbgCdvSS4964Lww/d8Ohzcd6Doi0sd4Ln2u+Hu/eElH/0eI+BuQJIGGAAGYOhDyvnnN0Cv+Pj3w7fuKztbV48eD4ev+FJYevZvnzX4413/iQYg7rD4/FeHO//k6nDy+KlqjMDK6mq45uZ94Vfee1vSEFAA+QugL0wZAAagL1r1Orvfp/7R+3etz57V1YJ5u5WVcOya68IjL3ztxMEf5/v2BuDJOwKCgt0XlwaQf40YAAZAXeWvq6ExbSPgF4f8tG2yAYgHERRUDEMqXgaAARiS3p1r3v7eZsAvzuxp2x0bgPWDCQp662AgGQIGgAEwFPMOxaHwbDvgN23wx5/NZgAEBRkABiBLJiYW4lC3ucK9444zMm9DGTbOszsmZRTwu/ne9gN+KT1lLgNw5gkEBTWaSg2BOwDuABiu3RmuXV6LrgX8zsznKR82lscACAoyAAzATHcEUoq05n3GXbnneswdAIO7CcPQ1YBfSt/IagDiEwoKKrwmCq+J53AHwB2AJnTmOfrXM7se8IvzeNq2iAFYf0JBQXcFKrgrwAAwAIZz/4Zz6TXrQ8Bv2uCPPytnAAQFGQAGYNu3BWIhDnWb63b/uON4C8Dgzm0E+hTwS+kpxQ3AmRchKMgQ9NAQuAPgDkDuIeJ4/TMmfQz4nZm9TYUAU57QJwr2T/xDblgMAAMwZP0P/dz7HPBLmcfN3QHY4kIEBRmBPjQXBoAB6INOvca8/bSGgF+nDcD6ixMU9LZAx98WYAAYAMM173DtOs9aAn7dNwCCggwAA7DtX+xKKeS+7jMuvJfrsZF56/qw8fq6Yy5qC/il9ITW3gIY++IEBTWsjhkCdwDcATCkuzOkS6xFrQG/sTN2y1vx3TIAT744QcG6C65EEZc6JgPAAJTSluO22+dqD/j11gDEFy4o2G6BaFA3BgaAAVAHdfWhGPB75MDJbT+nY563o07d8+Ow/8L3dfotvk7eAYgGYH0rKOhtgRbfFmAAGAAGoB4DMKSA36Y5uuXWf/xZ9w2AoCADwAB0+ioiNpNZtvNcYW33uyPzZnjXM7znWcshBvxS6rE3BuDMyQgKamoNGgJ3ANwBmGfw+N12DciQA35nZuaEq//Rz/tnAAQFGQAGoJo7Attdxc/zc3cA2h2+bZofAb80495bAxDdjaDgcIu8iQbjDkBaI4n1uNPtPAN+u99lAIbXGwT8dlavvTcA6w1HUNBdgUJ3BRiAnTUUBmB4Q7cJI57yHAJ+O6/VOgyAoCADwAD08m2B7a7i5/m5OwDDMCMCfjsf/NGoV2UA4kktCgoyBJkMgTsAszeXM/U4JYQ0z4Df7ncZgLoNwK++f1e45uZ9YXV1rdz/z7+yEo5dc1145IWv7aXB3q4GFxafeUGVJzY68Yd/68Jw93/7ejlxrBUU3oRjHzmxEq647sHw99/xLUM+05CfdnuRAWAApunDz5o3GU0F/I5f/62wfN6bqp2Po9m/sLj7wXDfH34sLJ5zfrUnKijYfJHW0hgZAAagFi33/TwE/DLV4lNeHPZf9OFw+qd7w0K8jfajv7s9/OxVF1drAhYFBd0xmOGOAQOQqelMeBsg9p8SW28B1GP8Bfzy1OGjr3p7OHHrD87cFT9jAGIB7v6rb4S9v1XvbY+lZ10QfvieT4eD+w6cgRDPvc/bG+7eH17y0e8Z8jMM+WlXRgxAnsYz6b3IkjXHAPTfAAj45am/5d98Yzh27dfOmnlnGYBRQZ48firc8clrwtI/fE29dwQEBZmFBLPAAORpQAxA/4fxNKOc+2cCfnnqbt/zXxUOX/GlsHpi/B8+GmsAois/vP9IuPv9/zlUHRT8jTeGuz7/1bOcUWTQx62gYL5mywDkaUQMQD5N5h62XTpeUwG/EzfcFpZf+pZqL3CXnv7ScPBDnw6rBw5NnW1TDUAcfoKCzaf9I/t5tg/vPxEu/eL94Zy33+RqP+Fqf1wjZAAYgHG68FheQyPgl6nONgT8UmZHkgGIBxIU7KcR2L33SPj9K+5mAmYwAQxApsYkBKj+JtSfgF+eGtsa8Itze9p2RwYgHkhQsJ9GQFBw51ctDECe5uQtgJ1rr/a7DAJ+eWprUsAvzutp25kMwOiAgoL9NAErq6vrn571K++9zRXJhCuSjY2XAcjTpBgABiDWlYBfnpraLuA3bfDHn81sAOIBBAX7aQQEBdMaMgOQp1kxAGl6i0Oyxq2AX55aSg34xRk9bTu3AYgHFxTspxEQFJzemBmAPE2LAZiusxoHfjwnAb9MNbTDgF+czdO22QxAfBJBwX4aAUHB8Q2aAcjUvIQAB/mWm4BfnvqZJeAXZ/K0bXYDEJ9MULCfRkBQcLMRYADyNDB3ADbrKl4d17oV8MtTN/ME/OIsnrYtZgBGTyoo2E8TICj4i2bNAORpZAzALzRV69AfnZeAX556yRHwmzb4488W/umffj/ccl/Zz8UXFOynERAUvDEwAHkaGgNQtwEQ8MtTJzkDfnHIT9sujFzbU952Y7joyt3hJ48cm/qxgdMOlPIzQcF+GoEhBwUZgDyNjQGo0wAI+GWqjwIBv5SZvG4A4i2pp//RzeFDX94THj9yqqgREBTspxEYYlCQAcjU4IQAqwsBCvjlqY1SAb8dG4BoBH753beEK657MBw/uVLUCAgK9tMIDCkoyADkaXLuANRzB0DAL09NlA74zWwAohH4x//mO+HaXcthdbXcoBIULMc2RQCz7jOUoCADkKfZMQD9NwACfnlqoamAX0pv3/QWQBz8W7eCgnkW/mF/erh3t0EZgDzaZwD6awAE/PLUQNMBv2wGYGQIBAXziGDUCB949TvCnq/fUfTtlZTFz7lPrUFBBiCf7seZgJwa3Hqs0dptvZjxfboREfDLpP2WAn5b62Hc90l3ADYWjaBgJlE89byw5w0fCHvv/FlVRqC2oCADkEnvQoC9MiMCfnl032bAb9zA3/rYjg1ANAOCgnkEsvSsC8IP3/PpcHBf2c9i2Lrwpb+vJSjIAOTR+bir/9FjJXXoDkD61X7s6wJ+efTehYBfSm3NbACiYAQF8whm8fmvDnf+ydXrn56YsnB92KeGoCADkEnf7gB0+g6AgF8enXcp4JcyI+Y2ANEICArmEZCg4M6vWqIGS2wZgDy6dgegW7qOtSLgl0ffXQz4NWoARoISFMwjplGzFBTsRsNkAPJpepwJSGlSs+7jLYDJNSTgl0nXHQ74pdRNtjsA0VGOtoKCmcQlKNj6bVMGIJOWvQXQupZjjxbwy6Pprgf8WjMAUWiCgnmEJig4+Uomaq3UlgHIo+FxV/+jx1Ka1Kz7uAOwuW4E/PJouS8Bv5S6KXIHYGszFhTMIzxBwc0NbavOSnzPAGTSrjsArd0BEPDLo+G+Bfw6YwBiYxYUzCNEQcHmjAADkEez7gA0p9nYbwX88mi3rwG/7QzA1+58LDRyByAKcrQVFMwjylFDFRQs31QZgHx6HWcCtmtS8/x8qG8BCPhl0mzPA36TaueevUfCRVfufuKO1Mbh3OS/BQUziVRQsOitVQYgk069BVBUp7F3C/jl0WsNAb+tBuDnB0+GD315Tzjn7Tf9QotROG1tBQXzCLbmoOD5H/3uLwT71vJX/RtrgQHIo89xV/+jx7Y2qZzfD+kOgIBfHp3WFPCLtXT0xEq44roHw3Pe+a2z++jGZtfmvwUF8whYUDCvQWAAMunSHYCzm28GMyvgl0efNQb8Rp/Eeu2u5fBrf7xrsvbaHPrjnltQMI+gBQXzGAEGII8e3QHIo8fYMwX88uiy1oDf6G+xvOyy700e/NF8RkF1aSsomEfco6YrKDhf42UA8mlxnAmItylLbGt8C0DAL5MehxDwi0N+2rZLg3/raxEUzCR2QcHtnfCEImEAMmnQWwAzazD2RQG/PFocTMBvQk+Lelrfbvom5Rda2EdQMI/wBQV3fjeAAcijvXFX/6PHSlz5x2PWcgdAwC+PBgcX8EuZ1X0wAPE1CgrmKQRBwXQjwABk0pw7ADu+AyDgl0d7gw341WYAohEQFMxTGIKC2xsBBiCP1twB2F5rsb8J+OXR3OADfrUagFGhCArmKZJRYxYUnNycGYB8OhtnAuLt+hLbvr0FIOCXSWsCful3m6Lr7OtWUDBT0QgKji0aBiCTvrwFMFZfse8K+OXRmYDf5IuZqLVN203fpNwy6Og+goJ5CkhQcHMBMQB5dDXu6n/0WIkr/3jMPtwBEPDLoy8Bv819K3muJ+/Y0cG/9fULCuYpKEHBJwqKAcikJ3cANt0BEPDLoysBvxkHf5znWwdoLd8LCuYpsKEHBRmAPDpyB+CJRi3gl0dPAn5zDv7aDcDIyAgK5im2UfMealCQAcinoXEmIN6uL7Ht0lsAAn6ZdCTgt+lO0twX7HMfIDqJDm8FBTMV3wCDggxAJu0M+C0AAb88GhLwy3TVv3FWD8EAxHMUFMxTiEMKCjIAeTQz7up/9FiJK/94zLbvAAj45dGOgF+BwR9NQByOQ9oKCuYpzCEEBRmATFoZ0B0AAb88mhHwKzj4h2wAotkRFMxTqDUGBQ8dOx0+/j9+Gq773qNFr1InXRkP5fF4tV5i2/QdAAG/PP1EwK+Bwc8APAFZUDBP0Y4GVo1BwRKDaeMxhzLoJ53nRha5/92UARDwy9RDBPzyBvzikJ+2jVfDQ98KCmYq4kqDgrmHUzzepME4lMcjhxLbJgyAgF+eviHg1+BV/0ZDMPTBv/X8BQXzFHStQcHcg2oog37SeebmufF4JQ2AgF+ePiHg19LgjyZg6wD0/RMLIiiYp8BrDApuHDLz/nvSYBzK4/Pym/b7JQyAgF+eviDg1/LgZwDSFkBQME/B1xgUnDZ8Un82lEE/6TxTOc2yX04D8Nx33RKuuO7BcOzkStFQ6IkbbgvLL31LmMSr748L+KXNncYuxBt7oug4ergVFMxjAkbNS1BwbdMA6XtDn/f1zzLYU38nhwEQ8MtU+wJ+zQf8UmYtA5DuyAQFMzUDQcEzJmDeAdr3308d5rPsN68BEPDLU+8CfukzpvF53PgTpriSju8jKJinMQgKrlV7qzfVmMwy2FN/Z1YDIOCXp74F/Do8+OOMZQBmXyRBwTyNYshBwdRBWet+qcN8lv12agAE/PLUs4Df7DOl8Xnc+BNG51HRVlAwT+MYYlCw1sGeel6zDPbU30k1AAJ+eepXwK9Hgz/OXwYgz6IJCuZpIqPBMaSgYOqgrHW/1GE+y37bGQABv0w1K+DXzYBfHPLTtgxAHgMQOQoKZmoqAwkK1jrYU89rlsGe+jvTDICAX546FfDLOz/iHGls29gTTXMhFf5MUDBPg6k9KJg6KGvdL3WYz7LfOAMg4JenLgX8ej7448xlAMoupKBgnoZTa1Cw1sGeel6zDPbU39loAAT88tShgF/ZedH4PG78CaPzGNhWUDBPA6otKJg6KGvdL3WYz7LfyAAI+OWpOwG/ygZ/nL8MQHMLKyiYpxmNhmEtQcFaB3vqec0y2FN/5yePHAuPHjp55kOXUn9vJ/uduufHYf+F76v38xwE/Pob8ItDftqWAWjOAETWgoKZjEAFQcHUQVnrfjsZtl3ad2VxORy49PKweM751Q5/Ab/mZ0OcEY1tG3uiaS5koD8TFMxjBPocFKx1sKeeV5eGesprWT16PBy+4kth6dm/Xe3gF/AbwOCPM5cBaH+xBQXzGIE+BgVTB2Wt+6UM3U7ss7ISjl1zXXjkha+tdvAL+LU/Cxqfx40/YXQetme9tyQomMcI9CkoWOtgTz2vTgz3tc1/oXHra/Ineqfz2cqrK9/fcPf+8LLLvndWnzXzNhgdMDbA6IApERTMYwJGA6gPQcHUQVnrfl0ZFuNeh4BfPwf/PXuPhIuu3G3wp8wzBqBbBiCuh6BgJiPQ8aBgrYM99bzGDd62HxPw6+fg//nBk+FDX94Tznn7TYZ/yvAf7RMHjm03jYCgYB4j0NWgYOqgrHW/tof9xucX8Ovn4D96YiVccd2D4Tnv/JbBnzr4434GfzcH/9Z1ERTMYwS6FhSsdbCnntfGAdzavwX8in5WQql1XVldDdfuWg6/9se7DP440He63TpofN9tQyAomMcIdCUomDooa92v1HBIPa6AXz+v+gX8Ms0pAz8TyJ06rzn2FxTMYwJGQ7XtoGCtgz31vFIHde79BPz6OfgF/DLPKwYgM9A5BvtO10JQMJMRaDEomDooa90v92Df7ngCfv0c/AJ+hebUToeO/QstxBzGQVAwjxFoIyhY62BPPa/tBnaunwv49XPwC/gVnjcGemHAcwz2na6NoGAeI9BkUDB1UNa6X64BP/E4An4Cfg324J327Nb3v/SL9wdfdTG45uZ9YZSQndgUt/nks5TfO7jvQLj7A58N9/3hx6r9uvPjXwrHjxwvyrHWwZ56Xilam3Wf1RMnw+HP//f1P9oz+sM9NX4d+tR/CasHDxfV6Kz8Z/29IydWwp//75+tf5jP6AN9fJVjsDDrIvm9ft5Ss27dWrfUQVnrfvTYLT1aj2GtBwOQ4WpY0QyraHKud62DPfW8crJ0LHVIAzvTAAPAAFR1+7BvDSB1UNa6X9/Wy+vd2YDBq9u8GAAGgAFoUQO1DvbU8zIguj0grE/d68MAtNj8FVfdxZWyvqmDstb9UhjZR53QQBkNMAAMgDsALWqg1sGeel4ae5nGjiuuKRpgAFps/ikLZJ+6Czl1UNa6H33XrW/r2+31ZQAYAHcAWtRArYM99bwMiG4PCOtT9/owAC02f8VVd3GlrG/qoKx1vxRG9lEnNFBGAwwAA+AOQIsaqHWwp56Xxl6mseOKa4oGGIAWm3/KAtmn7kJOHZS17kffdevb+nZ7fRkABsAdgBY1UOtgTz0vA6LbA8L61L0+DECLzV9x1V1cKeubOihr3S+FkX3UCQ2U0QADwAC4A9CiBmod7KnnpbGXaey44pqiAQagxeafskD2qbuQUwdlrfvRd936tr7dXl8GgAFwB6BFDdQ62FPPy4Do9oCwPnWvDwPQYvNXXHUXV8r6pg7KWvdLYWQfdUIDZTTAADAA7gC0qIFaB3vqeWnsZRo7rrimaIABaLH5pyyQfeou5NRBWet+9F23vq1vt9eXAWAA3AFoUQO1DvbU8zIguj0grE/d68MAtNj8FVfdxZWyvqmDstb9UhjZR53QQBkNMAAMgDsALWqg1sGeel4ae5nGjiuuKRpgAFps/ikLZJ+6Czl1UNa6H33XrW/r2+31ZQAYAHcAWtRArYM99bwMiG4PCOtT9/owAC02f8VVd3GlrG/qoKx1vxRG9lEnNFBGAwwAA+AOQIsaqHWwp56Xxl6mseOKa4oGFtZWV4MvDGigHQ2kDspa96O7dnSHO+4jDSzU2lic17kBAwxogAZogAYmaYABWCCOSeLwOG3QAA3QQL0aYAAYAHcKaIAGaIAGBqgBBmCAi87R1+vora21pQEaSNUAA8AAcP40QAM0QAMD1AADMMBFT3WH9nMlQQM0QAP1aoABYAA4fxqgARqggQFqgAEY4KJz9PU6emtrbWmABlI1wAAwAJw/DdAADdDAADXAAAxw0VPdof1cSdAADdBAvRpgABgAzp8GaIAGaGCAGmAABrjoHH29jt7aWlsaoIFUDTAADADnTwM0QAM0MEANMAADXPRUd2g/VxI0QAM0UK8GGAAGgPOnARqgARoYoAYYgAEuOkdfr6O3ttaWBmggVQMMAAPA+dMADdAADQxQAwzAABc91R3az5UEDdAADdSrAQaAAeD8aYAGaIAGBqgBBmCAi87R1+vora21pQEaSNUAA8AAcP40QAM0QAMD1AADMMBFT3WH9nMlQQM0QAP1aoABYAA4fxqgARqggQFqgAEY4KJz9PU6emtrbWmABlI1wAAwAJw/DdAADdDAADXAAAxw0VPdof1cSdAADdBAvRpgABgAzp8GaIAGaGCAGmAABrjoHH29jt7aWlsaoIFUDTAADADnTwM0QAM0MEANMAADXPRUd2g/VxI0QAM0UK8GGAAGgPOnARqgARoYoAYYgAEuOkdfr6O3ttaWBmggVQMMAAPA+dMADdAADQxQAwzAABc91R3az5UEDdAADdSrAQaAAeD8aYAGaIAGBqgBBmCAi87R1+vora21pQEaSNUAA8AAcP40QAM0QAMD1AADMMBFT3WH9nMlQQM0QAP1aoABYAA4fxqgARqggQFqgAEY4KJz9PU6emtrbWmABlI1wAAwAJw/DdAADdDAADXAAAxw0VPdof1cSdAADdBAvRpgABgAzp8GaIAGaGCAGmAABrjoHH29jt7aWlsaoIFUDTAADADnTwM0QAM0MEANMAADXPRUd2g/VxI0QAM0UK8GGAAGgPOnARqgARoYoAYYgAEuOkdfr6O3ttaWBmggVQMMAAPA+dMADdAADQxQAwzAABc91R3az5UEDdAADdSrAQaAAeD8aYAGaIAGBqgBBmCAi87R1+vora21pQEaSNUAA8AAcP40QAM0QAMD1AADMMBFT3WH9nMlQQM0QAP1aoABYAA4fxqgARqggQFqgAEY4KJz9PU6emtrbWmABlI1wAAwAJw/DdAADdDAADXAAAxw0VPdof1cSdAADdBAvRpgABgAzp8GaIAGaGCAGmAABrjoHH29jt7aWlsaoIFUDTAADADnTwM0QAM0MEANMAADXPRUd2g/VxI0QAM0UK8GGAAGgPOnARqgARoYoAYYgAEuOkdfr6O3ttaWBmggVQMLa2trwRcGNNCOBlILtdb96K4d3eGO+0gDDAADxAC2qIFaB3vqeRlEBhENtKcBBqDF5k/47Qm/K+xTB2Wt+3VlHbwOtThEDTAADIA7AC1qoNbBnnpeQ2y6zpnZ6IoGGIAWm39XROB1tNeQUgdlrfvRXnvawx57BoABcAegRQ3UOthTz8sQMoRooD0NMAAtNn/Cb0/4XWGfOihr3a8r6+B1qMUhaoABYADcAWhRA7UO9tTzGmLTdc7MRlc0wAC02Py7IgKvo72GlDooa92P9trTHvbYMwAMgDsALWqg1sGeel6GkCFEA+1pgAFosfkTfnvC7wr71EFZ635dWQevQy0OUQMMAAPgDkCLGqh1sKee1xCbrnNmNrqiAQagxebfFRF4He01pNRBWet+tNee9rDHngFgANwBaFEDtQ721PMyhAwhGmhPAwxAi82f8NsTflfJYhp/AAAZaUlEQVTYpw7KWvfryjp4HWpxiBpgABgAdwBa1ECtgz31vIbYdJ0zs9EVDTAALTb/rojA62ivIaUOylr3o732tIc99gwAA+AOQIsaqHWwp56XIWQI0UB7GmAAWmz+hN+e8LvCPnVQ1rpfV9bB61CLQ9QAA8AAuAPQogZqHeyp5zXEpuucmY2uaIABaLH5d0UEXkd7DSl1UNa6H+21pz3ssWcAGAB3AFrUQK2DPfW8DCFDiAba0wAD0GLzJ/z2hN8V9qmDstb9urIOXodaHKIGGAAGwB2AFjVQ62BPPa8hNl3nzGx0RQMMQIvNvysi8Draa0ipg7LW/WivPe1hjz0DwAC4A9CiBmod7KnnZQgZQjTQngYYgBabP+G3J/yusE8dlLXu15V18DrU4hA1sHDRlbuDr7IM/uKrPwtHT6xUdaW9euBQOPRnnw/7L/pwtV+H/vy/htUjx4quW62DPfW8Sjbdw/uPhLs+eGXY84YPVPv1w/f+x3Bw6fGiGj15ejV84Wt7zYkKZ+XCwltvDL7KMHjhv74tXP2NxXB6ZbVogZZsoluPvXryVDhy9bXhkRf8Tkht8n3bb98LX7t+jmunTxdft76xyf16t+or9/crp0+Huz7/1bD4q79XrV6XnvfKcNdHvhBOFDarN9y9P5z3775rXtQ0Mw3//MP/ly65OVz2lZ+EQ8fKD5DcDXPa8U7ccFtYPu9N9TbSZ10QDl72mbB66EjxwR855x6ofTte5FB6e+Txo+tDcuk5r6hWvw+/6A3rZqcky9HdgNFFzQveexsjUIMRYADyGYCnvu2mcMlV94bF/ScaGyAliz0e++Ttu8Ojr3tHtY1z8annhccv+Vg4vbjc+Lr1bWDnfr1RY01tH3tgOdxz8eVh8Zzzq9XzQy+/KNz7N7uKavnw8dPhE//zgfDMi29mBPpsBBiAPAbg9f/hznDXg4eLFl1TTTI+z8refeHApZeH0YDM3fi7crxHX//ucOrO+1pbt65waOt1RK01vX3glnvWcwFtnXfx533Ki9fP76Hbf1xU23sfOxEu/eL9YXTxY5bkmSWNcmz0yfrslCa89hf/2++G//v9R4sWWdPNcfXw0XDoE1eFxWdeUO3gXz73wnDsb29sfd2KD4KFczu9hk1re+vz7f6rb4SHzntzpxnNo5Glp790/Y7HgaXHimr99p8cCq/75B1MwIQ50dk529kX1nGQAn7dHiyTmmaTAb+tw2bc95Ne51AeH8ek6ccEBfP9L4CCgj27C8AA7GzBBPz6OfiXWgj4pQyyoQz6SeeZwqipfQQF8xgBQcGdzZRWZ3CrT97xq/yNbAT8+jn42wz4pQyuSYNxKI+nMGp6H0HBPEZAULAHRmDjkPPv8Qsm4NfP4d92wC9lcA1l0E86zxRGbe0jKJjHCAgKjp8rnZi3nXgRHb0TIODXz8HflYBfyuCaNBiH8ngKo7b3ERTMYwQEBTtoBBiAsxdFwK+fg79rAb+UwTWUQT/pPFMYdWEfQcE8JmC0loKCZ8+c1uZwa0/cwat+Ab9+Dv6uBvxSBtekwTiUx1MYdWkfQcE8RkBQsCMmgAG4cf1DLHyCXw+Hf4uf4JdrKA1l0E86z1wcmz6OoGAeIyAo2LIRGLoBEPDr4eBfODc0EfD7+cGT4cf7/DXAScM7x+NND+7czycomMcICAq2ZASGagAE/Po5+JsI+J04tRI+d/3e8Nx33RK+cusjRT9BLccQ7fMxcg/kto4nKJjHCAgKNmwEhmYABPz6OfibCPitrq6Fa3cth1//4LfPfKQpA1BWL20N7BLPKyiYxwSM1kZQsCEjMBQDIOBXtpGXugptKuC360cHw2su/8GZwR/rggEoq5sSg7jtYwoK5jECgoINmIDY6Grd+gS/sg281OBv6hP8frR0NFx05e7wlLeNLzYGoKx+2h7WJZ9fUDCPERAUHN+bsszsLAfp4P/SNzovAb+yzbvU8G8i4PfY4VPhsq/8JDxjm79nzgCU1VDJAdyVYwsK5jECgoIFjECNBkDAr2zTLjX4mw74pWifASirpa4M6SZeh6BgHiMgKJjRCKQ0wb7sI+BXtlmXGvxtBfxSdM0AlNVUE4O3S88hKJjHBIzWVFAwgxFIaYJd30fAr2yTLjX42w74peiaASirrS4N5yZfi6BgHiMgKDinCUhpgl3dR8CvbHMuNfi7EvBL0TUDUFZjTQ7dLj6XoGAeIyAoOKMRSGmCXdxHwK9sYy41/LsU8EvRNQNQVmddHMptvCZBwTxGQFBwh0YgpQl2aR8Bv7INudTg72LAL0XXDEBZvbUxbLv8nIKCeYyAoGCiEUhpgl3YR8CvbCMuNfi7HPBL0TUDUFZ3XR7Gbb02QcE8JmC0foKC2xiBlCbY5j4CfmUbcKnB31TA79t7xn+CXy7NMgBl9dfWkO3D8woK5jECgoJTTECuRpn7OAJ+ZRtvqcHfp4BfimYZgLI67MMgbvs1xqDg0tPOD8XqdqHsOm/3uh96+UXh3r/ZVfQPbwkKjjECKU2w6X0E/Notxu2KddLP+xbwS9E1A1BWi20P1z49/09vvTfsecMHqjUBi0958fr5PXT7j4saAUHBDUYgpQk2tY+AX9lmO2lwz/t4XwN+KbpmAMpqsuQA/l/f+Xn40Jf3hMePnCo6UEqew7hjCwrmeWtAUPDGsJDSBEvvI+BXtsnOO+An/X7fA34pumYAympz3IDL9dho7UZr/MvvviVccd2D4fjJlWqMgKBgHhMw0tqgg4IpTbDUPgJ+ZZvrpME97+O1BPxSdM0AlNVormE/7jjRAMR1/s0Pfydcu2u5GhMwOmdBwTxGYLBBwVgcTW4F/Mo21XkH/MTff+p54fFLPhZOL5Ztotv9id4mtcoAlNXquMGd67GtBiDq5pV/9v1w6/0HqjICgoJ5jMDggoKxKJraCviVbagTh/ecKd8aA34pmmcAyuo117Afd5xJBmC07k95243hoit3h58uH6vKCAgK5jECgwkKpjTBHPsI+JVtpKUGf80BvxRdMwBldTtucOd6bJoBiGv/9D+6WVBwzouDUr1n2nGXnv7ScM/Fl4cDS48VNXCjoOBrP3nHepYkaqaqbemTEfAr20CnFck8PxtCwC9F+wxAWf3mGvbjjpNiAKIGBAXLrvM8vWja7y4975Xhro98IZw4UvZOTrVBwVgAubcCfj0tqGddEA5e9pmweuhIUWdd+hP8cumZASir43GDO9djOzEAUS+CgmXXe9own+dnD7/oDeGuz3+1aM+qMigYhZ9rK+DXzwKq7RP8cumZASir51zDftxxZjEAUTeCgmXXfZ5hP+13faLghg/5eWvCv6Pgc2wF/PpZNEMN+KVongEoq+lxgzvXY/MYgJE2BAXLrv20QT7Xz3yiYHpmIaUJbrePgF8/C2XoAb/tdD36OQNQVtu5hv2448xrAKI+BAXLamCuYT8lwCgoWPgOgIBfPwtDwC+hMJ68fcYAlNX4uMGd67FcBiAagRgUPHHKJwqWGtoljisoOKXfRXHvZCvgV7YpliiC0TGH9Al+O9HztH0ZgLJazzXsxx0ntwGIOhEULKuJUv1PUHCMEYiiTtkK+PVT+AJ+Y4SfEpDxFkDxvzw3bnDneqyUAYi9UlCwn/1QUHBDP4xi3m4r4NdPsQv4bRB74tDfWAvuAJTVfa5hP+44pQ3ASCeCgmX1UepugD89/GRf3Njsxv1bwK+fAhfwm2/wx1pgAMrqf9zgzvVYEwYg6iQGBQ8cPV30/0XPxSb1OD/862+Gh857c/E7QcUG/ZSQ4PrbokP/RMEo4K1bAb+yja+U4AX88gz+WA8MQNk6SB1Es+zXpAGIenn+e25d/9PDgoJldZO7fw42KBiFG7cCfv0SbiwEAb+8gz/WAwNQth5mGeypv9OGAYi6ERQsq5vY93JvBxcUjIIV8OunYAX8ygz+WBcMQNm6SB3ms+zXpgGI+hEULKuf3AYgHm8wQcGRUAX8+ilSAb+yw39UGwxA2dqYZbCn/k4XDMBIQ4KCZTUUh3b27RA+UfDrd+2vKrSyevhoOPSJq8LiMy+oNrgi4Fd+8McrOAagbPNOHeaz7NcVAxC1JChYVkvZDcCTAcKqP1FwlsLq4u+snjwVjlx9bXjkBb9T7eAX8Gtu8MemzQCUbdole0nXDEDUlKBgWU0VMwI1/unhkgXY1LFP3HBbWD7vTdUOfgG/5gd/bNYMQNlmXbJHdNUARG0JCpbVVikjUFVQsGQBlj72ydt3h0df945qB7+AX3uDPzZpBqBsky7ZI7puAKLGBAXLaqyUEagiKFiyAEsde2XvvnDg0svDaECWWty2jyvg1/7wHzVoBqBscy7VI0bH7YsBGOlMULCszor1874HBUsWYO5jC/itZQlsjj6k5HPX7w3Pfdct6X83eoaP0Y1XOH3eMgBlG3PuHrHxeH0yALFGBAXL6q2UEehtUHBjwXT13wJ+eQb/6upauHbXcvj1D37b4E80NAxA2YZcsuf00QBEIyAoWFZ3xYxA34KCJQswx7EF/PIM/2/vORhec/kPDP7EwR8bMQNQthHn6BGTjtFnAxD1JyhYVn+ljEBvgoKTiqftxwX88gz+Hy0dDRdduXv9PcbYVGzT8wUMQNkGXLLP1GAAYq0KCpbVYSkj0PmgYMkCnOXYAn55Bv9jh0+Fy77yk/CMi2921b/Dq/7YdEdbBqBs452lR6T+Tk0GYKRFQcGyWixlAjr9p4dTi6n0fgJ+eQa/gF/61f3GQT/p3wxA2aZbsq/UZgCiRgUFy2qylBHoZFCwZAGmHFvAL8/gF/DLO/hjs2UAyjbblB4x6z61GoCoTUHBstosZgS6FBSctbhy/J6AX57hL+BXZviPGi0DULbJ5ugjk45RuwGIRkBQsKxGSxmBTgQFJxVPyccF/PIMfgG/coM/NlcGoGxzLdlnhmIAolYFBctqtZQRaDUoWLIAtx5bwC/P4BfwKz/4Y1NlAMo21a09Iuf3QzMAI80KCpbVaykT0FpQMGfBTTqWgF+ewS/g19zgZwCaaaSTekaOx4doAKJuBQWb0W9uQ9B4UDBHoU06hoBfnsEv4Nf84I+N1B2Aso10Uu/I8fiQDUDUr6BgWf3mNgDxeEsNBQUXchTauGMI+OUZ/gJ+7Q3/URNlAMo20HG9I9djDMAvakdQsKyO4+DOvS0dFMxuAAT88gx+Ab9fNK94NdPGlgEo2zhzDftxx2EAzq4hQcGyes5tAOLxSgUFsxkAAb88g1/A7+ym1cbgj8/JAJRtmOMGd67HGIDxtSQoWFbTcWhn3xb408NzGwABvzyDX8BvfLOKg7itLQNQtlnmGvbjjsMATK8pQcGy2s5uABaeeL05g4IzGwABvzyDX8BvepNqa/DH52UAyjbJcYM712MMQFptCQqW1XgxI5AhKDiTARDwyzP8BfzSGlQcxm1sGYCyzTHXsB93HAZgZ/UlKFhW66WMwDxBwR0ZAAG/PINfwG9njamNwR+fkwEo2xTHDe5cjzEAs9WZoGBZzZcyArMEBZMMgIBfnsEv4DdbQ4rDuI0tA1C2GeYa9uOOwwDMXm+CgmV1X8oE7PQTBacaAAG/PINfwG/2RtTG0N/4nAxA2UY4bnDneowBmL/uBAXL6r+UEUgNCo41AAJ+eQa/gN/8DWjjMG7j3wxA2QaYa9iPOw4DkK/+BAXL1kExI7BNUPAsAyDgl2f4C/jlaz5tDP74nAxA2cY3bnDneowByF+DgoJl66GUEZgUFDxjAAT88gx+Ab/8TScO4za2DEDZhpdr2I87DgNQrhZf9e9/EG69/0AYx72vjz32wHK45+LLw9LTzg+lBnHbx90aFFwQ8Msz+AX8yjWbNgZ/fE4GgAGIWrDdXOOCgmVro5hZ2PCJggtLz7ygWrez/JI3h+Nfv62oSxXw29wUamuSDEDZJlfyatEdgGZqs9qg4DXfCHvP/efVzsfFZ7wsLBRzGU9+bGEbx9/3wteGI1dfG9ZOny42/AX8mmkubRsKBoABaFuDfXl+QcGytVJillZlAJaedUE4eNlnwuqhI8UG/+iKRcBvGMN/1HgZgLJNzR2A+mpJULBszeQ0AnUYgKeeFx6/5GPh9OJy0cEv4Fdfs9ru6ooBKNvMGIB6a0pQsGzt5DACvTcAj77+3eHUnfcVHfwCfvU2KQag3SbFANRdW4KC7dbXdiahtwZg+dwLw7G/vbHo4Bfwq7s5bTf8vQVQvnkxAMOosWqDgn/9zfDQeW/ubVCwdwZAwG8YDSNlODexj7cAypoABmBY9SwoWLaetrvi3/rz3hiApV96uYDfW4fVLJoY8Ns9BwNQtmExAMOsaUHBsnW1ddBP+r77BkDAL2w3pPy8XBNlAMo2KgagnHb70BcEBcvW16TBHx/vtAEQ8Bt2c+hCA2MAyjYoBkCNCwqWrbE47MdtO2kABPw0hS4M/9FrYADKNicGQK3HWhcULFtrnTcAAn6aQWwGXdkyAGWbEgOg5rfWuqBg2ZrbaAQ6cQdAwE8T2NoEuvI9A1C2GTEAan9SrQsKlq29kRFo1wAI+An4dfz/bGAAyjYhBoABmGQA4uOCguVqsDUDIOCn8GOBd3nLAJRrPqMrEAZAH0ipf0HBMnXYuAEQ8FPwKQXflX0YgDKNJ74PyQDoBzupdUHBvPXYmAEQ8FPoOyn0ruzLAORtOHHwxy0DoC/MUuuCgnnqsrgBEPBT4LMUeFd+hwHI02jiwN+6ZQD0h3lqXVBwvvosZwAE/AT8Oh7wS2k8DMB8DWbrwN/6PQPAAKTU4Xb7jIKCt91/oGimpKRWxx37sQeWwz0XXx6WnnZ+sT82VMQACPgp6u0Kti8/ZwAYgL5odeivU1Bw57Wa1QAI+Bn8tTUhBmDnTWXrVf6078dd+eR6bLR2tenR+WzfYwUF02s2iwEQ8NtelAq3n4wYgPRmMm3QT/pZrmE/7jgMQD9rLlevFBTcvnbnMgACfsMusFyF2uXjMADbN5FJwz3l8XGDO9djDID+NOotgoKTa3g2AyDg59ZiBQG/FOPBAExuHikDfrt9cg37ccdhABiAjTUuKHh2Le/YAAj4KaqNRVX7vxmAs5vGdkN9Jz8fN7hzPcYA6FVb+5Og4OZ6TjYATQT8Tp5eDZ+7fm947rtucYU9kCvsrQXate8ZgM0NYyfDPWXfXMN+3HEYAAZgUj8RFHyirrc1AE0G/F70oW8b/AZ/pzTAADAAk4aIx/tvMIYeFJxoAAT8+i9uDWr+NWQAGAB1NH8ddZ3hP/nwd8K1u5ar+iChI48fDXd95Ath6TmvmPhBQmcbgIYCfj/7+fFwyVX3htF7Ml0Xh9c33DViABgA9T+c+h9aUHCTARDwG47QNbW0tWYAGAC1klYrtXAaUlBw3QA0FfC7+huL4R/8q1td8XufvzcaYAAYgFoGm/PYmZEZQlBw4fBfXH3/2unTX1tbW7u+1NfDj5345iVX3bv0u5+646AvDPqkgf9z+2PfK1UXo+M++nv/8uCQv0qyHa1dn7TmtXazN/7BZ3+4fN/i0ZtKarXpY6+cOvX12//0L08t+A8BBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBBBAAAEEEEAAAQQQQAABBDYT+P8oiTFCVsPX4wAAAABJRU5ErkJggg==" />
                                      </defs>
                                    </svg>
                                  </span>
                                </label>
                              </div>
                            </div>


                          </div>
                          <div class="buttons pt-3 pb-4">
                            <button type="button" class="cancelBtn" data-bs-dismiss="modal">Close</button>
                            <a href="http://zeroifta.test/companies/delete/3" class="mainBtn">Submit</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="up-img">
              <div class="dropdown">
                @if(Auth::user()->image)
                <img src="{{asset('images')}}/{{Auth::user()->image}}" alt="ZeroIfta Image" onclick="toggleDropdown()" style="height: 30px;border-radius:100%" />
                @else
                <img src="{{asset('assets/img/user-img.png')}}" alt="ZeroIfta Image" onclick="toggleDropdown()" />
                @endif
                <!-- <img src="user_image_url.jpg" onclick="toggleDropdown()" class="dropbtn" alt="User"> -->
                <div id="myDropdown" class="dropdown-content">
                  <div class="hdd-inn">
                    <div>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M13.5625 11.4375H12.4641C12.3891 11.4375 12.3188 11.4703 12.2719 11.5281C12.1625 11.661 12.0453 11.7891 11.9219 11.911C11.417 12.4163 10.819 12.8191 10.1609 13.0969C9.47915 13.3849 8.74636 13.5326 8.00625 13.5313C7.25781 13.5313 6.53281 13.3844 5.85156 13.0969C5.19347 12.8191 4.59547 12.4163 4.09063 11.911C3.58487 11.4073 3.1816 10.8103 2.90313 10.1531C2.61406 9.4719 2.46875 8.74846 2.46875 8.00002C2.46875 7.25159 2.61563 6.52815 2.90313 5.8469C3.18125 5.18909 3.58125 4.5969 4.09063 4.08909C4.6 3.58127 5.19219 3.18127 5.85156 2.90315C6.53281 2.61565 7.25781 2.46877 8.00625 2.46877C8.75469 2.46877 9.47969 2.61409 10.1609 2.90315C10.8203 3.18127 11.4125 3.58127 11.9219 4.08909C12.0453 4.21252 12.1609 4.34065 12.2719 4.4719C12.3188 4.52971 12.3906 4.56252 12.4641 4.56252H13.5625C13.6609 4.56252 13.7219 4.45315 13.6672 4.37034C12.4688 2.50784 10.3719 1.27502 7.98906 1.28127C4.24531 1.29065 1.24375 4.32971 1.28125 8.06877C1.31875 11.7485 4.31563 14.7188 8.00625 14.7188C10.3828 14.7188 12.4703 13.4875 13.6672 11.6297C13.7203 11.5469 13.6609 11.4375 13.5625 11.4375ZM14.9516 7.90159L12.7344 6.15159C12.6516 6.08596 12.5312 6.14534 12.5312 6.25002V7.43752H7.625C7.55625 7.43752 7.5 7.49377 7.5 7.56252V8.43752C7.5 8.50627 7.55625 8.56252 7.625 8.56252H12.5312V9.75002C12.5312 9.85471 12.6531 9.91409 12.7344 9.84846L14.9516 8.09846C14.9665 8.08677 14.9786 8.07183 14.9869 8.05477C14.9952 8.03772 14.9995 8.019 14.9995 8.00002C14.9995 7.98105 14.9952 7.96233 14.9869 7.94527C14.9786 7.92822 14.9665 7.91328 14.9516 7.90159Z" />
                      </svg>
                    </div>
                    <div>
                      <a href="{{route('password.change')}}"><span>Change Password</span></a>
                    </div>

                  </div>
                  <div class="hdd-inn">
                    <div>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M13.5625 11.4375H12.4641C12.3891 11.4375 12.3188 11.4703 12.2719 11.5281C12.1625 11.661 12.0453 11.7891 11.9219 11.911C11.417 12.4163 10.819 12.8191 10.1609 13.0969C9.47915 13.3849 8.74636 13.5326 8.00625 13.5313C7.25781 13.5313 6.53281 13.3844 5.85156 13.0969C5.19347 12.8191 4.59547 12.4163 4.09063 11.911C3.58487 11.4073 3.1816 10.8103 2.90313 10.1531C2.61406 9.4719 2.46875 8.74846 2.46875 8.00002C2.46875 7.25159 2.61563 6.52815 2.90313 5.8469C3.18125 5.18909 3.58125 4.5969 4.09063 4.08909C4.6 3.58127 5.19219 3.18127 5.85156 2.90315C6.53281 2.61565 7.25781 2.46877 8.00625 2.46877C8.75469 2.46877 9.47969 2.61409 10.1609 2.90315C10.8203 3.18127 11.4125 3.58127 11.9219 4.08909C12.0453 4.21252 12.1609 4.34065 12.2719 4.4719C12.3188 4.52971 12.3906 4.56252 12.4641 4.56252H13.5625C13.6609 4.56252 13.7219 4.45315 13.6672 4.37034C12.4688 2.50784 10.3719 1.27502 7.98906 1.28127C4.24531 1.29065 1.24375 4.32971 1.28125 8.06877C1.31875 11.7485 4.31563 14.7188 8.00625 14.7188C10.3828 14.7188 12.4703 13.4875 13.6672 11.6297C13.7203 11.5469 13.6609 11.4375 13.5625 11.4375ZM14.9516 7.90159L12.7344 6.15159C12.6516 6.08596 12.5312 6.14534 12.5312 6.25002V7.43752H7.625C7.55625 7.43752 7.5 7.49377 7.5 7.56252V8.43752C7.5 8.50627 7.55625 8.56252 7.625 8.56252H12.5312V9.75002C12.5312 9.85471 12.6531 9.91409 12.7344 9.84846L14.9516 8.09846C14.9665 8.08677 14.9786 8.07183 14.9869 8.05477C14.9952 8.03772 14.9995 8.019 14.9995 8.00002C14.9995 7.98105 14.9952 7.96233 14.9869 7.94527C14.9786 7.92822 14.9665 7.91328 14.9516 7.90159Z" />
                      </svg>
                    </div>
                    <div>
                      <a href="{{route('logout')}}"><span>Logout</span></a>
                    </div>

                  </div>

                </div>
              </div>
            </div>
            <div class="mob-menu">
              <div id="hamburgerIcon" class="hamburger-icon">
                &#9776;
                <!-- Simple hamburger icon, you can replace this with an SVG or icon font -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
