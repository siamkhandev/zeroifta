@extends('layouts.main')
@section('content')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Edit Plan</p>
              </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('plans.update',$plan->id)}}">
                    @csrf
                    <p class="text-uppercase text-sm">Plan Information</p>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Name</label>
                            <input class="form-control" type="text" name="name" value="{{$plan->name}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Price</label>
                            <input class="form-control" type="number" name="price" value="{{$plan->price}}">
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          </div>
                        
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Price Type</label>
                           <select name="price_type" class="form-control">
                            <option value="">Select</option>
                            <option value="free" {{$plan->price_type=="free" ? 'selected':''}}>Free</option>
                            <option value="paid" {{$plan->price_type=="paid" ? 'selected':''}}>Paid</option>
                           </select>
                            @error('price_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        
                        </div>
                        
                        
                        
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" >Update</button>
                </form>
              
             
            </div>
          </div>
        </div>
        
      </div>
     
    </div>

@endsection