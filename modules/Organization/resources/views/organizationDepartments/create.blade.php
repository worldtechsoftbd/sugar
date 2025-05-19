@extends('backend.layouts.app')

@section('title', isset($organizationDepartment) ? localize('Edit Office') : localize('Add Office'))

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3>{{ isset($organizationDepartment) ? 'Edit Organization Wings' : 'Create Organization Wings' }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($organizationDepartment) ? route('organization-departments.update', $organizationDepartment->id) : route('organization-departments.store') }}"
                      method="POST">
                    @csrf
                    @if(isset($organizationDepartment))
                        @method('PUT')
                    @endif

                    <!-- Organization Dropdown -->
                    <div class="col-md-6">
                        <label for="org_id" class="form-label">{{ localize('Organization') }} <span class="text-danger">*</span></label>
                        <select name="org_id" id="org_id" class="form-select" required>
                            <option value="">{{ localize('Select Organization') }}</option>
                            @foreach($Organizations as $organization)
                                <option value="{{ $organization->id }}" {{ old('org_id', $organizationDepartment->org_id ?? '') == $organization->id ? 'selected' : '' }}>
                                    {{ $organization->org_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            {{ localize('Please select an organization.') }}
                        </div>
                    </div>

                    <!-- Office Type Dropdown -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="org_offices_id" class="form-label">Office Type</label>
                            <select name="org_offices_id" id="org_offices_id" class="form-select select2" required>
                                <option value="">{{ __('Select an option') }}</option>
                            </select>
                        </div>

                        <!-- Status Dropdown -->
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select select2" required>
                                <option value="1" {{ old('status', $organizationDepartment->status ?? '') == 1 ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="2" {{ old('status', $organizationDepartment->status ?? '') == 2 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                                <option value="276" {{ old('status', $organizationDepartment->status ?? '') == 276 ? 'selected' : '' }}>
                                    Deleted
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Is Parent Checkbox -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_parent" name="is_parent"
                                       value="1" {{ old('is_parent', $organizationDepartment->parent_id ?? '') == null ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_parent">Is Parent</label>
                            </div>
                        </div>
                    </div>

                    <!-- Parent Menu Dropdown -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="parent_id" class="form-label">Parent Menu</label>
                            <select name="parent_id" id="parent_id"
                                    class="form-select select2" {{ old('is_parent', $organizationDepartment->parent_id ?? '') == null ? 'disabled' : '' }}>
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach($parents as $index => $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $organizationDepartment->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                        {{ $departmentHierarchies[$index] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control"
                                   value="{{ old('sort_order', $organizationDepartment->sort_order ?? 0) }}">
                        </div>
                    </div>

                    <!-- Department Name Input -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="department_name" class="form-label">Office Name</label>
                            <input type="text" name="department_name" id="department_name" class="form-control"
                                   value="{{ old('department_name', $organizationDepartment->department_name ?? '') }}"
                                   required>
                        </div>
                    </div>

                    <!-- Description Textarea -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control"
                                      rows="3">{{ old('description', $organizationDepartment->description ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Address, Phone, Email Fields (Side by Side) -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control"
                                   value="{{ old('address', $organizationDepartment->address ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control"
                                   value="{{ old('phone_number', $organizationDepartment->phone_number ?? '') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email', $organizationDepartment->email ?? '') }}">
                        </div>
                    </div>

                    <!-- Longitude, Latitude Fields (Side by Side) -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="number" name="longitude" id="longitude" step="0.000001" class="form-control"
                                   value="{{ old('longitude', $organizationDepartment->longitude ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="number" name="latitude" id="latitude" step="0.000001" class="form-control"
                                   value="{{ old('latitude', $organizationDepartment->latitude ?? '') }}">
                        </div>
                    </div>

                    <!-- Is Active Radio Buttons -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="is_active" class="form-label">Is Active</label><br>
                            <input type="radio" name="is_active"
                                   value="1" {{ old('is_active', $organizationDepartment->is_active ?? '') == 1 ? 'checked' : '' }}>
                            Active
                            <input type="radio" name="is_active"
                                   value="0" {{ old('is_active', $organizationDepartment->is_active ?? '') == 0 ? 'checked' : '' }}>
                            Inactive
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> {{ isset($organizationDepartment) ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const orgOfficeDropdown = document.getElementById('org_offices_id');
            const parentMenuDropdown = document.getElementById('parent_id');
            const isParentCheckbox = document.getElementById('is_parent');

            // Function to load department hierarchies
            function loadDepartmentHierarchy(orgOfficeId) {
                fetch(`/load-office-details-hierarchy?org_office_id=${orgOfficeId}`)
                    .then(response => response.json())
                    .then(data => {
                        parentMenuDropdown.innerHTML = '<option value="">{{ __("Select an option") }}</option>';
                        data.forEach(department => {
                            const option = document.createElement('option');
                            option.value = department.id;
                            option.textContent = department.hierarchy;
                            parentMenuDropdown.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error loading department hierarchy:', error));
            }

            // Toggle parent menu based on Is Parent checkbox
            function toggleParentMenu() {
                const isChecked = isParentCheckbox.checked;
                parentMenuDropdown.disabled = isChecked;

                if (isChecked) {
                    parentMenuDropdown.innerHTML = '<option value="">{{ __("Select an option") }}</option>';
                } else if (orgOfficeDropdown.value) {
                    loadDepartmentHierarchy(orgOfficeDropdown.value);
                }
            }

            // Event listeners
            isParentCheckbox.addEventListener('change', toggleParentMenu);

            orgOfficeDropdown.addEventListener('change', function () {
                if (!isParentCheckbox.checked) {
                    loadDepartmentHierarchy(this.value);
                }
            });

            // Initial call to set the state
            toggleParentMenu();




            const orgDropdown = document.getElementById('org_id');
            const officeDropdown = document.getElementById('org_offices_id');

            // Select2 Initialization
            $('.select2').select2({
                placeholder: 'Select an option',
                allowClear: true,
            });

            if (orgDropdown) {
                orgDropdown.addEventListener('change', function () {
                    const orgId = this.value;

                    // Clear the existing options in office dropdown
                    officeDropdown.innerHTML = `<option value="">{{ __("Select an option") }}</option>`;

                    if (orgId) {
                        // Fetch organization offices based on selected organization
                        fetch(`/organizationOfficeTypes/${orgId}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! Status: ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                data.forEach(office => {
                                    const option = document.createElement('option');
                                    option.value = office.id;
                                    option.textContent = '-- '.repeat(office.level) + office.office_name;
                                    officeDropdown.appendChild(option);
                                });
                            })
                            .catch(error => console.error('Error fetching office types:', error));
                    }
                });
            }
        });
    </script>
@endsection
