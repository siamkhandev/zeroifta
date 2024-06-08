@extends('layouts.main')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
        @if(Session::has('success'))
            <div class="alert alert-success" style="color:white">{{Session::get('success')}}</div>
        @endif
        </div>
        <div class="col-lg-8">
            <div class="row">
                @if(Auth::user()->is_subscribed==1)
                <div class="col-lg-6">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Cancel Subscription</h5>
                            
                            <p class="">Press cancel button to cancel your subscription. You will no longer be charged after cancellation.</p>
                            <a href="{{route('cancel.subscription',$userPlan->stripe_subscription_id)}}" class="btn btn-primary" style="width: 240px;">Cancel</a>
                        </div>
                    </div>
                </div>
                @else
                @foreach($plans as $plan)
                <div class="col-lg-6">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{$plan->name}}</h5>

                            <!-- <p class="card-text">{{$plan->description}}</p> -->
                            @if($plan->recurring==1)
                            <p>After purchasing this plan, payments will be automatically deducted from your card.</p>
                            @endif
                            <h5 class="card-title text-center">${{$plan->price}}</h5>
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