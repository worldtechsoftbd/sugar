<?php
namespace Modules\HumanResource\DataTables;

use Modules\HumanResource\Entities\EmployeeLeaveBalance;
use Yajra\DataTables\Services\DataTable;

class LeaveBalanceDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-warning">Edit</button>';
            });
    }

    public function query(EmployeeLeaveBalance $model)
    {
        return $model->newQuery()->select('id', 'emp_id', 'leave_type_id', 'leave_balance');
    }

    public function html()
    {
        return $this->builder()
            ->columns([
                'emp_id' => 'Employee ID',
                'leave_type_id' => 'Leave Type',
                'leave_balance' => 'Leave Balance',
                'action' => 'Actions'
            ])
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['csv', 'excel', 'pdf'],
                'initComplete' => 'function () {this.api().columns().every(function () {var column = this;});}',
            ]);
    }
}
