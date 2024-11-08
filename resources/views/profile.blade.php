@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
  <div class="profile-area mb-4">
    <div class="style-bg">
      <div class="sec2-style">
        <div class="prof-img">
          <div class="up-head">
            <div class="up-headLeft">
              @if(Auth::user()->image)
              <img src="{{asset('images')}}/{{Auth::user()->image}}" alt="profile_image" class="border-radius-lg shadow-sm">
              @else
              <img src="../assets/img/team-1.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm" style="height: 80px;">
              @endif
              <div class="up-info">
                <p class="head-18Med">{{Auth::user()->name}}</p>
                <p class="head-14Med white">{{Auth::user()->email}}</p>
              </div>
            </div>
            <!-- <div class="edit-icon">
                            <a class="hover" href="profile-management-form.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 45 45" fill="none">
                                    <path
                                        d="M35.1562 5.66864C34.0791 5.66864 33.0244 6.0863 32.2116 6.89911L18.2812 20.7858L17.9733 21.0938L17.8861 21.534L16.9186 26.4558L16.4798 28.5202L18.5456 28.0815L23.4675 27.114L23.9062 27.0268L24.2142 26.7188L38.1009 12.7885C38.683 12.205 39.0792 11.4622 39.2397 10.6539C39.4002 9.84548 39.3178 9.00768 39.0029 8.24607C38.688 7.48447 38.1546 6.83314 37.47 6.37421C36.7855 5.91528 35.9804 5.67069 35.1562 5.66864ZM35.1562 8.39395C35.4853 8.39395 35.8102 8.5627 36.1237 8.8763C36.7495 9.50349 36.7495 10.1841 36.1237 10.8099L22.5 24.435L20.0827 24.9188L20.5664 22.5015L34.1902 8.87771C34.5023 8.56552 34.8272 8.39395 35.1562 8.39395ZM5.625 11.25V39.3751H33.75V20.8294L30.9375 23.6419V36.5626H8.4375V14.0625H21.3581L24.1706 11.25H5.625Z"
                                        fill="white"
                                    />
                                </svg>
                            </a>
                        </div> -->
          </div>
        </div>
        <!-- Profile Inner -->
        <div class="sec-stylePad">
          <form method="post" action="{{route('profile.update')}}" enctype="multipart/form-data">
            @csrf
            <div class="row pt-3">

              <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-3">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Name</label>
                  <input type="text" class="form-control dis-input" id="exampleFormControlInput1" placeholder="Shahzaib Sohaib" name="name" value="{{Auth::user()->name}}" />
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-3">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Email Address</label>
                  <input type="email" class="form-control dis-input" id="exampleFormControlInput1" placeholder="test@email.com" name="email" value="{{Auth::user()->email}}" />
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-1">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Password</label>
                  <input type="email" class="form-control dis-input" id="exampleFormControlInput1" placeholder="123456789" disabled />
                </div>
                <!-- <div class="chnage-pass text-end">
                  <a class="hover" href="#">Change Password</a>
                </div> -->
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-3">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Phone</label>
                  <input type="text" class="form-control dis-input" id="exampleFormControlInput1" placeholder="+92345623947234" name="phone" value="{{Auth::user()->phone}}" />
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-3">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">MC</label>
                  <input type="text" class="form-control dis-input" id="exampleFormControlInput1" placeholder="9898" name="mc" value="{{Auth::user()->mc}}" />
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-3">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">City</label>
                  <input type="text" class="form-control dis-input" id="exampleFormControlInput1" placeholder="London" name="city" value="{{Auth::user()->city}}" />
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-3">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">State</label>
                  <input type="text" class="form-control dis-input" id="exampleFormControlInput1" placeholder="London" name="state" value="{{Auth::user()->state}}" />
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-3">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Dot</label>
                  <input type="text" class="form-control dis-input" id="exampleFormControlInput1" placeholder="ssdgg5778534873" name="dot" value="{{Auth::user()->dot}}" />
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2 pt-1">
                <h2 class="head-20Med"> Change Password</h2>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2 pt-2">
                <div class="dash-input mb-1">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Current Password</label>
                  <input type="email" class="form-control dis-input" id="exampleFormControlInput1" placeholder="123456789" disabled />
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-1">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">New Password</label>
                  <input type="email" class="form-control dis-input" id="exampleFormControlInput1" placeholder="123456789" disabled />
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2 pt-4">
                <div class="dash-input mb-3">
                  <button type="submit" class="mainBtn">Submit</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection