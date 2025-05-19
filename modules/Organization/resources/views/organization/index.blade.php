@extends('backend.layouts.app')

@section('title', localize('Organization Management'))

@section('content')
    <div class="container">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ localize('Organizations List') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <a href="{{ route('organizations.create') }}" class="btn btn-primary mb-3">{{ localize('Add Organization') }}</a>

                    <table id="organizationTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{ localize('Organization Name') }}</th>
                            <th>{{ localize('Description') }}</th>
                            <th>{{ localize('Address') }}</th>
                            <th>{{ localize('Status') }}</th>
                            <th>{{ localize('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($organizations as $organization)
                            <tr>
                                <td>{{ $organization->org_name }}</td>
                                <td>{{ $organization->description }}</td>
                                <td>{{ $organization->address }}</td>
                                <td>
                                    <span class="badge {{ $organization->status == 1 ? 'bg-success' : ($organization->status == 2 ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $organization->status == 1 ? localize('Active') : ($organization->status == 2 ? localize('Inactive') : localize('Deleted')) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('organizations.edit', $organization->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i> {{ localize('Edit') }}
                                    </a>
                                    <form action="{{ route('organizations.destroy', $organization->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ localize('Are you sure?') }}');">
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
