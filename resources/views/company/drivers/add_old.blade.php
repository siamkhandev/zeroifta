@extends('layouts.main')
@section('content')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Add Driver</p>
              </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('driver.store')}}" enctype="multipart/form-data">
                    @csrf
                    <p class="text-uppercase text-sm">Driver Information</p>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Name</label>
                            <input class="form-control" type="text" name="name" placeholder="Name" value="{{old('name')}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email</label>
                                <input class="form-control" type="email" name="email" placeholder="Email" value="{{old('email')}}">
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Phone</label>
                                <input class="form-control" type="number" name="phone" placeholder="Phone" value="{{old('phone')}}">
                            </div>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">DOT</label>
                                <input class="form-control" type="text" name="dot" placeholder="DOT" value="{{old('dot')}}">
                            </div>
                            @error('dot')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">MC</label>
                                    <input class="form-control" type="text" name="mc" placeholder="MC" value="{{old('mc')}}">
                                </div>
                            @error('mc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Profile Picture</label>
                                    <input class="form-control" type="file" name="image" >
                                </div>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="Password">
                                </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Confirm Password</label>
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password">
                                </div>

                        </div>


                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" >Submit</button>
                </form>


            </div>
          </div>
        </div>

      </div>

    </div>

@endsection
