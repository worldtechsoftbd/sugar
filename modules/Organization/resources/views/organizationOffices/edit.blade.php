@extends('backend.layouts.app')

@section('content')
    <div class="container mt-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card border-0 shadow-lg">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="fas fa-building me-2"></i> {{ localize('Edit Organization Office') }}
                </h5>
                <a href="{{ route('organization_offices.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left"></i> {{ localize('Back to List') }}
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('organization_offices.update', $office->id) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <!-- Organization and Office Name in Same Row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="org_id" class="form-label">{{ localize('Organization') }} <span class="text-danger">*</span></label>
                            <select name="org_id" id="org_id" class="form-select" required>
                                <option value="">{{ localize('Select Organization') }}</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ $office->org_id == $organization->id ? 'selected' : '' }}>
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
                                   value="{{ old('office_name', $office->office_name) }}" required>
                            <div class="invalid-feedback">
                                {{ localize('Please provide the office name.') }}
                            </div>
                        </div>
                    </div>

                    <!-- Address and Phone Number -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="address" class="form-label">{{ localize('Address') }}</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $office->address) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">{{ localize('Phone Number') }}</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $office->phone_number) }}">
                        </div>
                    </div>

                    <!-- Longitude and Latitude -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="longitude" class="form-label">{{ localize('Longitude') }}</label>
                            <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $office->longitude) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="latitude" class="form-label">{{ localize('Latitude') }}</label>
                            <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $office->latitude) }}">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">{{ localize('Status') }}</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ old('status', $office->status) == 1 ? 'selected' : '' }}>
                                    {{ localize('Active') }}
                                </option>
                                <option value="2" {{ old('status', $office->status) == 2 ? 'selected' : '' }}>
                                    {{ localize('Inactive') }}
                                </option>
                                <option value="276" {{ old('status', $office->status) == 276 ? 'selected' : '' }}>
                                    {{ localize('Deleted') }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Description (Moved to the last) -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label">{{ localize('Description') }}</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $office->description) }}</textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> {{ localize('Update') }}
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
