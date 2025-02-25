@extends('layouts.main')
@section('content')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <div class="alert alert-success" style="color:white">{{Session::get('success')}}</div>
            @endif
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">{{__('messages.Contact Form')}}</p>
              </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('company.contactus.submit')}}" enctype="multipart/form-data">
                    @csrf
                    <p class="text-uppercase text-sm">{{__('messages.Information')}}</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">{{__('messages.Subject')}}</label>
                                <input class="form-control" type="text" name="subject" placeholder="{{__('messages.Subject')}}">
                                @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">{{__('messages.Phone')}}</label>
                                <input class="form-control" type="text" name="phone" placeholder="{{__('messages.Phone')}}">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">{{__('messages.Message')}}</label>
                                <textarea class="form-control" name="description"></textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        
                        </div>
                        
                        
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" >{{__('messages.Submit')}}</button>
                </form>
              
             
            </div>
          </div>
        </div>
        
      </div>
     
    </div>

@endsection