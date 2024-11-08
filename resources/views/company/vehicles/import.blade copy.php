@extends('layouts.main')
@section('content')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Import Vehicle</p>
              </div>
              <a href="{{ asset('vehicle.xlsx') }}" download class="btn btn-warning" style="float: right;">Download Sample File</a>
            </div>
            
            <div class="card-body">
               
                <form method="post" action="{{route('vehicle.import')}}" enctype="multipart/form-data">
                    @csrf
                   
                    <div class="row">
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">File (Excel)</label>
                            <input type="file" name="file" class="form-control" >
                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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