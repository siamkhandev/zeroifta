@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
    <form method="post" action="{{route('companies.update',$company->id)}}">
    @csrf
        <div class="sec1-style">
            <div class="row pt-3">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Name')}}</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="{{__('messages.Name')}}"  name="name"  value="{{$company->name}}"/>
                    </div>
                    @error('name')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Email Address')}}</label>
                        <input type="email" class="form-control login-input" id="exampleFormControlInput1" placeholder="{{__('messages.Email Address')}}" name="email"  value="{{$company->email}}"/>
                    </div>
                    @error('email')
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>


                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Phone')}}</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" name="phone" placeholder="{{__('messages.Phone')}}" value="{{$company->phone}}" />
                    </div>
                    @error('phone')
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.MC')}}</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" placeholder="{{__('messages.MC')}}" name="mc" value="{{$company->mc}}" required/>
                    </div>
                    @error('mc')
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.DOT')}}</label>
                        <input type="text" class="form-control login-input dis-input" id="exampleFormControlInput1" name="dot" placeholder="{{__('messages.DOT')}}" value="{{$company->dot}}" required/>
                    </div>
                    @error('dot')
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.City')}}</label>
                        <input type="text" class="form-control login-input" id="exampleFormControlInput1" name="city" placeholder="{{__('messages.City')}}" value="{{$company->city}}"/>
                    </div>
                    @error('city')
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.State')}}</label>
                        <select name="state" class="form-control login-input" name="state">
                      <option value="">Select state</option>
                      <option value="Alabama" {{$company->state=="Alabama" ? 'selected':''}}> Alabama</option>
                      <option value="Arizona" {{$company->state=="Arizona" ? 'selected':''}}>Arizona</option>
                      <option value="Arkansas" {{$company->state=="Arkansas" ? 'selected':''}}>Arkansas</option>
                      <option value="California" {{$company->state=="California" ? 'selected':''}}>California</option>
                      <option value="Colorado" {{$company->state=="Colorado" ? 'selected':''}}>Colorado</option>
                      <option value="Connecticut" {{$company->state=="Connecticut" ? 'selected':''}}>Connecticut</option>
                      <option value="Delaware" {{$company->state=="Delaware" ? 'selected':''}}>Delaware</option>
                      <option value="Florida" {{$company->state=="Florida" ? 'selected':''}}>Florida</option>
                      <option value="Georgia" {{$company->state=="Georgia" ? 'selected':''}}>Georgia</option>
                      <option value="Idaho" {{$company->state=="Idaho" ? 'selected':''}}>Idaho</option>
                      <option value="Illinois" {{$company->state=="Illinois" ? 'selected':''}}>Illinois</option>
                      <option value="Indiana" {{$company->state=="Indiana" ? 'selected':''}}>Indiana</option>
                      <option value="Iowa" {{$company->state=="Iowa" ? 'selected':''}}>Iowa</option>
                      <option value="Kansas" {{$company->state=="Kansas" ? 'selected':''}}>Kansas</option>
                      <option value="Kentucky" {{$company->state=="Kentucky" ? 'selected':''}}>Kentucky</option>
                      <option value="Louisiana" {{$company->state=="Louisiana" ? 'selected':''}}>Louisiana</option>
                      <option value="Maine" {{$company->state=="Maine" ? 'selected':''}}>Maine</option>
                      <option value="Maryland" {{$company->state=="Maryland" ? 'selected':''}}>Maryland</option>
                      <option value="Massachusetts" {{$company->state=="Massachusetts" ? 'selected':''}}>Massachusetts</option>
                      <option value="Michigan" {{$company->state=="Michigan" ? 'selected':''}}>Michigan</option>
                      <option value="Minnesota" {{$company->state=="Minnesota" ? 'selected':''}}>Minnesota</option>
                      <option value="Mississippi" {{$company->state=="Mississippi" ? 'selected':''}}>Mississippi</option>
                                    <option value="Missouri" {{$company->state=="Missouri" ? 'selected':''}}>
                        Missouri</option>
                                    <option value="Montana" {{$company->state=="Montana" ? 'selected':''}}>
                        Montana</option>
                                    <option value="Nebraska" {{$company->state=="Nebraska" ? 'selected':''}}>
                        Nebraska</option>
                                    <option value="Nevada" {{$company->state=="Nevada" ? 'selected':''}}>
                        Nevada</option>
                                    <option value="New Hampshire" {{$company->state=="New Hampshire" ? 'selected':''}}>
                        New Hampshire</option>
                                    <option value="New Jersey" {{$company->state=="New Jersey" ? 'selected':''}}>
                        New Jersey</option>
                                    <option value="New Mexico" {{$company->state=="New Mexico" ? 'selected':''}}>
                        New Mexico</option>
                                    <option value="New York" {{$company->state=="New York" ? 'selected':''}}>
                        New York</option>
                                    <option value="North Carolina" {{$company->state=="North Carolina" ? 'selected':''}}>
                        North Carolina</option>
                                    <option value="North Dakota" {{$company->state=="North Dakota" ? 'selected':''}}>
                        North Dakota</option>
                                    <option value="Ohio" {{$company->state=="Ohio" ? 'selected':''}}>
                        Ohio</option>
                                    <option value="Oklahoma" {{$company->state=="Oklahoma" ? 'selected':''}}>
                        Oklahoma</option>
                                    <option value="Oregon" {{$company->state=="Oregon" ? 'selected':''}}>
                        Oregon</option>
                                    <option value="Pennsylvania" {{$company->state=="Pennsylvania" ? 'selected':''}}>
                        Pennsylvania</option>
                                    <option value="Rhode Island" {{$company->state=="Rhode Island" ? 'selected':''}}>
                        Rhode Island</option>
                                    <option value="South Carolina" {{$company->state=="South Carolina" ? 'selected':''}}>
                        South Carolina</option>
                                    <option value="South Dakota" {{$company->state=="South Dakota" ? 'selected':''}}>
                        South Dakota</option>
                                    <option value="Tennessee" {{$company->state=="Tennessee" ? 'selected':''}}>
                        Tennessee</option>
                                    <option value="Texas" {{$company->state=="Texas" ? 'selected':''}}>
                        Texas</option>
                                    <option value="Utah" {{$company->state=="Utah" ? 'selected':''}}>
                        Utah</option>
                                    <option value="Vermont" {{$company->state=="Vermont" ? 'selected':''}}>
                        Vermont</option>
                                    <option value="Virginia" {{$company->state=="Virginia" ? 'selected':''}}>
                        Virginia</option>
                                    <option value="Washington" {{$company->state=="Washington" ? 'selected':''}}>
                        Washington</option>
                                    <option value="West Virginia" {{$company->state=="West Virginia" ? 'selected':''}}>
                        West Virginia</option>
                                    <option value="Wisconsin" {{$company->state=="Wisconsin" ? 'selected':''}}>
                        Wisconsin</option>
                                    <option value="Wyoming" {{$company->state=="Wyoming" ? 'selected':''}}>
                        Wyoming</option>
                            </select>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.ZIP')}}</label>
                        <input type="text" class="form-control login-input dis-input" id="exampleFormControlInput1" name="zip" placeholder="{{__('messages.ZIP')}}" value="{{$company->zip}}"/>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Contact Person Name')}}</label>
                        <input type="text" class="form-control login-input dis-input" id="exampleFormControlInput1" name="contact_person_name" placeholder="{{__('messages.Contact Person Name')}}" value="{{$company->contact_person_name}}"/>
                    </div>
                    @error('contact_person_name')
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Contact Person Email')}}</label>
                        <input type="text" class="form-control login-input dis-input" id="exampleFormControlInput1" name="contact_person_email" placeholder="{{__('messages.Contact Person Email')}}" value="{{$company->contact_person_email}}"/>
                    </div>
                    @error('contact_person_email')
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Contact Person Phone')}}</label>
                        <input type="text" class="form-control login-input dis-input" id="exampleFormControlInput1"  name="contact_person_phone" placeholder="{{__('messages.Contact Person Phone')}}" value="{{$company->contact_person_phone}}"/>
                    </div>
                    @error('contact_person_phone')
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
            </div>
            <div class="buttons">
                <a href="{{route('companies')}}" class="cancelBtn">{{__('messages.Cancel')}}</a>
                <button type="submit"  class="mainBtn">{{__('messages.Submit')}}</button>
            </div>
        </div>
</form>
    </div>
</div>


@endsection
