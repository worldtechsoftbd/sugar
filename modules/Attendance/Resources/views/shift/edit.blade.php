@extends('backend.layouts.app')
@section('title', localize('Edit Shift'))

@section('content')
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ localize('Edit Shift') }}</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('shifts.update', $shift->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Shift Name -->
                    <div class="col-lg-6">
                        <label for="name" class="form-label fw-bold">{{ localize('Shift Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $shift->name) }}"
                               class="form-control @error('name') is-invalid @enderror" placeholder="{{ localize('Enter Shift Name') }}" required>
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-lg-6">
                        <label for="description" class="form-label fw-bold">{{ localize('Description') }}</label>
                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror"
                                  placeholder="{{ localize('Enter Description') }}">{{ old('description', $shift->description) }}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div class="col-lg-6">
                        <label for="start_time" class="form-label fw-bold">{{ localize('Start Time') }} <span class="text-danger">*</span></label>
                        <input type="time" name="start_time" id="start_time"
                               value="{{ old('start_time', \Carbon\Carbon::parse($shift->start_time)->format('H:i')) }}"
                               class="form-control @error('start_time') is-invalid @enderror" required>
                        @error('start_time')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div class="col-lg-6">
                        <label for="end_time" class="form-label fw-bold">{{ localize('End Time') }} <span class="text-danger">*</span></label>
                        <input type="time" name="end_time" id="end_time"
                               value="{{ old('end_time', \Carbon\Carbon::parse($shift->end_time)->format('H:i')) }}"
                               class="form-control @error('end_time') is-invalid @enderror" required>
                        @error('end_time')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Grace Period -->
                    <div class="col-lg-6">
                        <label for="grace_period" class="form-label fw-bold">{{ localize('Grace Period (minutes)') }}</label>
                        <input type="number" name="grace_period" id="grace_period"
                               value="{{ old('grace_period', $shift->grace_period) }}" min="0"
                               class="form-control @error('grace_period') is-invalid @enderror" placeholder="{{ localize('E.g., 5') }}">
                        @error('grace_period')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-lg-6">
                        <label for="status" class="form-label fw-bold">{{ localize('Status') }}</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="1" @selected(old('status', $shift->status) == 1)>{{ localize('Active') }}</option>
                            <option value="0" @selected(old('status', $shift->status) == 0)>{{ localize('Inactive') }}</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Is Next Day -->
                    <div class="col-lg-6">
                        <div class="form-check mt-3">
                            <input type="hidden" name="is_next_day" value="0">
                            <input class="form-check-input" type="checkbox" name="is_next_day" id="is_next_day" value="1"
                                    @checked(old('is_next_day', $shift->is_next_day) == 1)>
                            <label class="form-check-label fw-bold" for="is_next_day">
                                {{ localize('Does it continue to the next day?') }}
                            </label>
                        </div>
                    </div>

                    <!-- Is Applicable Grace Period -->
                    <div class="col-lg-6">
                        <div class="form-check mt-3">
                            <input type="hidden" name="isApplicableGracePeriod" value="0">
                            <input class="form-check-input" type="checkbox" name="isApplicableGracePeriod" id="isApplicableGracePeriod" value="1"
                                    @checked(old('isApplicableGracePeriod', $shift->isApplicableGracePeriod) == 1)>
                            <label class="form-check-label fw-bold" for="is_applicable_grace_period">
                                {{ localize('Apply Grace Period?') }}
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> {{ localize('Update Shift') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
