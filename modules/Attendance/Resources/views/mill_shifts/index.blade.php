@extends('backend.layouts.app')

@section('title', localize('mill_shift_configuration_list'))

@section('content')
    <div class="card mb-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('mill_shift_configuration_list') }}</h6>
            <a href="{{ route('attendance.mill-shifts.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> {{ localize('add_new_mill_shift') }}
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="millShiftsTable" class="table table-bordered table-striped">
                    <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ localize('organization_name') }}</th>
                        <th scope="col">{{ localize('shift_name') }}</th>
                        <th scope="col">{{ localize('start_time') }}</th>
                        <th scope="col">{{ localize('end_time') }}</th>
                        <th scope="col">{{ localize('status') }}</th>
                        <th scope="col">{{ localize('actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($millShifts as $millShift)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $millShift->OrganizationOffices->office_name ?? localize('unknown') }}</td>
                            <td>{{ $millShift->shift->name ?? localize('no_shift') }}</td>
                            <td>{{ \Carbon\Carbon::parse($millShift->shift->start_time)->format('h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($millShift->shift->end_time)->format('h:i A') }}</td>
                            <td>
                                <span class="badge {{ $millShift->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $millShift->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('attendance.mill-shifts.edit', $millShift->id) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> {{ localize('edit') }}
                                    </a>
                                    <form action="{{ route('attendance.mill-shifts.destroy', $millShift->id) }}"
                                          method="POST" onsubmit="return confirm('{{ localize('are_you_sure') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ localize('delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">{{ localize('no_mill-shifts_found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <!-- Include DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('js')
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('#millShiftsTable').DataTable({--}}
{{--                paging: true,--}}
{{--                searching: true,--}}
{{--                info: true,--}}
{{--                ordering: true,--}}
{{--                autoWidth: false,--}}
{{--                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endpush
