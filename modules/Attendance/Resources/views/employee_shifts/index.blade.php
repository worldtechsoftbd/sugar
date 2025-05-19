@extends('backend.layouts.app')
@section('title', 'Employee Shifts')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Employee Shifts</h4>
            <a href="{{ route('employee-shifts.create') }}" class="btn btn-primary">Assign Shift</a>
        </div>
        <div class="card-body">
            <table id="employeeShiftsTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Employee</th>
                    <th>Mill Shift</th>
                    <th>Shift Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($employeeShifts as $shift)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $shift->employee->first_name .'-'.$shift->employee->last_name}}</td>
                        <td>{{ $shift->millShift->shift->name.'-'.$shift->millShift->OrganizationOffices->office_name  }}</td>
                        <td>{{ $shift->shift_date }}</td>
                        <td>
                            <a href="{{ route('employee-shifts.edit', $shift->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('employee-shifts.destroy', $shift->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('css')
    <!-- Include DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#employeeShiftsTable').DataTable({
                processing: true,
                serverSide: false,
                paging: true,
                searching: true,
                ordering: true,
                order: [[0, 'asc']]
            });
        });
    </script>
@endpush
