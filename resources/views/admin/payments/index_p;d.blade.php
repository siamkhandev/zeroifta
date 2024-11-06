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
              <h6>Payments table</h6>
             
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Company Name</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Plan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Purchased Date</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($payments)>0)
                    @foreach($payments as $payment)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{$payment->user->name ?? ''}}</h6>
                            <p class="text-xs text-secondary mb-0"></p>
                          </div>
                        </div>
                      </td>
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{$payment->planName->name ?? ''}}</p>
                       
                      </td>
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">${{$payment->amount}}</p>
                       
                      </td>
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{$payment->status}}</p>
                       
                      </td>
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{$payment->created_at->format('Y-m-d')}}</p>
                       
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