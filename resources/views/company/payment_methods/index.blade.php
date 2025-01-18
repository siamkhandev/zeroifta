@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
  @if(Session::has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #13975b;color:white">
    {{Session::get('success')}}
    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #dd4957;color:white">
    {{Session::get('error')}}
    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <div class="manage-comp mb-4">
    <div class="Filters-main mb-3 mb-md-4">
      <div class="sec1-style">
        <div class="tabele_filter">
          <div class="tabFilt_left">
            <!-- Show Filter -->
            <div class="sd-filter">

            </div>
            <!-- Sort By Filter -->
            <div class="sd2-filter">

            </div>
          </div>
          <div class="filter-btn">
            <a class="blueLine_btn" href="{{route('vehicles.create')}}">{{__('messages.Add Payment Method')}}+</a>
            
          </div>
        </div>
      </div>
    </div>

    <div class="sec1-style">
      <div class="data_table table-span table-responsive">
        <table id="example" class="table table-comm">
          <thead>
            <tr>
              <th scope="col">
                <span>
                  <input id="remember-me" name="remember-me" type="checkbox" />
                </span>
              </th>
              <th scope="col">{{__('messages.Name')}}</th>
              <th scope="col">{{__('messages.Brand')}}</th>
              <th scope="col">{{__('messages.Expiry Month')}}</th>
              <th scope="col">{{__('messages.Expiry Year')}}</th>
              <th scope="col">{{__('messages.Last4')}}</th>
              <th scope="col">{{__('messages.Is Default')}}</th>
              <th scope="col">{{__('messages.Action')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($filteredMethods as $method)
            <tr>
              

              <td>
                <div class="table-conTab">
                  
                  <span> {{$method['name']}}</span>
                </div>
              </td>
              <td>
                <div>
                  <p>{{$method['brand']}}</p>

                </div>
              </td>
              <td>{{$method['expiry_month']}}</td>
              <td>{{$method['expiry_year']}}</td>
              <td>{{$method['last4']}}</td>
              
              <td>
                @if($method['is_default'] == true)
                <span style="color: green;">{{__('messages.Yes')}}</span>
                @else
                <span style="color: red;">{{__('messages.No')}}</span>
                @endif
            </td>
              <td>
                <div class="tabAction-list">
                <a href="#" class="btn btn-primary">Make Default</a>
                 

                 
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- Pegination Area -->

    </div>
  </div>
</div>
@endsection
