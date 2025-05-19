@extends('backend.layouts.app')
@section('title', localize('office_head_list'))
@section('content')
    @include('backend.layouts.common.validation')

    <div class="mb-3">
        {{--<a href="{{ route('orgOfficeHead.create') }}" class="btn btn-success">{{ localize('Add Office Head') }}</a>--}}
    </div>
    <table class="table table-bordered" id="orgOfficeHeadTable">
        <thead>
        <tr>
            <th>{{ localize('SL.') }}</th>
            <th>{{ localize('Started Date') }}</th>
            <th>{{ localize('Office Name') }}</th>
            <th>{{ localize('Employee Name') }}</th>
            <th>{{ localize('Status') }}</th>
            <th>{{ localize('Action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orgOfficeHeads as $index => $officeHead)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $officeHead->started_date }}</td>
                <td>{{ $officeHead->org_office_name }}</td>
                <td>{{ $officeHead->employee_name }}</td>
                <td>{{ $officeHead->status }}</td>
                <td>
                    <a href="{{ route('orgOfficeHead.edit', ['officeHead' => $officeHead->id]) }}"
                       class="btn btn-sm btn-primary">
                        <i class="fa fa-edit"></i> {{ localize('Edit') }}
                    </a>
                    <a href="javascript:void(0)" onclick="deleteOfficeHead({{ $officeHead->id }})"
                       class="btn btn-sm btn-danger">
                        <i class="fa fa-trash"></i> {{ localize('Delete') }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
