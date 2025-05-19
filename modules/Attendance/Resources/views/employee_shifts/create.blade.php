@extends('backend.layouts.app')
@section('title', localize('Assign Employee Shift'))

@section('content')
    <div class="card">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')
        <div class="card-header">
            <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('Assign Employee Shift') }}</h6>
        </div>
        <div class="card-body">
            <form id="assignShiftForm" action="{{ route('employee-shifts.store') }}" method="POST">
                @csrf
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
                    <label for="department_id" class="col-sm-3 col-form-label ps-0">
                        {{ localize('Department') }} <span class="text-danger">*</span>
                    </label>
                    <div class="col-lg-9">
                        <select name="department_id[]" id="department" class="form-select select2 required-field" multiple>
                            <option value="">{{ localize('Select Department') }}</option>
                        </select>
                    </div>
                </div>




                <div id="loader" style="display: none; text-align: center;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">{{ localize('Loading...') }}</span>
                    </div>
                </div>

                <!-- Employee Table -->
                <div class="mb-3">
                    <label class="form-label">{{ localize('Select Employee(s)') }}</label>
                    <table id="employeeTable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>{{ localize('Employee ID') }}</th>
                            <th>{{ localize('Name') }}</th>
                        </tr>
                        </thead>
                        <tbody id="employeeList">
                        <!-- Data will be dynamically loaded here -->
                        </tbody>
                    </table>
                    <small class="form-text text-muted">{{ localize('You can select one, multiple, or all employees.') }}</small>
                </div>

                <!-- Select Mill Shift -->
                <div class="mb-3">
                    <label for="mill_shift_id" class="form-label">{{ localize('Select Mill Shift') }}</label>
                    <select id="mill_shift_id" name="mill_shift_id" class="form-control select2" required>
                        <option value="">{{ localize('Select Mill Shift') }}</option>
                        @foreach ($millShifts as $millShift)
                            <option value="{{ $millShift->id }}">{{ $millShift->OrganizationOffices->office_name  }} Shift- {{ $millShift->shift->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Shift Date -->
                <div class="mb-3">
                    <label for="shift_date" class="form-label">{{ localize('Shift Date') }}</label>
                    <input type="date" id="shift_date" name="shift_date" class="form-control" required>
                </div>

                <!-- Submit Button -->
                <div class="mb-3 text-end">
                    <button type="submit" class="btn btn-primary">{{ localize('Assign Shift') }}</button>
                    <a href="{{ route('employee-shifts.index') }}" class="btn btn-secondary">{{ localize('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection




@push('css')
    <style>
        #loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    </style>


    <!-- Include DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
           $('#offices').on('change', function () {

               let officeIds = $(this).val();
               $('#department').html('<option value="">{{ localize("Loading Departments") }}</option>').trigger('change');
               if (officeIds.length > 0) {
                   $('#loader').show();
                   $.ajax({
                       url: '{{ route("get-employee-departments") }}',
                       type: 'GET',
                       data: { office_ids: officeIds },
                       beforeSend: function () {
                           $('#loader').show();
                       },
                       success: function (data) {
                           $('#loader').hide();
                           let options = '';
                           data.forEach(department => {
                               options += `<option value="${department.id}">${department.department_name}</option>`;
                           });
                           $('#department').html(options).trigger('change'); // Update and reinitialize Select2
                       },
                       error: function () {
                           $('#loader').hide();

                           alert('{{ localize("Error loading departments") }}');
                       }
                   });
               } else {
                   $('#department').html('<option value="">{{ localize("Select Department") }}</option>').trigger('change');
               }
           });
       });

   </script>

    <script>
        $(document).ready(function () {
            let employeeTable = $('#employeeTable').DataTable({
                searching: false,
                paging: false,
                info: false,
                ordering: false,
                columns: [
                    { orderable: false },
                    { title: "{{ localize('Employee ID') }}" },
                    { title: "{{ localize('Name') }}" }
                ]
            });
            $('.select2').select2({
                placeholder: "{{ localize('Select an option') }}",
                allowClear: true,
                width: '100%',
            });
            $('#selectAll').on('click', function () {
                const isChecked = $(this).is(':checked');
                $('.employee-checkbox').prop('checked', isChecked);
            });

            $('#department').on('change', function () {
                let department_id = $(this).val();
                employeeTable.clear().draw();

                if (department_id) {
                    $('#loader').show();
                    $.ajax({
                        url: "{{ route('getEmployeesByOrganization') }}",
                        type: "GET",
                        data: { department_id: department_id },
                        beforeSend: function () {
                            $('#loader').show();
                        },
                        success: function (data) {

                            $('#loader').hide();

                            data.forEach(employee => {
                                employeeTable.row.add([
                                    `<input type="checkbox" class="employee-checkbox" value="${employee.id}">`,
                                    employee.id,
                                    `${employee.first_name} ${employee.last_name}`
                                ]).draw();
                            });
                        },
                        error: function (xhr) {
                            $('#loader').hide(); // Hide loader on error
                            console.error(xhr.responseText);
                            {{--alert("{{ localize('Failed to fetch employees for the selected organization.') }}");--}}
                        },
                        complete: function () {
                            $('#loader').hide(); // Hide loader after request completion
                        }
                    });
                }
            });

            // Submit Form with Selected Employees
            $('#assignShiftForm').on('submit', function (e) {
                e.preventDefault();

                let selectedEmployees = [];
                $('.employee-checkbox:checked').each(function () {
                    selectedEmployees.push($(this).val());
                });

                if (selectedEmployees.length === 0) {
                    alert("{{ localize('Please select at least one employee.') }}");
                    return;
                }

                $('<input>').attr({
                    type: 'hidden',
                    name: 'employee_ids[]',
                    value: selectedEmployees.join(','),
                }).appendTo('#assignShiftForm');

                this.submit();
            });
        });
    </script>
@endpush
