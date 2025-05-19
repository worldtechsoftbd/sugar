@extends('backend.layouts.app')
@section('title', localize('Edit Organization Shift'))

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('Edit Organization Shift') }}</h6>
        </div>
        <div class="card-body">
            @include('backend.layouts.common.validation')
            @include('backend.layouts.common.message')
            <form action="{{ route('attendance.mill-shifts.update', $millShift->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Select Organization -->
                <div class="mb-3">
                    <label for="Organization" class="form-label">{{ localize('Select Organization') }}</label>
                    <select id="Organization1" name="mill_id" class="form-control select2 @error('Organization') is-invalid @enderror" required>
                        <option value="">{{ localize('Select Organization') }}</option>
                        @foreach ($org as $organization)
                            <option value="{{ $organization->id }}" {{ old('Organization', $millShift->mill_id) == $organization->id ? 'selected' : '' }}>
                                {{ $organization->org_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('Organization')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

{{--                <div class="mb-3">--}}
{{--                    <label for="DepartmentId" class="form-label">{{ localize('Select Department') }}</label>--}}
{{--                    <select id="DepartmentId" name="DepartmentId" class="form-control select2 @error('DepartmentId') is-invalid @enderror" required>--}}
{{--                        <option value="">{{ localize('Select Department') }}</option>--}}
{{--                        <!-- Departments will be populated here via JavaScript -->--}}
{{--                    </select>--}}
{{--                    @error('DepartmentId')--}}
{{--                    <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                    @enderror--}}
{{--                </div>--}}

                <!-- Select Shift -->
                <div class="mb-3">
                    <label for="shift_id" class="form-label">{{ localize('Select Shift') }}</label>
                    <select id="shift_id" name="shift_id" class="form-control select2 @error('shift_id') is-invalid @enderror" required>
                        <option value="">{{ localize('Select Shift') }}</option>
                        @foreach ($shifts as $shift)
                            <option value="{{ $shift->id }}" {{ old('shift_id', $millShift->shift_id) == $shift->id ? 'selected' : '' }}>
                                {{ $shift->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('shift_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Max Per Shift -->
                <div class="mb-3">
                    <label for="MaxPerShift" class="form-label">{{ localize('Max Per Shift') }}</label>
                    <input type="number" id="MaxPerShift" name="MaxPerShift" class="form-control @error('MaxPerShift') is-invalid @enderror" value="{{ old('MaxPerShift', $millShift->max_per_shift) }}" min="0">
                    @error('MaxPerShift')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- On Hold Per Shift -->
                <div class="mb-3">
                    <label for="OnHoldPerShift" class="form-label">{{ localize('On Hold Per Shift') }}</label>
                    <input type="number" id="OnHoldPerShift" name="OnHoldPerShift" class="form-control @error('OnHoldPerShift') is-invalid @enderror" value="{{ old('OnHoldPerShift', $millShift->on_hold_per_shift) }}" min="0">
                    @error('OnHoldPerShift')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Is Applicable Config -->
                <div class="mb-3">
                    <label for="IsApplicableConfig" class="form-label">{{ localize('Is Applicable Config') }}</label>
                    <select id="IsApplicableConfig" name="IsApplicableConfig" class="form-control select2 @error('IsApplicableConfig') is-invalid @enderror">
                        <option value="0" {{ old('IsApplicableConfig', $millShift->is_applicable_config) == 0 ? 'selected' : '' }}>{{ localize('No') }}</option>
                        <option value="1" {{ old('IsApplicableConfig', $millShift->is_applicable_config) == 1 ? 'selected' : '' }}>{{ localize('Yes') }}</option>
                    </select>
                    @error('IsApplicableConfig')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Overtime Allowed -->
                <div class="mb-3">
                    <label for="OverTimeYN" class="form-label">{{ localize('Overtime Allowed') }}</label>
                    <select id="OverTimeYN" name="OverTimeYN" class="form-control select2 @error('OverTimeYN') is-invalid @enderror">
                        <option value="0" {{ old('OverTimeYN', $millShift->overtime_allowed) == 0 ? 'selected' : '' }}>{{ localize('No') }}</option>
                        <option value="1" {{ old('OverTimeYN', $millShift->overtime_allowed) == 1 ? 'selected' : '' }}>{{ localize('Yes') }}</option>
                    </select>
                    @error('OverTimeYN')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Max Overtime -->
                <div class="mb-3">
                    <label for="MaxOverTime" class="form-label">{{ localize('Max Overtime (hours)') }}</label>
                    <input type="number" id="MaxOverTime" name="MaxOverTime" class="form-control @error('MaxOverTime') is-invalid @enderror" value="{{ old('MaxOverTime', $millShift->max_overtime) }}" min="0" step="0.01">
                    @error('MaxOverTime')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Min Time -->
                <div class="mb-3">
                    <label for="MinTime" class="form-label">{{ localize('Min Time (hours)') }}</label>
                    <input type="number" id="MinTime" name="MinTime" class="form-control @error('MinTime') is-invalid @enderror" value="{{ old('MinTime', $millShift->min_time) }}" min="0" step="0.01">
                    @error('MinTime')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">{{ localize('Status') }}</label>
                    <select id="status" name="status" class="form-control select2 @error('status') is-invalid @enderror" required>
                        <option value="1" {{ old('status', $millShift->status) == 1 ? 'selected' : '' }}>{{ localize('Active') }}</option>
                        <option value="0" {{ old('status', $millShift->status) == 0 ? 'selected' : '' }}>{{ localize('Inactive') }}</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mb-3 text-end">
                    <button type="submit" class="btn btn-primary">{{ localize('Save') }}</button>
                    <a href="{{ route('attendance.mill-shifts.index') }}" class="btn btn-secondary">{{ localize('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
@endpush

@push('js')
    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "{{ localize('Select an option') }}",
                allowClear: true
            });

            // Event listener for Organization selection change
            $('#Organization').change(function () {
                var orgId = $(this).val();
                if (orgId) {
                    // Make AJAX call to get departments based on selected organization
                    $.ajax({
                        url: '/attendance/get-departments/' + orgId,
                        method: 'GET',
                        success: function (data) {
                            var departmentSelect = $('#DepartmentId');
                            departmentSelect.empty();
                            departmentSelect.append('<option value="">{{ localize('Select Department') }}</option>');
                            data.forEach(function (department) {
                                departmentSelect.append(
                                    '<option value="' + department.id + '" ' +
                                    (department.id == '{{ old('DepartmentId', $millShift->DepartmentId) }}' ? 'selected' : '') +
                                    '>' + department.department_name + '</option>'
                                );
                            });
                            departmentSelect.trigger('change');
                        }
                    });
                }
            }).trigger('change');
        });
    </script>
@endpush
