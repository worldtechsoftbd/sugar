@extends('backend.layouts.app')

@section('title', 'Attendance List')

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="fs-17 fw-semi-bold mb-0">Attendance List</h6>
        </div>
        <div class="card-body">
            <table id="attendanceTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Remarks</th>
                    <th>Machine Sl.</th>
                    <th>Check Type</th>
                    <th>Sensor</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#attendanceTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('attendances.data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'employee_info', name: 'employee_info' },
                    { data: 'attendance_date', name: 'attendance_date' },
                    {
                        data: 'time',
                        name: 'time',
                        render: function (data, type, row) {
                            return new Date(data).toLocaleTimeString();
                        }
                    },
                    { data: 'attendance_remarks', name: 'attendance_remarks' },
                    { data: 'sn', name: 'sn' },
                    {
                        data: 'checkType',
                        name: 'checkType',
                        render: function (data, type, row) {
                            return data === 'I' ? 'In' : 'Out';
                        }
                    },
                    { data: 'sensorId', name: 'sensorId' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
            });
        });
    </script>
@endpush
