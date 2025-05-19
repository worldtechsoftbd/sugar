@extends('backend.layouts.app')
@section('title', localize('leave_application_list'))
@push('css')
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush
@section('content')

    @include('humanresource::leave_header')

    <div class="card mb-4 fixed-tab-body">
        @include('backend.layouts.common.validation')
        @include('backend.layouts.common.message')

        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('Leave Balance LIst') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">
                        <button type="button" class="btn btn-success" id="insert-all-leave-balance">
                            <i class="fas fa-plus-circle"></i> {{ localize('insert_all_leave_balance') }}
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <div id="flush-collapseOne" class="accordion-collapse collapse bg-white mb-4"
                                 aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="row">
                                    <div class="col-md-2 mb-4">
                                        <select id="employee_name" class="select-basic-single">
                                            <option selected value="">{{ localize('all_employees') }}</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ ucwords($employee->full_name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-4 align-self-end">
                                        <button type="button" id="leave-application-filter" class="btn btn-success">{{ localize('find') }}</button>
                                        <button type="button" id="leave-application-search-reset" class="btn btn-danger">{{ localize('reset') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table with Leave Balances and Edit Button -->
            <div class="table_customize">
                <table id="leave_balance_table" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>{{ localize('employee') }}</th>
                        <th>{{ localize('leave_type') }}</th>
                        <th>{{ localize('leave_balance') }}</th>
                        <th>{{ localize('actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $employee)
                        @foreach($leaveTypes as $leaveType)
                            <tr>
                                <td>{{ $employee->full_name }}</td>
                                <td>{{ $leaveType->leave_type }}</td>
                                <td>{{ $leaveBalances[$employee->id][$leaveType->id] ?? 0 }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editLeaveBalanceModal"
                                            data-employee-id="{{ $employee->id }}"
                                            data-leave-type-id="{{ $leaveType->id }}"
                                            data-leave-balance="{{ $leaveBalances[$employee->id][$leaveType->id] ?? 0 }}">
                                        {{ localize('edit') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Leave Balance Modal -->
    <div class="modal fade" id="editLeaveBalanceModal" data-bs-backdrop="static" data-bs-keyboard="false"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ localize('edit_leave_balance') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editLeaveBalanceForm">
                        @csrf
                        <input type="hidden" id="employee_id" name="employee_id">
                        <input type="hidden" id="leave_type_id" name="leave_type_id">

                        <div class="mb-3">
                            <label for="leave_balance" class="form-label">{{ localize('leave_balance') }}</label>
                            <input type="number" class="form-control" id="leave_balance" name="leave_balance" required>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ localize('update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ module_asset('HumanResource/js/hrcommon.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#employee_name').select2({
                placeholder: "{{ localize('all_employees') }}",
                allowClear: true,
                minimumResultsForSearch: Infinity // This should disable search for fewer than 5 options
            });

            // Open Edit Modal and Pre-fill Data
            $('#editLeaveBalanceModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var employeeId = button.data('employee-id');
                var leaveTypeId = button.data('leave-type-id');
                var leaveBalance = button.data('leave-balance');

                var modal = $(this);
                modal.find('#employee_id').val(employeeId);  // Set employee_id field
                modal.find('#leave_type_id').val(leaveTypeId);  // Set leave_type_id field
                modal.find('#leave_balance').val(leaveBalance);  // Set leave_balance field
            });

            // Handle the form submission for updating leave balance
            $('#editLeaveBalanceForm').on('submit', function (e) {
                e.preventDefault();

                // Get the values from the modal form
                var employeeId = $('#employee_id').val();  // Ensure employee_id is set
                var leaveTypeId = $('#leave_type_id').val();  // Ensure leave_type_id is set
                var leaveBalance = $('#leave_balance').val();  // Ensure leave_balance is set

                // Check if the required fields have values
                if (!employeeId || !leaveTypeId || !leaveBalance) {
                    alert("{{ localize('all_fields_are_required') }}");
                    return;
                }

                $.ajax({
                    url: "{{ route('leave_balance.update') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        employee_id: employeeId,
                        leave_type_id: leaveTypeId,
                        leave_balance: leaveBalance
                    },
                    success: function(response) {
                        // Close modal
                        $('#editLeaveBalanceModal').modal('hide');
                        // Refresh the page or show success message
                        location.reload();  // Or use Toastr for a success message
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            });

            // Initialize DataTable
            $('#leave_balance_table').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>

    @push('js')
        <script src="{{ module_asset('HumanResource/js/hrcommon.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                // Handle the Insert All Leave Balance button click
                $('#insert-all-leave-balance').click(function() {
                    // Send AJAX request to insert leave balance for all employees
                    $.ajax({
                        url: "{{ route('leave_balance.insert_all') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                location.reload();  // Refresh the page to reflect changes
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Error: ' + error);
                        }
                    });
                });
            });
        </script>
    @endpush

@endpush
