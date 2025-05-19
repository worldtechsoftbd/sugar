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
                    @if(auth()->user()->roles->contains('role_code', 'super-admin') || auth()->user()->roles->contains('role_code', 'hr-admin'))
                        {{ localize('HR Approval Tour/Visit') }}
                    @else
                        {{ localize('Manager Approval Tour/Visit') }}
                    @endif
                </h5>
                <a href="{{ route('tourAndVisit.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left"></i> {{ localize('Back to List') }}
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('tourAndVisit.approveTourAndVisit') }}"
                      method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="row">
                        <!-- Employee ID -->
                        <div class="col-md-6 mb-3">
                            <label for="emp_id" class="form-label">{{ localize('Employee') }}</label>
                            <input type="text" class="form-control" readonly
                                   value="{{ $tourAndVisit->employee->first_name ?? 'N/A' }} - {{ $tourAndVisit->employee->employee_id ?? 'N/A' }} - {{ optional($tourAndVisit->employee->department)->department_name ?? 'N/A' }} - {{ optional($tourAndVisit->employee->position)->position_name ?? 'N/A' }}">
                            <input type="hidden" name="emp_id" value="{{ $tourAndVisit->employee->id ?? '' }}">
                            <input type="hidden" name="id" value="{{ $tourAndVisit->id ?? '' }}">
                        </div>

                        <!-- Applied Year -->
                        <div class="col-md-6 mb-3">
                            <label for="applied_year" class="form-label">{{ localize('Applied Year') }} <span
                                        class="text-danger">*</span></label>
                            <input type="number" name="applied_year" id="applied_year" class="form-control" readonly
                                   value="{{ old('applied_year', $tourAndVisit->applied_year ?? date('Y')) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Type ID -->
                        <div class="col-md-6 mb-3">
                            <label for="type_id" class="form-label">{{ localize('Type') }}</label>
                            <input type="text" class="form-control" readonly
                                   value="{{ $tourAndVisit->type_id == 1 ? localize('Tour') : localize('Visit') }}">
                            <input type="hidden" name="type_id" value="{{ $tourAndVisit->type_id }}">
                        </div>

                        <!-- Applied Date -->
                        <div class="col-md-6 mb-3">
                            <label for="applied_date" class="form-label">{{ localize('Applied Date') }} <span
                                        class="text-danger">*</span></label>
                            <input type="date" name="applied_date" id="applied_date" class="form-control" readonly
                                   value="{{ old('applied_date', isset($tourAndVisit) ? date('Y-m-d', strtotime($tourAndVisit->applied_date)) : date('Y-m-d')) }}"
                                   required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Start Date -->
                        <div class="col-md-6 mb-3">
                            <label for="started_date" class="form-label">{{ localize('Start Date') }} <span
                                        class="text-danger">*</span></label>
                            <input type="date" name="started_date" id="started_date" class="form-control" readonly
                                   value="{{ old('started_date', isset($tourAndVisit) ? date('Y-m-d', strtotime($tourAndVisit->started_date)) : '') }}"
                                   required>
                        </div>

                        <!-- End Date -->
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">{{ localize('End Date') }} <span
                                        class="text-danger">*</span></label>
                            <input type="date" name="end_date" id="end_date" class="form-control" readonly
                                   value="{{ old('end_date', isset($tourAndVisit) ? date('Y-m-d', strtotime($tourAndVisit->end_date)) : '') }}"
                                   required>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Div Head Responsible Person -->
                        <div class="col-md-6 mb-3">
                            <label for="headApproval"
                                   class="form-label">{{ localize('Head Approval') }}</label>
                            <input type="text" class="form-control" readonly name="headApproval"
                                   value="{{ optional($tourAndVisit->responsibleEmployee)->first_name ?? 'N/A' }} - {{ optional($tourAndVisit->responsibleEmployee)->employee_id ?? 'N/A' }} - {{ optional($tourAndVisit->responsibleEmployee->department)->department_name ?? 'N/A' }} - {{ optional($tourAndVisit->responsibleEmployee->position)->position_name ?? 'N/A' }}">
                        </div>

                        <!-- HR approve person -->
                        @if(auth()->user()->roles->contains('role_code', 'super-admin') || auth()->user()->roles->contains('role_code', 'hr-admin'))
                            <div class="col-md-6 mb-3">
                                <label for="hrApproval" class="form-label">{{ localize('HR Approval') }}</label>
                                <input type="text" class="form-control" readonly
                                       value="{{ auth()->user()->employee->first_name ?? 'N/A' }} - {{ auth()->user()->employee->employee_id ?? 'N/A' }} - {{ optional(auth()->user()->employee->department)->department_name ?? 'N/A' }} - {{ optional(auth()->user()->employee->position)->position_name ?? 'N/A' }}">
                                <input type="hidden" name="hrApproval"
                                       value="{{ auth()->user()->employee->id ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="remarks" class="form-label">{{ localize('Head Remarks or Reason') }}</label>
                                <input type="text" name="remarks" id="remarks" class="form-control" readonly
                                       value="{{ old('remarks', $tourAndVisit->remarks ?? '') }}">
                            </div>
                        @endif

                        <!-- Applied Status -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ localize('Application Status') }}</label>
                            <div>
                                @if(auth()->user()->roles->contains('role_code', 'manager'))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="appliedStatus" id="approve"
                                               value="2" {{ old('appliedStatus', $tourAndVisit->appliedStatus ?? '') == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                               for="approve">{{ localize('Forward To HR') }}</label>
                                    </div>
                                @endif
                                @if(auth()->user()->roles->contains('role_code', 'super-admin') || auth()->user()->roles->contains('role_code', 'hr-admin'))
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="appliedStatus" id="approve"
                                               value="3" {{ old('appliedStatus', $tourAndVisit->appliedStatus ?? '') == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="approve">{{ localize('approve') }}</label>
                                    </div>
                                @endif
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="appliedStatus" id="cancel"
                                           value="4" {{ old('appliedStatus', $tourAndVisit->appliedStatus ?? '') == 4 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cancel">{{ localize('Cancel') }}</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- History Table -->
                    <div class="table-responsive mt-4">
                        <h5 class="mb-3">{{ localize('Remarks History') }}</h5>
                        <table class="table table-bordered table-striped">
                            <thead class="bg-light">
                            <tr>
                                {{--<th>{{ localize('Status') }}</th>--}}
                                <th>{{ localize('Remarks or Reason') }}</th>
                                <th>{{ localize('Responsible Person') }}</th>
                                <th>{{ localize('Date') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($tourAndVisitLogs as $log)
                                <tr>
                                    {{--<td>
                                        @if($log['appliedStatus'] == 1)
                                            <span class="badge bg-info">{{ localize('Initial') }}</span>
                                        @elseif($log['appliedStatus'] == 2)
                                            <span class="badge bg-warning">{{ localize('Pending') }}</span>
                                        @elseif($log['appliedStatus'] == 3)
                                            <span class="badge bg-success">{{ localize('Approved') }}</span>
                                        @elseif($log['appliedStatus'] == 4)
                                            <span class="badge bg-danger">{{ localize('Rejected') }}</span>
                                        @endif
                                    </td>--}}
                                    <td>{{ $log['remarks'] ?? 'N/A' }}</td>
                                    <td>{{ $log['responsiblePerson'] ?? 'N/A' }}</td>
                                    <td>{{ $log['loggedAt'] ? date('d M Y h:i A', strtotime($log['loggedAt'])) : 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ localize('No history found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Remarks -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="remarks" class="form-label">{{ localize('Remarks') }}</label>
                            <textarea name="remarks" id="remarks" class="form-control"
                                      rows="4"></textarea>
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
