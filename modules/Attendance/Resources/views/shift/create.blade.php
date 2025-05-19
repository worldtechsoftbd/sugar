@extends('backend.layouts.app')
@section('title', localize('Shift Configuration'))

@section('content')
    <div class="card mb-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ localize('Shift Configuration') }}</h5>
        </div>

        <div class="card-body">
            <form id="shift-config" action="{{ route('shifts.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- Shift Name -->
                    <div class="col-lg-6">
                        <label for="name" class="form-label fw-bold">{{ localize('Shift Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control"
                               placeholder="{{ localize('Enter Shift Name') }}" value="{{ old('name') }}" required>
                    </div>

                    <!-- Description -->
                    <div class="col-lg-6">
                        <label for="description" class="form-label fw-bold">{{ localize('Description') }}</label>
                        <textarea name="description" id="description" rows="3" class="form-control"
                                  placeholder="{{ localize('Enter Description') }}">{{ old('description') }}</textarea>
                    </div>

                    <!-- Start Time -->
                    <div class="col-lg-6">
                        <label for="start_time" class="form-label fw-bold">{{ localize('Start Time') }} <span class="text-danger">*</span></label>
                        <input type="time" name="start_time" id="start_time" class="form-control"
                               value="{{ old('start_time') }}" required>
                    </div>

                    <!-- End Time -->
                    <div class="col-lg-6">
                        <label for="end_time" class="form-label fw-bold">{{ localize('End Time') }} <span class="text-danger">*</span></label>
                        <input type="time" name="end_time" id="end_time" class="form-control"
                               value="{{ old('end_time') }}" required>
                    </div>

                    <!-- Grace Period -->
                    <div class="col-lg-6">
                        <label for="grace_period" class="form-label fw-bold">{{ localize('Grace Period (minutes)') }}</label>
                        <input type="number" name="grace_period" id="grace_period" class="form-control"
                               placeholder="{{ localize('E.g., 5') }}" value="{{ old('grace_period') }}" min="0">
                    </div>

                    <!-- Status -->
                    <div class="col-lg-6">
                        <label for="status" class="form-label fw-bold">{{ localize('Status') }}</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1" @selected(old('status') == '1')>{{ localize('Active') }}</option>
                            <option value="2" @selected(old('status') == '2')>{{ localize('Inactive') }}</option>
                        </select>
                    </div>

                    <!-- Is Next Day -->
                    <div class="col-lg-6">
                        <div class="form-check">
                            <input type="hidden" name="is_next_day" value="0">
                            <input class="form-check-input" type="checkbox" name="is_next_day" id="is_next_day" value="1"
                                    @checked(old('is_next_day', $shift->is_next_day ?? '') == '1')>
                            <label class="form-check-label fw-bold" for="is_next_day">
                                {{ localize('Does it continue to the next day?') }}
                            </label>
                        </div>
                    </div>

                    <!-- Is Applicable Grace Period -->
                    <div class="col-lg-6">
                        <div class="form-check">
                            <input type="hidden" name="isApplicableGracePeriod" value="0">
                            <input class="form-check-input" type="checkbox" name="isApplicableGracePeriod"
                                   id="isApplicableGracePeriod" value="1"
                                    @checked(old('isApplicableGracePeriod') == '1')>
                            <label class="form-check-label fw-bold" for="isApplicableGracePeriod">
                                {{ localize('Apply Grace Period?') }}
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> {{ localize('Save Shift') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
