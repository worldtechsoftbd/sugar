@extends('backend.layouts.app')

@section('content')
    <div class="container my-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0">{{ localize('Organization Offices') }}</h4>
            </div>
            <div class="card-body">
                <a href="{{ route('organization_offices.create') }}" class="btn btn-primary mb-3">{{ localize('Add Office') }}</a>

                <div class="table-responsive">
                    <table id="organizationTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{ localize('Office Name') }}</th>
                            <th>{{ localize('Organization') }}</th>
                            <th>{{ localize('Status') }}</th>
                            <th>{{ localize('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($offices as $office)
                            <tr>
                                <td>{{ $office->office_name }}</td>
                                <td>{{ $office->organization->description }}</td>
                                <td>
                                     <span class="badge {{ $office->status == 1 ? 'bg-success' : ($office->status == 2 ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $office->status == 1 ? localize('Active') : ($office->status == 2 ? localize('Inactive') : localize('Deleted')) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('organization_offices.edit', $office->id) }}" class="btn btn-warning btn-sm">
                                        {{ localize('Edit') }}
                                    </a>
                                    <form action="{{ route('organization_offices.destroy', $office->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ localize('Are you sure?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ localize('Delete') }}
                                        </button>
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

    @push('css')
        <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    @endpush

    @push('js')
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#organizationTable').DataTable({
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
