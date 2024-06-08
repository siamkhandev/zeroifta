@extends('layouts.main')
@section('content')
<div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
    <span class="mask bg-primary opacity-6"></span>
  </div>
<div class="card shadow-lg mx-4 card-profile-bottom">
      <div class="card-body p-3">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
                @if(Auth::user()->image)
                <img src="{{asset('images')}}/{{Auth::user()->image}}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                @else
                <img src="../assets/img/team-1.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            @endif
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                {{Auth::user()->name}}
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
              {{Auth::user()->email}}
              </p>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Edit Profile</p>
               
              </div>
            </div>
            <div class="card-body">
              <p class="text-uppercase text-sm">User Information</p>
              <form method="post" action="{{route('profile.update')}}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Name</label>
                        <input class="form-control" type="text" name="name" value="{{Auth::user()->name}}">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Email address</label>
                        <input class="form-control" type="email" name="email" value="{{Auth::user()->email}}">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Phone</label>
                        <input class="form-control" type="text" name="phone" value="{{Auth::user()->phone}}">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">MC</label>
                        <input class="form-control" type="text" name="mc" value="{{Auth::user()->mc}}">
                    </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">DOT</label>
                        <input class="form-control" type="text" name="dot" value="{{Auth::user()->dot}}">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">City</label>
                        <input class="form-control" type="text" name="city" value="{{Auth::user()->city}}">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">State</label>
                        <input class="form-control" type="text" name="state" value="{{Auth::user()->state}}">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Image</label>
                        <input class="form-control" type="file" name="image" v>
                    </div>
                    </div>
                
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
              
            </div>
          </div>
        </div>
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                    Change Password
                </div>
                <div class="card-body pt-0">
                    @if(Session::has('success'))
                    <p class="text-success">{{Session::get('success')}}</p>
                    @endif
                    @if(Session::has('error'))
                    <p class="text-danger">{{Session::get('error')}}</p>
                    @endif
                    <form action="{{route('passwords.update')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label>Current Password</label>
                                <input type="password" class="form-control" name="current_password" placeholder="Current Password">
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                            </div>
                            <div class="col-md-12" style="margin-top: 10px;">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
      <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                for a better web.
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>

@endsection