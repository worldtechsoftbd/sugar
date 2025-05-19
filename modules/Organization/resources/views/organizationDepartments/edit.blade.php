{{--
@extends('backend.layouts.app')

@section('title', isset($organizationDepartment) ? localize('Edit Department') : localize('Add Department'))

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3>{{ isset($organizationDepartment) ? 'Edit Department' : 'Create Department' }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($organizationDepartment) ? route('organization-departments.update', $organizationDepartment->id) : route('organization-departments.store') }}"
                      method="POST">
                    @csrf
                    @if(isset($organizationDepartment))
                        @method('PUT')
                    @endif

                    <div class="row mb-3">
                        <!-- Is Parent Checkbox -->
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_parent" name="is_parent"
                                       value="1"
                                        {{ old('is_parent', $organizationDepartment->parent_id ?? '') == null ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_parent">Is Parent</label>
                            </div>
                        </div>

                        <!-- Parent Menu Dropdown -->
                        <div class="col-md-6">
                            <label for="parent_id" class="form-label">Parent Menu</label>
                            --}}
{{--<select name="parent_id" id="parent_id" class="form-select select2"
                                    {{ old('is_parent', $organizationDepartment->parent_id ?? '') == null ? 'disabled' : '' }}>
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach($parents as $index => $parent)
                                    <option value="{{ $parent->id }}"
                                            {{ old('parent_id', $organizationDepartment->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                        {{ $departmentHierarchies[$index] }}
                                    </option>
                                @endforeach
                            </select>--}}{{--

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
                    </div>

                    <div class="row mb-3">
                        <!-- Department Name -->
                        <div class="col-md-6">
                            <label for="department_name" class="form-label">Department Name</label>
                            <input type="text" name="department_name" id="department_name" class="form-control"
                                   value="{{ old('department_name', $organizationDepartment->department_name ?? '') }}"
                                   required>
                        </div>

                        <!-- Organization Name -->
                        <div class="col-md-6">
                            <label for="org_offices_id" class="form-label">Organization Office</label>
                            <select name="org_offices_id" id="org_offices_id" class="form-select select2" required>
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach($OrganizationOffices as $OrganizationOffice)
                                    <option value="{{ $OrganizationOffice->id }}"
                                            {{ old('org_offices_id', $organizationDepartment->org_offices_id ?? '') == $OrganizationOffice->id ? 'selected' : '' }}>
                                        {!! str_repeat('-- ', $OrganizationOffice->level) . $OrganizationOffice->office_name !!}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Sort Order -->
                        <div class="col-md-2">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control"
                                   value="{{ old('sort_order', $organizationDepartment->sort_order ?? 0) }}">
                        </div>

                        <!-- Status -->
                        <div class="col-md-2">
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

                        <!-- Description -->
                        <div class="col-md-8">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description"
                                      class="form-control">{{ old('description', $organizationDepartment->description ?? '') }}</textarea>
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
            const isParentCheckbox = document.getElementById('is_parent');
            const parentMenuDropdown = document.getElementById('parent_id');
            const orgOfficeDropdown = document.getElementById('org_offices_id');

            // Toggle Parent Menu based on "Is Parent" checkbox
            function toggleParentMenu() {
                parentMenuDropdown.disabled = isParentCheckbox.checked;
                if (isParentCheckbox.checked) {
                    parentMenuDropdown.innerHTML = '<option value="">{{ __("Select an option") }}</option>';
                } else if (orgOfficeDropdown.value) {
                    loadParentHierarchy(orgOfficeDropdown.value);
                }
            }

            // Load parent hierarchy dynamically
            function loadParentHierarchy(orgOfficeId) {
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
                    .catch(error => console.error('Error fetching parent hierarchy:', error));
            }

            // Event Listeners
            isParentCheckbox.addEventListener('change', toggleParentMenu);
            orgOfficeDropdown.addEventListener('change', function () {
                if (!isParentCheckbox.checked) {
                    loadParentHierarchy(this.value);
                }
            });

            // Initialize Parent Menu State
            toggleParentMenu();

            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Select an option',
                allowClear: true,
            });
        });
    </script>
@endsection
--}}
@extends('backend.layouts.app')

@section('title', isset($organizationDepartment) ? localize('Edit Department') : localize('Add Department'))

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3>{{ isset($organizationDepartment) ? localize('Edit Department') : localize('Add Department') }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($organizationDepartment) ? route('organization-departments.update', $organizationDepartment->id) : route('organization-departments.store') }}"
                      method="POST">
                    @csrf
                    @if(isset($organizationDepartment))
                        @method('PUT')
                    @endif

                    <div class="row mb-3">
                        <!-- Organization Name -->
                        <div class="col-md-6">
                            <label for="organization_id" class="form-label">Organization Name</label>
                            <select name="organization_id" id="organization_id" class="form-select select2" required>
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach($Organizations as $Organization)
                                    <option value="{{ $Organization->id }}"
                                            {{ old('organization_id', $organizationDepartment->org_offices_id ? $organizationDepartment->office->org_id ?? '' : '') == $Organization->id ? 'selected' : '' }}>
                                        {{ $Organization->org_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Is Parent Checkbox -->
                        <div class="col-md-6">
                            <div class="form-check mt-4">
                                <input type="checkbox" class="form-check-input" id="is_parent" name="is_parent"
                                       value="1"
                                        {{ old('is_parent', $organizationDepartment->parent_id ?? '') == null ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_parent">Is Parent</label>
                            </div>
                        </div>
                    </div>

                    <!-- Parent Menu Dropdown -->
                    <div class="row mb-3">
                        <div class="col-md-12">
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
                    </div>

                    <div class="row mb-3">
                        <!-- Department Name -->
                        <div class="col-md-6">
                            <label for="department_name" class="form-label">Department Name</label>
                            <input type="text" name="department_name" id="department_name" class="form-control"
                                   value="{{ old('department_name', $organizationDepartment->department_name ?? '') }}"
                                   required>
                        </div>

                        <!-- Organization Office -->
                        <div class="col-md-6">
                            <label for="org_offices_id" class="form-label">Organization Office</label>
                            <select name="org_offices_id" id="org_offices_id" class="form-select select2" required>
                                <option value="">{{ __('Select an option') }}</option>
                                @foreach($OrganizationOffices as $OrganizationOffice)
                                    <option value="{{ $OrganizationOffice->id }}"
                                            {{ old('org_offices_id', $organizationDepartment->org_offices_id ?? '') == $OrganizationOffice->id ? 'selected' : '' }}>
                                        {!! str_repeat('-- ', $OrganizationOffice->level) . $OrganizationOffice->office_name !!}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Sort Order -->
                        <div class="col-md-2">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control"
                                   value="{{ old('sort_order', $organizationDepartment->sort_order ?? 0) }}">
                        </div>

                        <!-- Status -->
                        <div class="col-md-2">
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

                        <!-- Description -->
                        <div class="col-md-8">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description"
                                      class="form-control">{{ old('description', $organizationDepartment->description ?? '') }}</textarea>
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
            const isParentCheckbox = document.getElementById('is_parent');
            const parentMenuDropdown = document.getElementById('parent_id');
            const orgOfficeDropdown = document.getElementById('org_offices_id');

            // Toggle Parent Menu based on "Is Parent" checkbox
            function toggleParentMenu() {
                parentMenuDropdown.disabled = isParentCheckbox.checked;
                if (isParentCheckbox.checked) {
                    parentMenuDropdown.innerHTML = '<option value="">{{ __("Select an option") }}</option>';
                } else if (orgOfficeDropdown.value) {
                    loadParentHierarchy(orgOfficeDropdown.value);
                }
            }

            // Load parent hierarchy dynamically
            function loadParentHierarchy(orgOfficeId) {
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

                        // Preserve the selected value
                        const selectedParentId = '{{ $organizationDepartment->parent_id ?? '' }}';
                        if (selectedParentId) {
                            parentMenuDropdown.value = selectedParentId;
                        }
                    })
                    .catch(error => console.error('Error fetching parent hierarchy:', error));
            }

            // Event Listeners
            isParentCheckbox.addEventListener('change', toggleParentMenu);
            orgOfficeDropdown.addEventListener('change', function () {
                if (!isParentCheckbox.checked) {
                    loadParentHierarchy(this.value);
                }
            });

            // Initialize Parent Menu State
            toggleParentMenu();

            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Select an option',
                allowClear: true,
            });
        });
    </script>
@endsection
