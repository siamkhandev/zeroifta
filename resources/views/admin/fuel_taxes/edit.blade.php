@extends('layouts.main')
@section('content')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Edit Fuel Tax</p>
              </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('fuel_taxes.update',$fuelTax->id)}}">
                    @csrf
                    <p class="text-uppercase text-sm">Fuel Tax Information</p>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Name</label>
                            <input class="form-control" type="text" name="name" value="{{$fuelTax->name}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Tax %</label>
                            <input class="form-control" type="number" name="tax" value="{{$fuelTax->tax}}" max="100">
                        </div>
                        @error('tax')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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