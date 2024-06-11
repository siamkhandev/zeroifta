@extends('layouts.main')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
        @if(Session::has('success'))
            <div class="alert alert-success" style="color:white">{{Session::get('success')}}</div>
        @endif
        </div>
        <div class="col-lg-12">
            <div class="row">
                @if(Auth::user()->is_subscribed==1)
                <div class="col-lg-4">
                    <div class="card" >
                        <div class="card-body">
                            <h5 class="card-title">Cancel Subscription</h5>
                            
                            <p class="">Press cancel button to cancel your subscription. You will no longer be charged after cancellation.</p>
                            <a href="{{route('cancel.subscription',$userPlan->stripe_subscription_id)}}" class="btn btn-primary" style="width: 240px;">Cancel</a>
                        </div>
                    </div>
                </div>
                @else
                @foreach($plans as $plan)
                <div class="col-lg-4">
                <div class="card">
                    <div class="card-header mx-4 p-3 text-center">
                      <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                        <i class="fas fa-landmark opacity-10" aria-hidden="true"></i>
                      </div>
                    </div>
                    <div class="card-body pt-0 p-3 text-center">
                      <h6 class="text-center mb-0">{{$plan->name}}</h6>
                      @if($plan->recurring==1)
                        <span class="text-xs">After purchasing this plan, payments will be automatically deducted from your card.</span>
                        @endif
                      <hr class="horizontal dark my-3">
                      <h5 class="mb-0">${{$plan->price}}</h5>
                      <a href="{{route('purchase',$plan->id)}}" class="btn btn-primary" style="width: 240px;">Purchase</a>
                    </div>
                  </div>
                    
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>


@endsection