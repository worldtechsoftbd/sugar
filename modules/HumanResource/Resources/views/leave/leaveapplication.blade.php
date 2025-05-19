@extends('backend.layouts.app')
@section('title', localize('leave_application_list'))
@push('css')
@endpush
@section('content')

    @include('humanresource::leave_header')


    <div class="card mb-4 fixed-tab-body">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('leave_application_list') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">
                        <button type="button" class="btn btn-success" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne"> <i
                                class="fas fa-filter"></i> {{ localize('filter') }}</button>

                        @can('create_leave_application')
                            <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#addLeaveApplication"><i
                                    class="fa fa-plus-circle"></i>&nbsp;{{ localize('add_leave_application') }}</a>
                            @include('humanresource::leave.livcreate')
                        @endcan
                    </div>
                </div>
            </div>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <div id="flush-collapseOne" class="accordion-collapse collapse bg-white mb-4"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">

                                <div class="row">
                                    <div class="col-md-2 mb-4">
                                        <select id="employee_name" class="select-basic-single">
                                            <option selected value="">{{ localize('all_employees') }}</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ ucwords($employee->full_name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-4 align-self-end">
                                        <button type="button" id="leave-application-filter"
                                            class="btn btn-success">{{ localize('find') }}</button>
                                        <button type="button" id="leave-application-search-reset"
                                            class="btn btn-danger">{{ localize('reset') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table_customize">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    <!--Edit Application Modal -->
    <div class="modal fade" id="edit-application" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ localize('edit_leave_application') }}
                    </h5>
                </div>
                <div id="editLeaveApplication">
                </div>
            </div>
        </div>
    </div>

    <!-- Application Approve Modal -->
    <div class="modal fade" id="approve-application" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ localize('application_approved') }}
                    </h5>
                </div>
                <div id="approveLeaveApplication">
                </div>
            </div>
        </div>
    </div>
@endsection
{{--@push('js')--}}
{{--    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}--}}
{{--    <script src="{{ module_asset('HumanResource/js/hrcommon.js') }}"></script>--}}
{{--@endpush--}}

@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('HumanResource/js/hrcommon.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#employee_name').select2({
                placeholder: "{{ localize('all_employees') }}",
                allowClear: true,
                minimumResultsForSearch: Infinity // This should disable search for fewer than 5 options
            });
        });

    </script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Event listener for leave type change
            $('#leave_type_id').change(function() {
                var employeeId = $('#employee_id').val();
                var leaveTypeId = $(this).val();

                // Check if employee and leave type are selected
                if (employeeId && leaveTypeId) {
                    // Send AJAX request to get leave balance
                    $.ajax({
                        url: "{{ route('leave_balance.get') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            employee_id: employeeId,
                            leave_type_id: leaveTypeId
                        },
                        success: function(response) {
                            if (response.success) {
                                // Populate the leave balance field with the fetched balance
                                $('#leave_balance').val(response.leave_balance);
                            } else {
                                // If no leave balance found, clear the field and show a message
                                $('#leave_balance').val('');
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert('Error fetching leave balance.');
                        }
                    });
                } else {
                    // Clear the leave balance field if no employee or leave type is selected
                    $('#leave_balance').val('');
                }
            });
        });
    </script>
@endpush


