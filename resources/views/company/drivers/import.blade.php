@extends('layouts.new_main')
@section('content')
<div class="dashbord-inner">
    <!-- Section 1 -->

    <div class="profileForm-area mb-4">
        <div class="sec1-style">

        <form method="post" action="{{route('drivers.import')}}" enctype="multipart/form-data">
            @csrf
            <div class="row pt-3">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.File (Excel)')}}</label>
                        <input type="file" class="form-control login-input" id="exampleFormControlInput1"  name="file" />
                    </div>
                    @error('file')
                        <span class="invalid-feedback" role="alert" style="display: block;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="buttons mt-5">
                <a href="{{ asset('drivers.xlsx') }}" download class="btn btn-warning" style="float: right;">{{__('messages.Download Sample File')}}</a>
                <button type="submit"  class="mainBtn">{{__('messages.Submit')}}</button>
            </div>
        </form>

        <!-- Display Success or Error Messages -->
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning mt-3">
                {{ session('warning') }}
            </div>
        @endif

        @if(session('errors'))
            <div class="alert alert-danger mt-3">
                <p><strong>{{__('messages.The following rows failed:')}}</strong></p>
                <ul>
                    @foreach(session('errors') as $error)
                        <li>
                            <strong>{{__('messages.Row Data:')}}</strong> {{ json_encode($error['row']) }}<br>
                            <strong>{{__('messages.Error:')}}</strong> {{ $error['error'] }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif

        </div>
    </div>
</div>
@endsection
