@extends('backend.layouts.app')
@section('title', localize('functional_designation_list'))
@section('content')
    @include('humanresource::employee_header')
    @include('backend.layouts.common.validation')
    <div class="card mb-4 fixed-tab-body">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('functional_designation_list') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">
                        @can('create_functional_designations')
                            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#create-functional-designation"><i
                                    class="fa fa-plus-circle"></i>&nbsp;{{ localize('add_functional_designation') }}</a>
                            @include('humanresource::employee.functionalDesignation.modal.create')
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="10%">{{ localize('sl') }}</th>
                            <th width="15%">{{ localize('functional_designation_name') }}</th>
                            <th width="15%">{{ localize('functional_designation_short') }}</th>
                            <th width="15%">{{ localize('seniority_order') }}</th>
                            <th width="10%">{{ localize('status') }}</th>
                            <th width="10%">{{ localize('action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($functionalDesignations as $key => $functionalDesignation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $functionalDesignation->functional_designation }}</td>
                                <td>{{ $functionalDesignation->designation_short }}</td>
                                <td>{{ $functionalDesignation->seniority_order }}</td>
                                <td>
                                    @if ($functionalDesignation->status == 1)
                                        <span class="badge bg-success">{{ localize('active') }}</span>
                                    @elseif($functionalDesignation->status == 0)
                                        <span class="badge bg-danger ">{{ localize('inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @can('update_functional_designations')
                                        <a href="#" class="btn btn-primary-soft btn-sm me-1" data-bs-toggle="modal"
                                            data-bs-target="#update-functional-designation-{{ $functionalDesignation->id }}" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        @include('humanresource::employee.functionalDesignation.modal.edit')
                                    @endcan

                                    @can('delete_functional_designations')
                                        <a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm"
                                            data-bs-toggle="tooltip" title="Delete"
                                            data-route="{{ route('functionalDesignation.destroy', $functionalDesignation->uuid) }}"
                                            data-csrf="{{ csrf_token() }}"><i class="fa fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
