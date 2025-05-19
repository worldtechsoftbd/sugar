@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <h2>Organization Details</h2>
        <p><strong>Name:</strong> {{ $organization->org_name }}</p>
        <p><strong>Description:</strong> {{ $organization->description }}</p>
        <p><strong>Address:</strong> {{ $organization->address }}</p>
        <p><strong>Phone Number:</strong> {{ $organization->phone_number }}</p>
        <p><strong>Email:</strong> {{ $organization->email }}</p>
        <p><strong>Coordinates:</strong> {{ $organization->latitude }}, {{ $organization->longitude }}</p>
        <p><strong>Status:</strong> {{ $organization->status == 1 ? 'Active' : ($organization->status == 2 ? 'Inactive' : 'Deleted') }}</p>
        <a href="{{ route('organizations.index') }}" class="btn btn-primary">Back</a>
    </div>
@endsection
