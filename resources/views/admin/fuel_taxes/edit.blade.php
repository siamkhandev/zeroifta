@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
                            <!-- Section 1 -->
                            <div class="profileForm-area mb-4">
                            <form method="post" action="{{route('fuel_taxes.update',$fuelTax->id)}}">
                            @csrf
                                <div class="sec1-style">
                                    <div class="row pt-3">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                            <div class="dash-input mb-3">
                                                <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.State Name')}}</label>
                                                <input type="text" class="form-control login-input" id="exampleFormControlInput1" name="name" placeholder="{{__('messages.State Name')}}" value="{{$fuelTax->name}}"/>
                                            </div>
                                            @error('name')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                            <div class="dash-input mb-3">
                                                <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.State Code')}}</label>
                                                <input type="text" class="form-control login-input" id="exampleFormControlInput1" name="code" placeholder="{{__('messages.State Code')}}"  value="{{$fuelTax->code}}"/>
                                            </div>
                                            @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                            <div class="dash-input mb-1">
                                                <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Tax')}} %</label>
                                                <input type="number" class="form-control login-input dis-input" id="exampleFormControlInput1" name="tax" placeholder="{{__('messages.Tax')}}" max="100" value="{{$fuelTax->tax}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttons mt-5">
                                        <a href="{{route('fuel_taxes')}}" class="cancelBtn">{{__('messages.Cancel')}}</a>
                                        <button type="submit"  class="mainBtn">{{__('messages.Submit')}}</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>


@endsection
