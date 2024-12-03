@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        <div class="sec1-style">
        <form method="post" action="{{route('driver.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row pt-3">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">First Name</label>
                        <input type="text" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Type First Name" name="first_name" value="{{old('first_name')}}"/>
                    </div>
                    @error('first_name')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Email</label>
                        <input type="email" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Email" name="email" value="{{old('email')}}" />
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
                        <input type="text" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Phone" name="phone" value="{{old('phone')}}" />
                    </div>
                    @error('phone')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">DOT</label>
                        <input type="text" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Add DOT" name="dot" value="{{old('dot')}}" />
                    </div>
                    @error('dot')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">MC</label>
                        <input type="text" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Add MC" name="mc" value="{{old('mc')}}" />
                    </div>
                    @error('mc')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Profile Picture</label>
                        <input type="file"  class="form-control login-input" id="exampleFormControlInput1"  name="image"  />
                    </div>
                    @error('image')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Password</label>
                        <input type="password" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Password" name="password"  value="{{old('password')}}"/>
                    </div>
                    @error('password')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Confirm Password</label>
                        <input type="password" required class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Confirm Password" name="password_confirmation"  value="{{old('password_confirmation')}}"/>
                    </div>

                </div>
            </div>
            <div class="buttons mt-5">
                <a href="{{route('drivers.all')}}" class="cancelBtn">Cancel</a>
                <button type="submit"  class="mainBtn">Submit</a>
            </div>
        </div>
    </div>
</div>
@endsection
