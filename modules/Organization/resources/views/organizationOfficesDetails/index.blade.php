
@extends('backend.layouts.app')

@section('content')
    <div class="container my-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0">{{ localize('Organization Office Details') }}</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('organization_offices_details.create') }}" class="btn btn-primary mb-3">{{ localize('Add Office Detail') }}</a>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{{ localize('Office Name') }}</th>
                            <th>{{ localize('Organization') }}</th>
                            <th>{{ localize('Status') }}</th>
                            <th>{{ localize('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($officeDetails as $officeDetail)
                            <tr>
                                <td>{{ $officeDetail->office_name }}</td>
                                <td>{{ $officeDetail->organizationOffice->office_name }}</td>
                                <td>{{ $officeDetail->status == 1 ? 'Active' : ($officeDetail->status == 2 ? 'Inactive' : 'Deleted') }}</td>
                                <td>
                                    <a href="{{ route('organization_offices.edit', $officeDetail->id) }}" class="btn btn-warning btn-sm">{{ localize('Edit') }}</a>
                                    <form action="{{ route('organization_offices.destroy', $officeDetail->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ localize('Are you sure?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">{{ localize('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
