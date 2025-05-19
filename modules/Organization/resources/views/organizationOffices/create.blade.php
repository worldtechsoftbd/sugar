{{--@extends('backend.layouts.app')

@section('content')
    <div class="container my-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card shadow">
            <div class="card-header ">
                <h4 class="mb-0">Add Organization Office</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('organization_offices.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="org_id" class="form-label">Organization</label>
                        <select name="org_id" id="org_id" class="form-control" required>
                            <option value="">Select Organization</option>
                            @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}" {{ old('org_id') == $organization->id ? 'selected' : '' }}>
                                    {{ $organization->org_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="office_name" class="form-label">Office Name</label>
                        <input type="text" name="office_name" id="office_name" class="form-control" value="{{ old('office_name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Inactive</option>
                            <option value="276" {{ old('status') == 276 ? 'selected' : '' }}>Deleted</option>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection--}}

@extends('backend.layouts.app')

@section('content')
    <div class="container mt-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card border-0 shadow-lg">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="fas fa-building me-2"></i> {{ localize('Add Organization Office') }}
                </h5>
                <a href="{{ route('organization_offices.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left"></i> {{ localize('Back to List') }}
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('organization_offices.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Organization and Office Name in Same Row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="org_id" class="form-label">{{ localize('Organization') }} <span class="text-danger">*</span></label>
                            <select name="org_id" id="org_id" class="form-select" required>
                                <option value="">{{ localize('Select Organization') }}</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ old('org_id') == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->org_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                {{ localize('Please select an organization.') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="office_name" class="form-label">{{ localize('Office Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="office_name" id="office_name" class="form-control"
                                   value="{{ old('office_name') }}" required>
                            <div class="invalid-feedback">
                                {{ localize('Please provide the office name.') }}
                            </div>
                        </div>
                    </div>

                    <!-- Address and Phone Number -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="address" class="form-label">{{ localize('Address') }}</label>
                            <input type="text" name="address" id="address" class="form-control"
                                   value="{{ old('address') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">{{ localize('Phone Number') }}</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control"
                                   value="{{ old('phone_number') }}">
                        </div>
                    </div>

                    <!-- Longitude and Latitude -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="longitude" class="form-label">{{ localize('Longitude') }}</label>
                            <input type="text" name="longitude" id="longitude" class="form-control"
                                   value="{{ old('longitude') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="latitude" class="form-label">{{ localize('Latitude') }}</label>
                            <input type="text" name="latitude" id="latitude" class="form-control"
                                   value="{{ old('latitude') }}">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">{{ localize('Status') }}</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>{{ localize('Active') }}</option>
                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>{{ localize('Inactive') }}</option>
                                <option value="276" {{ old('status') == 276 ? 'selected' : '' }}>{{ localize('Deleted') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Description (Moved to the last) -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label">{{ localize('Description') }}</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
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

@push('css')
    <style>
        .form-label {
            font-weight: 600;
        }
    </style>
@endpush

@push('js')
    <script>
        (function () {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endpush





{{--@extends('backend.layouts.app')

@section('title', localize('Add Organization Office'))

@section('content')
    <div class="container">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0">{{ localize('Add Organization Office') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('organization_offices.store') }}" method="POST">
                    @csrf

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td><label for="org_id" class="form-label">{{ localize('Organization') }}</label></td>
                                <td>
                                    <select name="org_id" id="org_id" class="form-control" required>
                                        <option value="">{{ localize('Select Organization') }}</option>
                                        @foreach($organizations as $organization)
                                            <option value="{{ $organization->id }}" {{ old('org_id') == $organization->id ? 'selected' : '' }}>
                                                {{ $organization->org_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="office_name" class="form-label">{{ localize('Office Name') }}</label></td>
                                <td><input type="text" name="office_name" id="office_name" class="form-control" value="{{ old('office_name') }}" required></td>
                            </tr>
                            <tr>
                                <td><label for="description" class="form-label">{{ localize('Description') }}</label></td>
                                <td><textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea></td>
                            </tr>
                            <tr>
                                <td><label for="address" class="form-label">{{ localize('Address') }}</label></td>
                                <td><input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}"></td>
                            </tr>
                            <tr>
                                <td><label for="phone_number" class="form-label">{{ localize('Phone Number') }}</label></td>
                                <td><input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}"></td>
                            </tr>
                            <tr>
                                <td><label for="longitude" class="form-label">{{ localize('Longitude') }}</label></td>
                                <td><input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude') }}"></td>
                            </tr>
                            <tr>
                                <td><label for="latitude" class="form-label">{{ localize('Latitude') }}</label></td>
                                <td><input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude') }}"></td>
                            </tr>
                            <tr>
                                <td><label for="status" class="form-label">{{ localize('Status') }}</label></td>
                                <td>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>{{ localize('Active') }}</option>
                                        <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>{{ localize('Inactive') }}</option>
                                        <option value="276" {{ old('status') == 276 ? 'selected' : '' }}>{{ localize('Deleted') }}</option>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">{{ localize('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection--}}


