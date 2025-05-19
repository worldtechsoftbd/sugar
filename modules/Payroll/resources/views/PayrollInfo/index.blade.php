@extends('backend.layouts.app')

@section('title', 'Payroll Information')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">{{ localize('Payroll Information') }}</h4>
            <a href="{{ route('payroll.create') }}" class="btn btn-primary btn-sm">{{ localize('Add New Payroll') }}</a>
            <a href="{{ route('payroll.paymentSetup') }}" class="btn btn-primary btn-sm">{{ localize('Add New Salary') }}</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-hover table-bordered" id="payrollTable">
                    <thead class="table-light">
                    <tr>
                        <th>{{ localize('ID') }}</th>
                        <th>{{ localize('Employee') }}</th>
                        <th>{{ localize('Payroll ID') }}</th>
                        <th>{{ localize('Remarks') }}</th>
                        <th class="text-center">{{ localize('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payrolls as $payroll)
                        <tr>
                            <td>{{ $payroll->id }}</td>
                            <td>{{ $payroll->employee->first_name }}</td>
                            <td>{{ $payroll->payrollId }}</td>
                            <td>{{ $payroll->remarks }}</td>
                            <td class="text-center">
                                <a href="{{ route('payroll.edit', $payroll->id) }}" class="btn btn-sm btn-info">{{ localize('Edit') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#payrollTable').DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "pageLength": 10,
                "language": {
                    "search": "{{ localize('Search') }}",
                    "paginate": {
                        "first": "{{ localize('First') }}",
                        "last": "{{ localize('Last') }}",
                        "next": "{{ localize('Next') }}",
                        "previous": "{{ localize('Previous') }}"
                    }
                }
            });
        });
    </script>
@endsection