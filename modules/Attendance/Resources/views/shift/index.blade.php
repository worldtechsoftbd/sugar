
@extends('backend.layouts.app')
@section('title', localize('shift_configuration_list'))

@section('content')
    <div class="card mb-4">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('shift_configuration_list') }}</h6>
            <a href="{{ route('shifts.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> {{ localize('add_new_shift') }}
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="shiftsTable" class="table table-bordered table-striped">
                    <thead >
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ localize('shift_name') }}</th>
                        <th scope="col">{{ localize('start_time') }}</th>
                        <th scope="col">{{ localize('end_time') }}</th>
                        <th scope="col">{{ localize('grace_period') }}</th>
                        <th scope="col">{{ localize('status') }}</th>
                        <th scope="col">{{ localize('actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($shifts as $shift)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $shift->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}</td>

                            <td>{{ $shift->grace_period ?? localize('not_set') }} {{ $shift->grace_period ? localize('minutes') : '' }}</td>

                            <td>
                                <span class="badge {{ $shift->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $shift->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('shifts.edit', $shift->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> {{ localize('edit') }}
                                    </a>
                                    <form action="{{ route('shifts.destroy', ['id' => $shift->id]) }}" method="POST" onsubmit="return confirm('{{ localize('are_you_sure') }}');">
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
                            <td colspan="9" class="text-center text-muted">{{ localize('no_shifts_found') }}</td>
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
    {{--<script>
        $(document).ready(function () {
            $('#shiftsTable').DataTable({
                paging: true,
                searching: true,
                info: true,
                ordering: true,
                autoWidth: false,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            });
        });
    </script>--}}
@endpush
