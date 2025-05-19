@extends('backend.layouts.app')

@section('title', localize('Tour and Visit Management'))

@section('content')
    <div class="container mt-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card border-0 shadow-lg">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="fas fa-plane me-2"></i>
                    {{ isset($tourAndVisit) ? localize('Edit Tour/Visit') : localize('Add Tour/Visit') }}
                </h5>
                <a href="{{ route('tourAndVisit.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left"></i> {{ localize('Back to List') }}
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('tourAndVisit.storeOrUpdate', ['tourAndVisit' => $tourAndVisit ?? null]) }}"
                      method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="row">
                        <!-- Employee ID -->
                        <div class="col-md-6 mb-3">
                            <label for="emp_id" class="form-label">{{ localize('Employee') }} <span class="text-danger">*</span></label>
                            <select name="emp_id" id="emp_id" class="form-select" required>
                                <option value="">{{ localize('Select Employee') }}</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('emp_id', $tourAndVisit->emp_id ?? '') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->first_name ?? 'N/A' }} -
                                        {{ $employee->employee_id ?? 'N/A' }} -
                                        {{ optional($employee->department)->department_name ?? 'N/A' }} -
                                        {{ optional($employee->position)->position_name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Applied Year -->
                        <div class="col-md-6 mb-3">
                            <label for="applied_year" class="form-label">{{ localize('Applied Year') }} <span
                                        class="text-danger">*</span></label>
                            <input type="number" name="applied_year" id="applied_year" class="form-control"
                                   value="{{ old('applied_year', $tourAndVisit->applied_year ?? date('Y')) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Type ID -->
                        <div class="col-md-6 mb-3">
                            <label for="type_id" class="form-label">{{ localize('Type') }} <span
                                        class="text-danger">*</span></label>
                            <select name="type_id" id="type_id" class="form-select" required>
                                <option value="">{{ localize('Select Type') }}</option>
                                <option value="1" {{ old('type_id', $tourAndVisit->type_id ?? '') == 1 ? 'selected' : '' }}>{{ localize('Tour') }}</option>
                                <option value="2" {{ old('type_id', $tourAndVisit->type_id ?? '') == 2 ? 'selected' : '' }}>{{ localize('Visit') }}</option>
                            </select>
                        </div>

                        <!-- Applied Date -->
                        <div class="col-md-6 mb-3">
                            <label for="applied_date" class="form-label">{{ localize('Applied Date') }} <span
                                        class="text-danger">*</span></label>
                            <input type="date" name="applied_date" id="applied_date" class="form-control"
                                   value="{{ old('applied_date', isset($tourAndVisit) ? date('Y-m-d', strtotime($tourAndVisit->applied_date)) : date('Y-m-d')) }}"
                                   required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Start Date -->
                        <div class="col-md-6 mb-3">
                            <label for="started_date" class="form-label">{{ localize('Start Date') }} <span
                                        class="text-danger">*</span></label>
                            <input type="date" name="started_date" id="started_date" class="form-control"
                                   value="{{ old('started_date', isset($tourAndVisit) ? date('Y-m-d', strtotime($tourAndVisit->started_date)) : '') }}"
                                   required>
                        </div>

                        <!-- End Date -->
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">{{ localize('End Date') }} <span
                                        class="text-danger">*</span></label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                   value="{{ old('end_date', isset($tourAndVisit) ? date('Y-m-d', strtotime($tourAndVisit->end_date)) : '') }}"
                                   required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Applied Status -->
                        <div class="col-md-6 mb-3">
                            <label for="appliedStatus" class="form-label">{{ localize('Applied Status') }}</label>
                            <select name="appliedStatus" id="appliedStatus" class="form-select">
                                <option value="1" {{ old('appliedStatus', $tourAndVisit->appliedStatus ?? 1) == 1 ? 'selected' : '' }}>
                                    {{ localize('Initial') }}
                                </option>
                                <option value="2" {{ old('appliedStatus', $tourAndVisit->appliedStatus ?? '') == 2 ? 'selected' : '' }}>
                                    {{ localize('Pending') }}
                                </option>
                                <option value="3" {{ old('appliedStatus', $tourAndVisit->appliedStatus ?? '') == 3 ? 'selected' : '' }}>
                                    {{ localize('Approved') }}
                                </option>
                                <option value="4" {{ old('appliedStatus', $tourAndVisit->appliedStatus ?? '') == 4 ? 'selected' : '' }}>
                                    {{ localize('Rejected') }}
                                </option>
                            </select>
                        </div>

                        <!-- Responsible Person -->
                        <div class="col-md-6 mb-3">
                            <label for="responsiblePerson"
                                   class="form-label">{{ localize('Responsible Person') }}</label>
                            <select name="responsiblePerson" id="responsiblePerson" class="form-select">
                                <option value="">{{ localize('Select Responsible Person') }}</option>
                                @foreach($responsiblePerson as $employee)
                                    <option value="{{ $employee->id }}" {{ old('responsiblePerson', $tourAndVisit->responsiblePerson ?? '') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->first_name.'-'.$employee->employee_id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="remarks" class="form-label">{{ localize('Remarks') }}</label>
                            <textarea name="remarks" id="remarks" class="form-control"
                                      rows="4">{{ old('remarks', $tourAndVisit->remarks ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">{{ localize('Status') }}</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ old('status', $tourAndVisit->status ?? 1) == 1 ? 'selected' : '' }}>
                                    {{ localize('Active') }}
                                </option>
                                <option value="2" {{ old('status', $tourAndVisit->status ?? '') == 2 ? 'selected' : '' }}>
                                    {{ localize('Inactive') }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ isset($tourAndVisit) ? localize('Update') : localize('Save') }}
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
