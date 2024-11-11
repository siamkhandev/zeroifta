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
              <img src="{{asset('images')}}/{{Auth::user()->image}}" alt="profile_image" class="profile-img border-radius-lg shadow-sm">




              @else
              <!-- <img src="{{asset('assets/user.png')}}" alt="profile_image" class="w-100 border-radius-lg shadow-sm" style="height: 100px;"> -->
              <span class="profile-ph">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" fill="none">
                  <path d="M154.167 168.725V133.333C154.167 133.333 133.333 120.833 100 120.833C66.6667 120.833 45.8333 133.333 45.8333 133.333V168.725M12.5 100C12.5 51.675 51.675 12.5 100 12.5C148.325 12.5 187.5 51.675 187.5 100C187.5 148.325 148.325 187.5 100 187.5C51.675 187.5 12.5 148.325 12.5 100ZM99.3833 104.167C99.3833 104.167 70.8333 89 70.8333 66.6667C70.8333 50.5583 83.9083 37.5 100.033 37.5C103.862 37.4989 107.654 38.2528 111.191 39.7186C114.728 41.1844 117.942 43.3333 120.648 46.0423C123.354 48.7513 125.499 51.9673 126.961 55.5063C128.423 59.0452 129.172 62.8377 129.167 66.6667C129.167 89 100.617 104.167 100.617 104.167H99.3833Z" stroke="white" stroke-width="3" />
                </svg>
              </span>

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
                  <input type="text" class="form-control dis-input" id="exampleFormControlInput1" placeholder="Add Name" name="name" value="{{Auth::user()->name}}" />
                </div>
                @error('name')
                <span class="invalid-feedback" role="alert" style="display: block;">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-3">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Email Address</label>
                  <input type="email" class="form-control dis-input" id="exampleFormControlInput1" placeholder="test@email.com" name="email" value="{{Auth::user()->email}}" />
                </div>
                @error('email')
                <span class="invalid-feedback" role="alert" style="display: block;">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>

              <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-3">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Phone</label>
                  <input type="text" class="form-control dis-input" id="exampleFormControlInput1" placeholder="+92345623947234" name="phone" value="{{Auth::user()->phone}}" />
                </div>
                @error('phone')
                <span class="invalid-feedback" role="alert" style="display: block;">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-3">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">MC</label>
                  <input type="text" class="form-control dis-input" id="exampleFormControlInput1" placeholder="9898" name="mc" value="{{Auth::user()->mc}}" />
                </div>
                @error('mc')
                <span class="invalid-feedback" role="alert" style="display: block;">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
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
                @error('dot')
                <span class="invalid-feedback" role="alert" style="display: block;">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                <div class="dash-input mb-3">
                  <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Profile Picture</label>
                  <input type="file" class="form-control dis-input" id="exampleFormControlInput1" name="image" accept="image/png, image/jpg, image/jpeg" />
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
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