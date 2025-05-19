@extends('backend.layouts.app')

@section('title', localize('Edit Employee Shift'))

@section('content')
    <div class="card">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')
        <div class="card-header">
            <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('Edit Employee Shift') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('employee-shifts.update', $employeeShift->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Select Organization -->
                <div class="mb-3">
                    <label class="form-label">{{ localize('Select Organization') }}</label>
                    <select id="organization_id" name="organization_id" class="form-control select2" required>
                        <option value="">{{ localize('Select Organization') }}</option>
                        @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}"
                                    {{ $employeeShift->organization_id == $organization->id ? 'selected' : '' }}>
                                {{ $organization->org_name }}
                            </option>
                        @endforeach
                    </select>
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
                        @foreach ($employees as $employee)
                            <tr>
                                <td>
                                    <input type="checkbox" class="employee-checkbox" name="employee_ids[]"
                                           value="{{ $employee->id }}"
                                            {{ in_array($employee->id, $selectedEmployees) ? 'checked' : '' }}>
                                </td>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                            </tr>
                        @endforeach
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
                            <option value="{{ $millShift->id }}"
                                    {{ $employeeShift->mill_shift_id == $millShift->id ? 'selected' : '' }}>
                                {{ $millShift->department->org_name }} Shift- {{ $millShift->shift->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Shift Date -->
                <div class="mb-3">
                    <label for="shift_date" class="form-label">{{ localize('Shift Date') }}</label>
                    <input type="date" id="shift_date" name="shift_date" class="form-control"
                           value="{{ $employeeShift->shift_date }}" required>
                </div>

                <!-- Submit Button -->
                <div class="mb-3 text-end">
                    <button type="submit" class="btn btn-primary">{{ localize('Update Shift') }}</button>
                    <a href="{{ route('employee-shifts.index') }}" class="btn btn-secondary">{{ localize('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "{{ localize('Select an option') }}",
                allowClear: true,
                width: '100%',
            });

            // Select All Employees
            $('#selectAll').on('click', function () {
                const isChecked = $(this).is(':checked');
                $('.employee-checkbox').prop('checked', isChecked);
            });
        });
    </script>
@endpush
