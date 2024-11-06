@extends('layouts.main')
@section('content')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Edit Company</p>
              </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('companies.update',$company->id)}}">
                    @csrf
                    <p class="text-uppercase text-sm">Company Information</p>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Name</label>
                            <input class="form-control" type="text" name="name" placeholder="Name" value="{{$company->name}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">DOT</label>
                                <input class="form-control" type="text" name="dot" placeholder="DOT" value="{{$company->dot}}">
                            </div>
                            @error('dot')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">MC Number</label>
                                <input class="form-control" type="text" name="mc" placeholder="MC Number" value="{{$company->mc}}">
                            </div>
                            @error('mc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email address</label>
                                <input class="form-control" type="email" name="email" placeholder="Email" value="{{$company->email}}">
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Phone</label>
                                <input class="form-control" type="text" name="phone" placeholder="phone" value="{{$company->phone}}">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">State</label>
                                <select name="state" class="form-control" name="state">
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
                                @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">City</label>
                                <input class="form-control" type="text" name="city" placeholder="City" value="{{$company->city}}">
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">ZIP</label>
                                <input class="form-control" type="text" name="zip" placeholder="ZIP" value="{{$company->zip}}">
                                @error('zip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Contact Person Name</label>
                                <input class="form-control" type="text" name="contact_person_name" placeholder="Contact Person Name" value="{{$company->contact_person_name}}">
                                @error('contact_person_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Contact Person Email</label>
                                <input class="form-control" type="text" name="contact_person_email" placeholder="Contact Person Email" value="{{$company->contact_person_email}}">
                                @error('contact_person_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Contact Person Phone</label>
                                <input class="form-control" type="text" name="contact_person_phone" placeholder="Contact Person Phone" value="{{$company->contact_person_phone}}">
                                @error('contact_person_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        </div>
                       
                        
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" >Update</button>
                </form>
              
             
            </div>
          </div>
        </div>
        
      </div>
     
    </div>

@endsection