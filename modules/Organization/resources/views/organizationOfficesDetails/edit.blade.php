@extends('backend.layouts.app')

@section('content')
    <div class="container my-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0">Edit Organization Office</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('organization_offices.update', $office->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="org_id" class="form-label">Organization</label>
                        <select name="org_id" id="org_id" class="form-control" required>
                            <option value="">Select Organization</option>
                            @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}" {{ $office->org_id == $organization->id ? 'selected' : '' }}>
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
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
