@extends('backend.layouts.app')
@section('title', localize('attendance_report'))
@push('css')
    <link href="{{ module_asset('HumanResource/css/report.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('humanresource::reports_header')
    @include('backend.layouts.common.validation')

    <div class="card mb-4 fixed-tab-body">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('daily_attendance_report') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne"> <i
                                class="fas fa-filter"></i> {{ localize('filter') }}</button>
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

{{--                                    start--}}
                                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                                        <label for="organization_id" class="col-sm-3 col-form-label ps-0">
                                            {{ localize('organization') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9">
                                            <select name="organization_id" id="organization" class="form-select select2 required-field">
                                                <option value="">{{ localize('select_organization') }}</option>
                                                @foreach ($organizations as $organization)
                                                    <option value="{{ $organization->id }}">
                                                        {{ $organization->org_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                                        <label for="Offices" class="col-sm-3 col-form-label ps-0">
                                            {{ localize('Offices') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9">
                                            <select name="Offices_id[]" id="offices" class="form-select select2 required-field" multiple>
                                                <option value="">{{ localize('Select Offices') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                                        <label for="Shifts" class="col-sm-3 col-form-label ps-0">
                                            {{ localize('Shifts') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9">
                                            <select name="Shifts[]" id="Shifts" class="form-select select2 required-field" multiple>
                                                <option value="">{{ localize('Select Shifts') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="cust_border form-group mb-3 mx-0 pb-3 row">
                                        <label for="department_id" class="col-sm-3 col-form-label ps-0">
                                            {{ localize('Department') }} <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-9">
                                            <select name="department_id[]" id="department" class="form-select select2 required-field" multiple>
                                                <option value="">{{ localize('Select Department') }}</option>
                                            </select>
                                        </div>
                                    </div>
{{--                                    end--}}
{{--                                    <div class="col-md-2 mb-4">--}}
{{--                                        <select name="department_id" id="department_id"--}}
{{--                                            class="select-basic-single {{ $errors->first('department_id') ? 'is-invalid' : '' }}">--}}
{{--                                            <option value="0" selected>{{ localize('all_departments') }}--}}
{{--                                            </option>--}}
{{--                                            @foreach ($departments as $key => $department)--}}
{{--                                                <option value="{{ $department->id }}">--}}
{{--                                                    {{ $department->department_name }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                    <div class="col-md-2 mb-4">
                                        <select name="position_id" id="position_id"
                                            class="form-control select-basic-single {{ $errors->first('position_id') ? 'is-invalid' : '' }}">
                                            <option value="0" selected>{{ localize('all_positions') }}
                                            </option>
                                            @foreach ($positions as $key => $position)
                                                <option value="{{ $position->id }}">
                                                    {{ $position->position_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <input type="text" class="form-control date_picker" name="date"
                                            placeholder="{{ localize('date') }}" id="date"
                                            value="{{ current_date() }}">
                                    </div>

                                    <div class="col-md-2 mb-4">
                                        <button type="button" id="attendances-filter"
                                            class="btn btn-success">{{ localize('find') }}</button>
                                        <button type="button" id="attendances-search-reset"
                                            class="btn btn-danger">{{ localize('reset') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="table_customize">
                {{ $dataTable->table([], true) }}
            </div>

        </div>
    </div>

@endsection
@push('js')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="{{ module_asset('HumanResource/js/report-filter.js') }}"></script>
@endpush

@push('js')
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: '{{ localize("Select") }}',
                allowClear: true
            });

            $('#organization').on('change', function () {
                let orgId = $(this).val();
                $('#offices').html('<option value="">{{ localize("Loading Offices") }}</option>').trigger('change');
                if (orgId) {
                    $('#loader').show();
                    $.ajax({
                        url: '{{ route("get-employee-offices") }}',
                        type: 'GET',
                        data: { organization_id: orgId },
                        beforeSend: function () {
                            $('#loader').show();
                        },
                        success: function (data) {
                            $('#loader').hide();
                            let options = '';
                            data.forEach(offices => {
                                options += `<option value="${offices.id}">${offices.office_name}</option>`;
                            });
                            $('#offices').html(options).trigger('change'); // Update and reinitialize Select2
                        },
                        error: function () {
                            $('#loader').hide();

                            alert('{{ localize("Error loading offices") }}');
                        }
                    });
                } else {
                    $('#offices').html('<option value="">{{ localize("Select Offices") }}</option>').trigger('change');
                }
            });

            // Handle offices to departments
            // Handle offices to departments and shifts
            $('#offices').on('change', function () {
                let officeIds = $(this).val(); // Get selected office IDs
                const loader = $('#loader');

                // Clear and reset dropdowns
                $('#Shifts').html('<option value="">{{ localize("Loading Shifts") }}</option>').trigger('change');
                $('#department').html('<option value="">{{ localize("Loading Departments") }}</option>').trigger('change');

                if (officeIds.length > 0) {
                    loader.show(); // Show loader before both requests

                    // Fetch shifts
                    $.ajax({
                        url: '{{ route("get-office-Shifts") }}',
                        type: 'GET',
                        data: { office_ids: officeIds }, // Use "office_ids" to match the backend
                        success: function (data) {
                            loader.hide(); // Hide loader after the request
                            let options = '<option value="">{{ localize("Select Shifts") }}</option>';
                            data.forEach(shift => {
                                options += `<option value="${shift.shift_id}">${shift.name}</option>`;
                            });
                            $('#Shifts').html(options).trigger('change'); // Update shifts dropdown
                        },
                        error: function () {
                            loader.hide();
                            alert('{{ localize("Error loading Shifts") }}');
                        }
                    });

                    // Fetch departments
                    $.ajax({
                        url: '{{ route("get-employee-departments") }}',
                        type: 'GET',
                        data: { office_ids: officeIds }, // Use "office_ids" to match the backend
                        success: function (data) {
                            loader.hide(); // Hide loader after the request
                            let options = '<option value="">{{ localize("Select Department") }}</option>';
                            data.forEach(department => {
                                options += `<option value="${department.id}">${department.department_name}</option>`;
                            });
                            $('#department').html(options).trigger('change'); // Update departments dropdown
                        },
                        error: function () {
                            loader.hide();
                            alert('{{ localize("Error loading departments") }}');
                        }
                    });
                } else {
                    // Reset dropdowns if no office is selected
                    $('#Shifts').html('<option value="">{{ localize("Select Shifts") }}</option>').trigger('change');
                    $('#department').html('<option value="">{{ localize("Select Department") }}</option>').trigger('change');
                }
            });

        });

    </script>

@endpush
