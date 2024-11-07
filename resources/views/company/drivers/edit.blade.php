@extends('layouts.new_main')
@section('content')

<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        <div class="sec1-style">
        <form method="post" action="{{route('driver.update',$driver->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="row pt-3">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Name</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="Type Name" name="name" value="{{$driver->name}}"/>
                    </div>
                    @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Email</label>
                        <input type="email" class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Email" name="email" value="{{$driver->email}}" />
                    </div>
                    @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Phone</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="Add Phone" name="phone" value="{{$driver->phone}}" />
                    </div>
                    @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">DOT</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="Add DOT" name="dot" value="{{$driver->dot}}" />
                    </div>
                    @error('dot')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">MC</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="Add MC" name="mc" value="{{$driver->mc}}" />
                    </div>
                    @error('mc')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Profile Picture</label>
                        <input type="file" class="form-control login-input" id="exampleFormControlInput1"  name="image"  />
                    </div>
                    @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>


            </div>
            <div class="buttons mt-5">
                <a href="#" class="cancelBtn">Cancel</a>
                <button type="submit"  class="mainBtn">Submit</a>
            </div>
        </div>
    </div>
</div>
@endsection
