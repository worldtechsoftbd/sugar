@section('content')
    <div class="container">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ localize('Tour and Visit List') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{--<a href="{{ route('tourAndVisit.createOrEdit') }}" class="btn btn-primary mb-3">{{ localize('Add Tours') }}</a>--}}
                    <table id="tourAndVisitTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{ localize('Organization Name') }}</th>
                            <th>{{ localize('Description') }}</th>
                            <th>{{ localize('Address') }}</th>
                            <th>{{ localize('Status') }}</th>
                            <th>{{ localize('Actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#tourAndVisitTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('tourAndVisit.getTourAndVisitData') }}', // Update this route to your actual data route
                    columns: [
                        { data: 'org_name', name: 'org_name' },
                        { data: 'description', name: 'description' },
                        { data: 'address', name: 'address' },
                        { data: 'status', name: 'status', render: function (data) {
                                return '<span class="badge ' + (data == 1 ? 'bg-success' : (data == 2 ? 'bg-warning' : 'bg-danger')) + '">' +
                                    (data == 1 ? '{{ localize('Active') }}' : (data == 2 ? '{{ localize('Inactive') }}' : '{{ localize('Deleted') }}')) +
                                    '</span>';
                            }},
                        { data: 'action', name: 'action', orderable: false, searchable: false },
                    ],
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "{{ localize('All') }}"]],
                });
            });
        </script>
    @endpush
@endsection