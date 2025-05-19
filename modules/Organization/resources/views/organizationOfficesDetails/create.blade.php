@extends('backend.layouts.app')

@section('content')
    <div class="container my-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="fas fa-building me-2"></i> {{ localize('Create Organization Office Detail') }}
                </h5>
                <a href="{{ route('organization_offices.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left"></i> {{ localize('Back to List') }}
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('organization_offices.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Organization Office Dropdown -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="org_offices_id" class="form-label">{{ localize('Organization Office') }}</label>
                            <select name="org_offices_id" id="org_offices_id" class="form-select" required>
                                <option value="">{{ localize('Select Organization') }}</option>
                                @foreach($orgOffices as $orgOffice)
                                    <option value="{{ $orgOffice->id }}">{{ $orgOffice->office_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{ localize('Please select an organization office.') }}
                            </div>
                        </div>

                        <!-- Office Name -->
                        <div class="col-md-6">
                            <label for="office_name" class="form-label">{{ localize('Office Name') }}</label>
                            <input type="text" name="office_name" id="office_name" class="form-control" required>
                            <div class="invalid-feedback">
                                {{ localize('Please provide the office name.') }}
                            </div>
                        </div>
                    </div>

                    <!-- Parent Office Checkbox and Dropdown -->
                    <div class="row mb-3">
                        <div class="col-md-6" id="parent_office_section" style="display: none;">
                            <label>
                                <input type="checkbox" id="is_parent" name="is_parent">
                                {{ localize('Is Parent Office') }}
                            </label>
                        </div>

                        <div class="col-md-6" id="parent_office_dropdown" style="display: none;">
                            <label for="parent_id" class="form-label">{{ localize('Parent Office') }}</label>
                            <select name="parent_id" id="parent_id" class="form-select">
                                <option value="">{{ localize('Select Parent Office') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label">{{ localize('Description') }}</label>
                            <input type="text" name="description" id="description" class="form-control">
                        </div>
                    </div>

                    <!-- Address and Phone Number -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="address" class="form-label">{{ localize('Address') }}</label>
                            <input type="text" name="address" id="address" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">{{ localize('Phone Number') }}</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">{{ localize('Email') }}</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <!-- Longitude and Latitude -->
                        <div class="col-md-6">
                            <label for="longitude" class="form-label">{{ localize('Longitude') }}</label>
                            <input type="number" name="longitude" id="longitude" step="0.000001" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="latitude" class="form-label">{{ localize('Latitude') }}</label>
                            <input type="number" name="latitude" id="latitude" step="0.000001" class="form-control">
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label for="status" class="form-label">{{ localize('Status') }}</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="1">{{ localize('Active') }}</option>
                                <option value="2">{{ localize('Inactive') }}</option>
                                <option value="276">{{ localize('Deleted') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Sort Order -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label">{{ localize('Sort Order') }}</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control">
                        </div>

                        <!-- Is Parent -->
                        <div class="col-md-6">
                            <label for="is_parent" class="form-label">{{ localize('Is Parent') }}</label>
                            <select name="is_parent" id="is_parent" class="form-select">
                                <option value="0">{{ localize('No') }}</option>
                                <option value="1">{{ localize('Yes') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Manager Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="manager_name" class="form-label">{{ localize('Manager Name') }}</label>
                            <input type="text" name="manager_name" id="manager_name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="manager_phone" class="form-label">{{ localize('Manager Phone') }}</label>
                            <input type="text" name="manager_phone" id="manager_phone" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="manager_email" class="form-label">{{ localize('Manager Email') }}</label>
                            <input type="email" name="manager_email" id="manager_email" class="form-control">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="notes" class="form-label">{{ localize('Notes') }}</label>
                            <textarea name="notes" id="notes" class="form-control"></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> {{ localize('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Dynamically fetch organization offices
            $('#org_offices_id').change(function() {
                var org_offices_id = $(this).val();
                if (org_offices_id) {
                    $.ajax({
                        url: "{{ route('organization_offices.get_offices_by_org') }}",
                        method: "GET",
                        data: { org_offices_id: org_offices_id },
                        success: function(response) {
                            var offices = response;
                            var parentOfficeDropdown = $('#parent_id');
                            parentOfficeDropdown.empty();
                            parentOfficeDropdown.append('<option value="">{{ localize('Select Parent Office') }}</option>');

                            // If parent office is checked, show dropdown
                            $('#parent_office_section').show();

                            if (offices.length > 0) {
                                offices.forEach(function(office) {
                                    parentOfficeDropdown.append('<option value="'+ office.id +'">'+ office.office_name +'</option>');
                                });
                                $('#parent_office_dropdown').show();
                            } else {
                                $('#parent_office_dropdown').hide();
                            }
                        }
                    });
                }
            });

            // Show/Hide the parent office list if the checkbox is checked
            $('#is_parent').change(function() {
                if ($(this).is(":checked")) {
                    $('#parent_office_dropdown').show();
                } else {
                    $('#parent_office_dropdown').hide();
                }
            });
        });
    </script>
@endpush
