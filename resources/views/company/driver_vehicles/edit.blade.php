@extends('layouts.new_main')
@section('content')

<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        <div class="sec1-style">
        <form method="post" action="{{route('driver_vehicles.update',$vehicle->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="row pt-3">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Driver')}}</label>
                        <select name="driver_id" class="form-control login-input" >
                              <option value="">Select</option>
                              @foreach($drivers as $driver)
                              <option value="{{$driver->driver->id}}" {{$vehicle->driver_id ==$driver->driver->id ? 'selected':'' }}>{{$driver->driver->name}}</option>
                              @endforeach
                            </select>
                    </div>
                    @error('driver_id')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="dash-input mb-3">
                        <label class="input-lables pb-2" for="exampleFormControlInput1" class="pb-1">{{__('messages.Vehicle')}}</label>
                        <select name="vehicle_id" class="form-control login-input" >
                        <option value="">Select</option>
                        @foreach($vehicles as $vehicle1)
                        <option value="{{$vehicle1->id}}" {{$vehicle->vehicle_id ==$vehicle1->id ? 'selected':'' }}>{{$vehicle1->license_plate_number}} - {{$vehicle1->make}}</option>
                        @endforeach
                      </select>
                    </div>
                    @error('vehicle_id')
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

            </div>
            <div class="buttons mt-5">
                <a href="{{route('driver_vehicles')}}" class="cancelBtn">Cancel</a>
                <button type="submit"  class="mainBtn">Submit</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="reassignModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="reassignForm" action="{{ route('driver_vehicles.reassign') }}" method="post">
            @csrf
            <input type="hidden" name="driver_vehicle_id" id="driver_vehicle_id" value="{{ $vehicle->id }}">
            <input type="hidden" name="new_driver_id" id="new_driver_id">
            <input type="hidden" name="vehicle_id" id="vehicle_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reassign Vehicle</h5>
                    
                </div>
                <div class="modal-body">
                    <p id="modalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Reassign</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
    $('select[name="vehicle_id"]').on('change', function () {
        const vehicleId = $(this).val();
        const driverId = $('select[name="driver_id"]').val();

        if (vehicleId) {
            $.ajax({
                url: '{{ route("driver_vehicles.check_assignment") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    vehicle_id: vehicleId,
                    driver_id: driverId,
                },
                success: function (response) {
                    if (response.assigned && response.current_driver) {
                        // Populate the modal
                        $('#modalMessage').text(`This vehicle is already assigned to driver ${response.current_driver}. Do you want to reassign it?`);
                        $('#new_driver_id').val(driverId);
                        $('#vehicle_id').val(vehicleId);
                        $('#reassignModal').modal('show');
                    }
                },
            });
        }
    });
});
</script>
@endsection
