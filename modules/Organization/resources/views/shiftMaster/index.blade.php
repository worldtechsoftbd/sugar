@extends('backend.layouts.app')
@section('title', localize('shift_list'))
@section('content')
    @include('backend.layouts.common.validation')

    <div class="mb-3">
        <a href="{{ route('shiftMasters.create') }}" class="btn btn-success">{{ localize('Add Shift Master') }}</a>
    </div>
    <table class="table table-bordered" id="shiftMasterTable">
        <thead>
        <tr>
            <th>{{ localize('ShiftID') }}</th>
            <th>{{ localize('ShiftName') }}</th>
            <th>{{ localize('Description') }}</th>
            <th>{{ localize('StartTime') }}</th>
            <th>{{ localize('EndTime') }}</th>
            <th>{{ localize('GracePeriod') }}</th>
            <th>{{ localize('IsApplicableGracePeriod') }}</th>
            <th>{{ localize('Status') }}</th>
            <th>{{ localize('Action') }}</th>
        </tr>
        </thead>
    </table>

    <script>
        $(document).ready(function () {
            $('#shiftMasterTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('shiftMasters.data') }}', // Route for DataTable AJAX data
                columns: [
                    {data: 'ShiftID', name: 'ShiftID'},
                    {data: 'ShiftName', name: 'ShiftName'},
                    {data: 'Description', name: 'Description'},
                    {data: 'StartTime', name: 'StartTime'},
                    {data: 'EndTime', name: 'EndTime'},
                    {data: 'GracePeriod', name: 'GracePeriod'},
                    {data: 'IsApplicableGracePeriod', name: 'IsApplicableGracePeriod'},
                    {data: 'Status', name: 'Status'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `
        <a href="{{ route('shiftMasters.edit', ['shiftMaster' => '__SHIFT_ID__']) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
        <a href="javascript:void(0)" onclick="deleteShift(__SHIFT_ID__)" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>
        `.replaceAll('__SHIFT_ID__', row.ShiftID);
                        }
                    }
                ]
            });
        });
    </script>
@endsection
