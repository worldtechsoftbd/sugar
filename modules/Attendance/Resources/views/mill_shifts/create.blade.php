@extends('backend.layouts.app')
@section('title', localize('Create Organization Shift'))

@section('content')
    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            <h6 class="fs-20 fw-bold mb-0">{{ localize('Create Organization Shift') }}</h6>
        </div>
        <div class="card-body">
            @include('backend.layouts.common.validation')
            @include('backend.layouts.common.message')
            <form action="{{ route('attendance.mill-shifts.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Select Organization -->
                    <div class="col-md-6 mb-3">
                        <label for="Organization" class="form-label">{{ localize('Select Organization') }}</label>
                        <select id="Organization"
                                class="form-control select2 @error('Organization') is-invalid @enderror" required>
                            <option value="">{{ localize('Select Organization') }}</option>
                            @foreach ($org as $organization)
                                <option value="{{ $organization->id }}" {{ old('Organization') == $organization->id ? 'selected' : '' }}>
                                    {{ $organization->org_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('Organization')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Select Department -->
                    <div class="col-md-6 mb-3">
                        <label for="OfficeId" class="form-label">{{ localize('Select Office') }}</label>
                        <select id="OfficeId" name="mill_id"
                                class="form-control select2 @error('OfficeId') is-invalid @enderror" required>
                            <option value="">{{ localize('Select Office') }}</option>
                        </select>
                        @error('OfficeId')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>

                <div class="row">
                    <!-- Select Shift -->
                    <div class="col-md-6 mb-3">
                        <label for="shift_id" class="form-label">{{ localize('Select Shift') }}</label>
                        <select id="shift_id" name="shift_id"
                                class="form-control select2 @error('shift_id') is-invalid @enderror" required>
                            <option value="">{{ localize('Select Shift') }}</option>
                            @foreach ($shifts as $shift)
                                <option value="{{ $shift->id }}" {{ old('shift_id') == $shift->id ? 'selected' : '' }}>
                                    {{ $shift->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('shift_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Max Per Shift -->
                    <div class="col-md-6 mb-3">
                        <label for="MaxPerShift" class="form-label">{{ localize('Max Per Shift') }}</label>
                        <input type="number" id="MaxPerShift" name="MaxPerShift"
                               class="form-control @error('MaxPerShift') is-invalid @enderror"
                               value="{{ old('MaxPerShift', 0) }}" min="0">
                        @error('MaxPerShift')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- On Hold Per Shift -->
                <div class="col-md-6 mb-3">
                    <label for="OnHoldPerShift" class="form-label">{{ localize('On Hold Per Shift') }}</label>
                    <input type="number" id="OnHoldPerShift" name="OnHoldPerShift"
                           class="form-control @error('OnHoldPerShift') is-invalid @enderror"
                           value="{{ old('OnHoldPerShift', 0) }}" min="0">
                    @error('OnHoldPerShift')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                <div class="row">
                    <!-- Is Applicable Config -->
                    <div class="col-md-4 mb-3">
                        <label for="IsApplicableConfig"
                               class="form-label">{{ localize('Is Applicable Config') }}</label>
                        <select id="IsApplicableConfig" name="IsApplicableConfig"
                                class="form-control select2 @error('IsApplicableConfig') is-invalid @enderror">
                            <option value="0" {{ old('IsApplicableConfig', 0) == 0 ? 'selected' : '' }}>{{ localize('No') }}</option>
                            <option value="1" {{ old('IsApplicableConfig', 0) == 1 ? 'selected' : '' }}>{{ localize('Yes') }}</option>
                        </select>
                        @error('IsApplicableConfig')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Overtime Allowed -->
                    <div class="col-md-4 mb-3">
                        <label for="OverTimeYN" class="form-label">{{ localize('Overtime Allowed') }}</label>
                        <select id="OverTimeYN" name="OverTimeYN"
                                class="form-control select2 @error('OverTimeYN') is-invalid @enderror">
                            <option value="0" {{ old('OverTimeYN', 0) == 0 ? 'selected' : '' }}>{{ localize('No') }}</option>
                            <option value="1" {{ old('OverTimeYN', 0) == 1 ? 'selected' : '' }}>{{ localize('Yes') }}</option>
                        </select>
                        @error('OverTimeYN')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Max Overtime -->
                    <div class="col-md-4 mb-3">
                        <label for="MaxOverTime" class="form-label">{{ localize('Max Overtime (hours)') }}</label>
                        <input type="number" id="MaxOverTime" name="MaxOverTime"
                               class="form-control @error('MaxOverTime') is-invalid @enderror"
                               value="{{ old('MaxOverTime', 0) }}" min="0" step="0.01">
                        @error('MaxOverTime')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>

                <div class="row">
                    <!-- Min Time -->
                    <div class="col-md-6 mb-3">
                        <label for="MinTime" class="form-label">{{ localize('Min Time (hours)') }}</label>
                        <input type="number" id="MinTime" name="MinTime"
                               class="form-control @error('MinTime') is-invalid @enderror"
                               value="{{ old('MinTime', 0) }}" min="0" step="0.01">
                        @error('MinTime')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">{{ localize('Status') }}</label>
                        <select id="status" name="status"
                                class="form-control select2 @error('status') is-invalid @enderror" required>
                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>{{ localize('Active') }}</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>{{ localize('Inactive') }}</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>

                <!-- Submit Button -->
                <div class="mb-3 text-end">
                    <button type="submit" class="btn btn-primary">{{ localize('Save') }}</button>
                    <a href="{{ route('attendance.mill-shifts.index') }}"
                       class="btn btn-secondary">{{ localize('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        .fs-20 {
            font-size: 20px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .form-control {
            border-radius: 0;
        }

        .btn {
            border-radius: 0;
        }
    </style>
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
        });
    </script>

@endpush

@push('js')
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "{{ localize('Select an option') }}",
                allowClear: true
            });

            $('#Organization').change(function () {
                var orgId = $(this).val();
                var departmentSelect = $('#OfficeId');

                departmentSelect.empty().append('<option value="">{{ localize('Select Department') }}</option>');

                if (orgId) {
                    $.ajax({
                        url: '/attendance/get-offices/org/' + orgId,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $.each(data, function (index, offices) {
                                departmentSelect.append('<option value="' + offices.id + '">' + offices.office_name + '</option>');
                            });
                            departmentSelect.select2({
                                placeholder: "{{ localize('Select an option') }}",
                                allowClear: true
                            });
                        },
                        error: function () {
                            alert("{{ localize('Error fetching Office') }}");
                        }
                    });
                } else {
                    departmentSelect.select2({
                        placeholder: "{{ localize('Select an option') }}",
                        allowClear: true
                    });
                }
            });
        });
    </script>
@endpush