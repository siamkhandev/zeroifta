@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        <div class="sec1-style">
        <form method="post" action="{{route('plans.store')}}">
            @csrf
            <div class="row pt-3">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Name')}}</label>
                        <input type="text" class="form-control login-input" required id="exampleFormControlInput1" placeholder="{{__('messages.Name')}}" name="name" value="{{old('name')}}"/>
                    </div>
                    @error('name')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Price')}}</label>
                        <input type="number" class="form-control login-input" required min="0" id="exampleFormControlInput1" placeholder="{{__('messages.Price')}}" name="price" value="{{old('price')}}" />
                    </div>
                    @error('price')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-1">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Billing Period')}}</label>
                        <select class="form-control login-input" id="exampleFormControlInput1" name="billing_period" required>
                                <option value="month">Monthly</option>
                                <option value="year">Yearly</option>
                            </select>
                            @error('price_type')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-1">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Is Recurring?')}}</label>
                        <select class="form-control login-input" id="recurring" name="recurring" required>
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                              </select>
                              @error('recurring')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Plan Description')}}</label>
                        <div class="textArea dash-input">
                            <textarea class="" name="description" id="" rows="3" placeholder="{{__('messages.Plan Description')}}" ></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons mt-5">
                <a href="{{route('plans')}}" class="cancelBtn">{{__('messages.Cancel')}}</a>
                <button type="submit"  class="mainBtn">{{__('messages.Submit')}}</a>
            </div>
        </div>
    </div>
</div>

@endsection
