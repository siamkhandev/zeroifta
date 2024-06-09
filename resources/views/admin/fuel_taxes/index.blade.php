@extends('layouts.main')
@section('content')
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
            @if(Session::has('success'))
                <div class="alert alert-success" style="color:white">{{Session::get('success')}}</div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger" style="color:white">{{Session::get('error')}}</div>
            @endif
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Fuel Taxes table</h6>
              <a href="{{route('fuel_taxes.create')}}" class="btn btn-primary" style="float:right">Add Fuel Tax</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">State</th>
                      <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7">Alpha Code</th>
                      <th class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">IFTA Tax %</th>
                      
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($fuelTaxes)>0)
                    @foreach($fuelTaxes as $tax)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{$tax->name}}</h6>
                            <p class="text-xs text-secondary mb-0"></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0 text-center">{{$tax->code}}</p>
          
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0 text-center">${{$tax->tax}}</p>
                       
                      </td>
                     
                     
                      
                      <td class="align-middle">
                        <a href="{{route('fuel_taxes.edit',$tax->id)}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-original-title="Edit user">
                          Edit
                        </a>
                       
                        <a href="{{route('fuel_taxes.delete',$tax->id)}}"  class="btn btn-sm btn-danger" >
                          Delete
                        </a>
                      </td>
                    </tr>
                    
                   @endforeach
                   @else
                   <tr>
                    <td colspan="5" class="text-center">
                    <p>No records found</p>
                    </td>
                   </tr>
                  
                   @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    
    </div>
  @endsection