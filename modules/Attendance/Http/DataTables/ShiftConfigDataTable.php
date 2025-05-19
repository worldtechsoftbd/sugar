<?php

namespace App\DataTables;


use Modules\Attendance\Entities\Shift;
use Yajra\DataTables\Services\DataTable;

class ShiftConfigDataTable extends DataTable
{
    /**
     * DataTable Query
     *
     * @param Shift $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Shift $model)
    {
        return $model->newQuery()->with('department');
    }

    /**
     * Build the DataTable class.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('department', function ($shift) {
                return $shift->department->name ?? __('All Departments');
            })
            ->addColumn('status', function ($shift) {
                return view('backend.partials.status_badge', ['status' => $shift->status]);
            })
            ->addColumn('actions', function ($shift) {
                return view('backend.partials.actions', ['shift' => $shift]);
            })
            ->rawColumns(['status', 'actions']);
    }

    /**
     * Get the table's HTML builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('shift-config-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->buttons([
                'export',
                'print',
                'reset',
                'reload',
            ]);
    }

    /**
     * Define columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'id', 'name' => 'id', 'title' => '#'],
            ['data' => 'shift_name', 'name' => 'shift_name', 'title' => __('Shift Name')],
            ['data' => 'start_time', 'name' => 'start_time', 'title' => __('Start Time')],
            ['data' => 'end_time', 'name' => 'end_time', 'title' => __('End Time')],
            ['data' => 'late_time', 'name' => 'late_time', 'title' => __('Late Time')],
            ['data' => 'grace_period', 'name' => 'grace_period', 'title' => __('Grace Period')],
            ['data' => 'department', 'name' => 'department.name', 'title' => __('Department')],
            ['data' => 'status', 'name' => 'status', 'title' => __('Status')],
            ['data' => 'actions', 'name' => 'actions', 'title' => __('Actions'), 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ShiftConfig_' . date('YmdHis');
    }
}
