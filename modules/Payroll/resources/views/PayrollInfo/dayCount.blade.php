@extends('backend.layouts.app')

@section('title', 'Employee Salary Day Count')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">{{ localize('Employee Salary Day Count') }}</h4>
        </div>

        <!-- Salary Day Count Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form id="salaryDayCountForm" method="POST" action="{{ route('payroll.dayCount.process') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label for="payment_date" class="form-label">{{ localize('Select Payment Date') }}</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                        </div>
                        <div class="col-md-4 align-self-end">
                            <button type="submit" class="btn btn-success">{{ localize('Process Salary Day Count') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Form -->
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <form id="searchForm">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="search_year_month" class="form-label">{{ localize('Search by Year-Month') }}</label>
                            <input type="month" class="form-control" id="search_year_month" name="search_year_month">
                        </div>
                        <div class="col-md-4 align-self-end">
                            <button type="button" id="searchBtn" class="btn btn-primary">{{ localize('Search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Salary Day Count Table -->
        <div class="card shadow-sm mt-4">
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered" id="dayCountTable">
                    <thead class="table-light">
                    <tr>
                        <th>{{ localize('ID') }}</th>
                        <th>{{ localize('Employee') }}</th>
                        <th>{{ localize('Payroll ID') }}</th>
                        <th>{{ localize('Year-Month') }}</th>
                        <th>{{ localize('Days Counted') }}</th>
                        <th>{{ localize('Days Paid') }}</th>
                        <th>{{ localize('Status') }}</th>
                        <th class="text-center">{{ localize('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editDayCountModal" tabindex="-1" aria-labelledby="editDayCountLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ localize('Edit Salary Day Count') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editDayCountForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="edit_day_count_id">
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Employee') }}</label>
                            <input type="text" class="form-control" id="edit_employee_name" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Year-Month') }}</label>
                            <input type="text" class="form-control" id="edit_year_month" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Days Counted') }}</label>
                            <input type="number" class="form-control" id="edit_day_count" name="day_count" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Days Paid') }}</label>
                            <input type="number" class="form-control" id="edit_day_paid" name="day_paid" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Remarks') }}</label>
                            <textarea class="form-control" id="edit_remarks" name="remarks"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ localize('Status') }}</label>
                            <select class="form-control" id="edit_status" name="status">
                                <option value="1">Full</option>
                                <option value="2">Partial</option>
                                <option value="3">Partial Joining</option>
                                <option value="4">Stop</option>
                                <option value="5">On Probation</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ localize('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ localize('Save Changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            let table = $('#dayCountTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('payroll.dayCount.list') }}",
                "columns": [
                    { "data": "id" },
                    { "data": "employee_name" },
                    { "data": "payroll_id" },
                    { "data": "year_month" },
                    { "data": "day_count" },
                    { "data": "day_paid" },
                    { "data": "status" },
                    { "data": "actions", "orderable": false, "searchable": false }
                ]
            });

            // Open edit modal and load data
            $(document).on('click', '.edit-btn', function () {
                let id = $(this).data('id');

                $.get("{{ url('salary-payroll/payroll/day-count/edit') }}/" + id, function (data) {
                    $('#edit_day_count_id').val(data.id);
                    $('#edit_employee_name').val(data.employee_name);
                    $('#edit_year_month').val(data.year_month);
                    $('#edit_day_count').val(data.day_count);
                    $('#edit_day_paid').val(data.day_paid);
                    $('#edit_remarks').val(data.remarks);
                    $('#edit_status').val(data.status);
                    $('#editDayCountModal').modal('show');
                }).fail(function () {
                    alert("Error fetching data.");
                });
            });

            // Submit edit form
            $('#editDayCountForm').submit(function (e) {
                e.preventDefault();
                let id = $('#edit_day_count_id').val();
                let formData = $(this).serialize();

                $.post("{{ url('salary-payroll/payroll/day-count/update') }}/" + id, formData, function (response) {
                    $('#editDayCountModal').modal('hide');
                    table.ajax.reload();
                    alert(response.success);
                }).fail(function (xhr) {
                    alert("Error updating data: " + xhr.responseJSON.message);
                });
            });
        });
    </script>

@endsection
