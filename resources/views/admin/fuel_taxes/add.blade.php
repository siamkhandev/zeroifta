@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
                            <!-- Section 1 -->
                            <div class="profileForm-area mb-4">
                            <form method="post" action="{{route('fuel_taxes.store')}}">
                            @csrf
                                <div class="sec1-style">
                                    <div class="row pt-3">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                            <div class="dash-input mb-3">
                                                <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">State Name</label>
                                                <input type="text" class="form-control login-input" id="exampleFormControlInput1" name="name" placeholder="Name" value="{{old('name')}}"/>
                                            </div>
                                            @error('name')
                                              <span class="invalid-feedback" role="alert" style="display: block;">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                            <div class="dash-input mb-3">
                                                <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">State Code</label>
                                                <input type="text" class="form-control login-input" id="exampleFormControlInput1" name="code" placeholder="Code"  value="{{old('code')}}"/>
                                            </div>
                                            @error('code')
                                                <span class="invalid-feedback" role="alert" style="display: block;">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                            <div class="dash-input mb-1">
                                                <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">Tax %</label>
                                                <input type="number" class="form-control login-input dis-input" id="exampleFormControlInput1" name="tax" placeholder="Tax" max="100" value="{{old('tax')}}" />
                                            </div>
                                            @error('tax')
                                                <span class="invalid-feedback" role="alert" style="display: block;">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="buttons mt-5">
                                        <a href="#" class="cancelBtn">Cancel</a>
                                        <button type="submit"  class="mainBtn">Submit</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>

@endsection