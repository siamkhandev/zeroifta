@extends('layouts.main')
@section('content')
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">View Ad</p>
                
              </div>
            </div>
            <div class="card-body">
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Name</label>
                    <input class="form-control" type="text" value="{{$ad->name}}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">User Name</label>
                    <input class="form-control" type="email" value="{{$ad->user->name ?? 'N/A'}}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Longitude</label>
                    <input class="form-control" type="text" value="{{$ad->lang}}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Latitude</label>
                    <input class="form-control" type="text" value="{{$ad->lat}}">
                  </div>
                </div>
              </div>
              <hr class="horizontal dark">
              
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Bio</label>
                    <textarea class="form-control" type="text" >{{$ad->bio}}</textarea>
                  </div>
                </div>
               
              </div>
              <a href="{{route('ads')}}" class="btn btn-primary">Back</a>
            </div>
          </div>
        </div>
       
      </div>
      
    </div>

@endsection