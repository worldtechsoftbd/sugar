@extends('backend.layouts.app')
@section('title', localize('messages'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('messages') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">

                        @can('create_messages')

                            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addMessage"><i
                                    class="fa fa-plus-circle"></i>&nbsp;{{ localize('new_message') }}</a>
                        @endcan

                        @include('humanresource::message.create')
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">{{ localize('sl') }}</th>
                            <th width="25%">{{ localize('sender_name') }}</th>
                            <th width="20%">{{ localize('subject') }}</th>
                            <th width="15%">{{ localize('message') }}</th>
                            <th width="15%">{{ localize('status') }}</th>
                            <th width="15%">{{ localize('action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dbData as $key => $data)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $data->user->full_name }}</td>
                                <td>{{ $data->subject }}</td>
                                <td>{{ $data->message }}</td>
                                <td>{!! $data->receiver_status == 1 ? "<i class='label label-success'>seen</i>" : "<i class='label label-warning'>not seen</i>" !!}</td>

                                <td>
                                @can('update_messages')
                                    <a href="#" class="btn btn-primary-soft btn-sm me-1" data-bs-toggle="modal"
                                        data-bs-target="#editMessage{{ $data->id }}" title="Edit"><i
                                            class="fa fa-edit"></i></a>
                                @endcan

                                @can('delete_messages')

                                    <a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm"
                                        data-bs-toggle="tooltip" title="Delete"
                                        data-route="{{ route('message.destroy', $data->uuid) }}"
                                        data-csrf="{{ csrf_token() }}"><i class="fa fa-trash"></i></a>

                                @endcan

                                </td>
                            </tr>

                            @include('humanresource::message.edit')

                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ localize('empty_data') }}</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>


    </div>
@endsection
@push('js')
@endpush
