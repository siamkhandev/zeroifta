@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
                            <!-- Section 1 -->
                            <div class="manage-comp mb-4">
                                <div class="Filters-main mb-3 mb-md-4">
                                    <div class="sec1-style">
                                        <div class="subs_plan">
                                            <div class="inHead-span">
                                                <h2 class="head-20Med">{{__('messages.Subscription Plans')}}</h2>
                                            </div>
                                            <div class="row" style="align-items: center">
                                              @if(Auth::user()->is_subscribed==1)
                                              <div class="col-md-4 col-sm-12 col-12 mb-4">
                                                    <div class="price_plans plan-com weekly-plan">
                                                        <div class="ph-area">
                                                            <h3>{{__('messages.Cancel Subscription')}}</h3>

                                                        </div>
                                                        <div class="pp-inn" style="height: 70px;">
                                                            <p>{{__('messages.Press cancel button to cancel your subscription. You will no longer be charged after cancellation.')}}</p>
                                                        </div>
                                                        @if(isset($userPlan) && isset($userPlan->stripe_subscription_id))
                                                        <a href="{{route('cancel.subscription',$userPlan->stripe_subscription_id)}}" class="mainBtn" style="margin-top: 20px;">{{__('messages.Cancel Subscription')}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                              @else
                                            @foreach($plans as $plan)
                                                <div class="col-md-4 col-sm-12 col-12 mb-4">
                                                    <div class="price_plans plan-com weekly-plan">
                                                        <div class="ph-area">
                                                            <h3>{{$plan->name}}</h3>
                                                            <p>${{$plan->price}}</p>
                                                        </div>
                                                        <div class="pp-inn">
                                                            <ul>
                                                                <li>
                                                                    <span>Recurring</span>
                                                                </li>
                                                                <li>
                                                                    <span>Tax Free</span>
                                                                </li>
                                                                <li>
                                                                    <span>Recurring</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <a href="{{route('purchase',$plan->id)}}" class="mainBtn" >{{__('messages.Purchase')}}</a>
                                                    </div>
                                                </div>
                                               @endforeach
                                               @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


@endsection
