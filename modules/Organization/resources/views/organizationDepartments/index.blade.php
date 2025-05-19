@extends('backend.layouts.app')

@section('title', localize('Organization Departments'))

@section('content')
    <div class="container">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')
        <div class="card">
            <div class="card-header">
                <h4>{{ localize('Departments') }}</h4>
                <a href="{{ route('organization-departments.create') }}" class="btn btn-primary">{{ localize('Add Department') }}</a>
            </div>
            <div class="card-body">
                <table class="table" id="departments-table">
                    <thead>
                    <tr>
                        <th>{{ localize('Name') }}</th>
                        <th>{{ localize('Parent') }}</th>
                        <th>{{ localize('Hierarchy') }}</th>
                        <th>{{ localize('Office') }}</th>
                        <th>{{ localize('Organization name') }}</th>
                        <th>{{ localize('Status') }}</th>
                        <th>{{ localize('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($departments as $index => $department)
                        <tr>


                            <td>{{  $department->department_name }}</td>
                            <td>{{ $department->parent ? $department->parent->department_name : localize('None') }}</td>
                            <td> {{ $departmentHierarchies[$index] }}</td>

                            <td>{{ $department->organizationOffice->description?? '' }}</td>
                            <td>{{ $department->organizationOffice->organization->description?? '' }}</td>

                            <td>
                                <span class="badge bg-{{ $department->status == 1 ? 'success' : ($department->status == 2 ? 'warning' : 'danger') }}">
                                    {{ $department->status == 1 ? localize('Active') : ($department->status == 2 ? localize('Inactive') : localize('Deleted')) }}
                                </span>
                            </td>
                            <!-- Actions -->
                            <td>
                                <a href="{{ route('organization-departments.edit', $department->id) }}" class="btn btn-sm btn-primary">{{ localize('Edit') }}</a>
                                <form action="{{ route('organization-departments.destroy', $department->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">{{ localize('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('css')
        <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    @endpush

    @push('js')
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#departments-table').DataTable({
                    paging: true,
                    searching: true,
                    info: true,
                    ordering: true,
                    autoWidth: false,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "{{ localize('All') }}"]],
                });
            });
        </script>
    @endpush

@endsection
