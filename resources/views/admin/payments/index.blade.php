@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
  <!-- Section 1 -->
  

  <!-- Data Table -->
  <div class="sec1-style">
    <div class="data_table table-span table-responsive">
      <table id="example" class="table table-comm">
        <thead>
          <tr>
          <th scope="col">Company Name</th>
              <th scope="col">Plan Name</th>
              <th scope="col">Payments</th>
              <th scope="col">Status</th>
              <th scope="col">Purchased date</th>
          </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
          <tr>
          <td>
                <div class="table-conTab">
                  <span>{{$payment->user->name ?? ''}}</span>
                </div>
              </td>
              <td>
                <span>{{$payment->planName->name ?? ''}}</span>
              </td>
              <td><span>${{$payment->amount}}</span></td>
              <td><span>{{$payment->status}}</span></td>
              <td>
                <span>{{$payment->created_at->format('Y-m-d')}}</span>
              </td>
          </tr>
          @endforeach
         
          
          
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection