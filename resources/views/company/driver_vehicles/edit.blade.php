@extends('layouts.new_main')
@section('content')

<div class="dashbord-inner">
    <!-- Section 1 -->
    <div class="profileForm-area mb-4">
        <div class="sec1-style">
        <form id="editVehicleForm" method="post" action="{{ route('driver_vehicles.update', $vehicle->id) }}" enctype="multipart/form-data">
    @csrf
    <div class="row pt-3">
        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
            <div class="dash-input mb-3">
                <label class="input-lables pb-2" for="driver_id">{{ __('messages.Driver') }}</label>
                <select id="driver_id" name="driver_id" class="form-control login-input">
                    <option value="">Select</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->driver->id }}"
                            {{ $vehicle->driver_id == $driver->driver->id ? 'selected' : '' }}>
                            {{ $driver->driver->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
            <div class="dash-input mb-3">
                <label class="input-lables pb-2" for="vehicle_id">{{ __('messages.Vehicle') }}</label>
                <select id="vehicle_id" name="vehicle_id" class="form-control login-input">
                    <option value="">Select</option>
                    @foreach($vehicles as $vehicle1)
                        <option value="{{ $vehicle1->id }}"
                            {{ $vehicle->vehicle_id == $vehicle1->id ? 'selected' : '' }}>
                            {{ $vehicle1->license_plate_number }} - {{ $vehicle1->make }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="buttons mt-5">
        <a href="{{ route('driver_vehicles') }}" class="cancelBtn">{{__('messages.Cancel')}}</a>
        <button type="button" id="submitEditForm" class="mainBtn">{{__('messages.Submit')}}</button>
    </div>
</form>
    </div>
</div>
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="justify-content: left !important;">
                <h5 class="modal-title">{{__('messages.Reassign Vehicle')}}</h5>

            </div>
            <div class="modal-body">
                <p id="modalMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('messages.Cancel')}}</button>
                <button type="button" id="confirmButton" class="btn btn-primary">{{__('messages.Reassign')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function () {
    let originalDriver = $('#driver_id').val();
    let originalVehicle = $('#vehicle_id').val();

    $('#submitEditForm').click(function (e) {
        e.preventDefault();
        let newDriver = $('#driver_id').val();
        let newVehicle = $('#vehicle_id').val();
        if (newVehicle !== originalVehicle) {
            // Check if the selected vehicle is already assigned
            checkVehicleAssignment(newVehicle);
        // Check if the driver or vehicle has changed
        }else if (newDriver !== originalDriver) {
            // Check if the selected driver already has a vehicle
            checkDriverAssignment(newDriver);
        }else if (newVehicle == originalVehicle){
            checkVehicleAlreadyAssigned(newVehicle);
        } else {
            // No changes, submit the form
            $('#editVehicleForm').submit();
        }
    });

    function checkDriverAssignment(driverId) {
        $.ajax({
            url: '{{ route("driver_vehicles.check_driver_assignment") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                driver_id: driverId
            },
            success: function (response) {
                if (response.assigned) {
                    showModal(response.message, function () {
                        $('#editVehicleForm').submit(); // Proceed with form submission
                    });
                } else {
                    $('#editVehicleForm').submit();
                }
            }
        });
    }
    function checkVehicleAlreadyAssigned(vehicleId) {
        $.ajax({
            url: '{{ route("driver_vehicles.check_vehicle_already_assignment") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                vehicle_id: vehicleId
            },
            success: function (response) {
                if (response.assigned) {
                    showModal(response.message, function () {
                        $('#editVehicleForm').submit(); // Proceed with form submission
                    });
                } else {
                    $('#editVehicleForm').submit();
                }
            }
        });
    }
    function checkVehicleAssignment(vehicleId) {
        $.ajax({
            url: '{{ route("driver_vehicles.check_vehicle_assignment") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                vehicle_id: vehicleId
            },
            success: function (response) {
                if (response.assigned) {
                    showModal(response.message, function () {
                        $('#editVehicleForm').submit(); // Proceed with form submission
                    });
                } else {
                    $('#editVehicleForm').submit();
                }
            }
        });
    }

    function showModal(message, onConfirm) {
        $('#modalMessage').text(message);
        $('#confirmationModal').modal('show');

        $('#confirmButton').off('click').on('click', function () {
            $('#confirmationModal').modal('hide');
            onConfirm();
        });
    }
});
</script>
@endsection
