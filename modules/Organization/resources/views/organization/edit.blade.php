@extends('backend.layouts.app')

@section('content')
    <div class="container mt-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card border-0 shadow-lg">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="fas fa-building me-2"></i>
                    {{ isset($organization) ? localize('Edit Organization') : localize('Add Organization') }}
                </h5>
                <a href="{{ route('organizations.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left"></i> {{ localize('Back to List') }}
                </a>
            </div>

            <div class="card-body">
                <form action="{{ isset($organization) ? route('organizations.update', $organization) : route('organizations.store') }}"
                      method="POST" class="needs-validation" novalidate>
                    @csrf
                    @if(isset($organization))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <!-- Organization Name -->
                        <div class="col-md-6 mb-3">
                            <label for="org_name" class="form-label">{{ localize('Organization Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="org_name" id="org_name" class="form-control"
                                   value="{{ old('org_name', $organization->org_name ?? '') }}" required>
                            <div class="invalid-feedback">
                                {{ localize('Please provide the organization name.') }}
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">{{ localize('Phone Number') }}</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control"
                                   value="{{ old('phone_number', $organization->phone_number ?? '') }}">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Address -->
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">{{ localize('Address') }}</label>
                            <input type="text" name="address" id="address" class="form-control"
                                   value="{{ old('address', $organization->address ?? '') }}">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">{{ localize('Email') }}</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="{{ old('email', $organization->email ?? '') }}">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Longitude -->
                        <div class="col-md-6 mb-3">
                            <label for="longitude" class="form-label">{{ localize('Longitude') }}</label>
                            <input type="text" name="longitude" id="longitude" class="form-control"
                                   value="{{ old('longitude', $organization->longitude ?? '') }}">
                        </div>

                        <!-- Latitude -->
                        <div class="col-md-6 mb-3">
                            <label for="latitude" class="form-label">{{ localize('Latitude') }}</label>
                            <input type="text" name="latitude" id="latitude" class="form-control"
                                   value="{{ old('latitude', $organization->latitude ?? '') }}">
                        </div>
                    </div>

                    <div class="row">
                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">{{ localize('Status') }}</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ old('status', $organization->status ?? 1) == 1 ? 'selected' : '' }}>
                                    {{ localize('Active') }}
                                </option>
                                <option value="2" {{ old('status', $organization->status ?? 1) == 2 ? 'selected' : '' }}>
                                    {{ localize('Inactive') }}
                                </option>
                                <option value="276" {{ old('status', $organization->status ?? 1) == 276 ? 'selected' : '' }}>
                                    {{ localize('Deleted') }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">{{ localize('Description') }}</label>
                            <textarea name="description" id="description" class="form-control"
                                      rows="4">{{ old('description', $organization->description ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> {{ isset($organization) ? localize('Update') : localize('Save') }}
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
