@extends('backend.layouts.app')

@section('title', 'Device Attendance List')

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="fs-17 fw-semi-bold mb-0">Device Attendance List</h6>
        </div>
        <div class="card-body">
            <table id="deviceAttendanceTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Status</th>
                    <th>Check Time</th>
                    <th>Check Type</th>
                    <th>Verify Code</th>
                    <th>Sensor ID</th>
                    <th>Memo Info</th>
                    <th>Work Code</th>
                    <th>SN</th>
                    <th>User Ext Fmt</th>
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
            $('#deviceAttendanceTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('device.attendances.data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'userId', name: 'userId' },
                    { data: 'status', name: 'status' },
                    { data: 'checkTime', name: 'checkTime' },
                    { data: 'checkType', name: 'checkType' },
                    { data: 'verifyCode', name: 'verifyCode' },
                    { data: 'sensorId', name: 'sensorId' },
                    { data: 'memoInfo', name: 'memoInfo' },
                    { data: 'workCode', name: 'workCode' },
                    { data: 'sn', name: 'sn' },
                    { data: 'userExtFmt', name: 'userExtFmt' },
                ],
            });
        });
    </script>
@endpush
