<?php

namespace Modules\Accounts\Http\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\Accounts\Entities\AccSubtype;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SubtypeDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge bg-success">' . localize('active') . '</span>';
                } else {
                    return '<span class="badge bg-danger">' . localize('inactive') . '</span>';
                }
            })
            ->addColumn('action', function ($row) {

                $button = '';
                $button .= '<div class="btn-group">';
                if (auth()->user()->can('update_subtype')) {
                    $button .= '<a href="#" class="btn btn-primary-soft btn-sm me-1 edit-subtype" data-url="' . route('subtypes.edit', $row->id) . '" title="Edit"><i class="fa fa-edit"></i></a>';
                }
                if (auth()->user()->can('delete_subtype')) {
                    if ($row->id > 3) {
                        $button .= '<a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm" data-bs-toggle="tooltip" title="Delete" data-route="' . route('subtypes.destroy', $row->uuid) . '" data-csrf="' . csrf_token() . '"><i class="fa fa-trash"></i></a>';
                    }
                }

                $button .= '</div>';
                return $button;
            })

            ->rawColumns(['status', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(AccSubtype $model): QueryBuilder
    {
        return $model->newQuery()
            ->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('purchase-return-table')
            ->setTableAttribute('class', 'table table-hover table-bordered align-middle')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->language([
                'processing' => '<div class="lds-spinner">
                <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
            ])
            ->selectStyleSingle()
            ->dom("<'row mb-3'<'col-md-4'l><'col-md-4 text-center'B><'col-md-4'f>>rt<'bottom'<'row'<'col-md-6'i><'col-md-6'p>>><'clear'>")
            ->buttons([]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {

        return [
            //addIndexColumn is added here
            Column::make('DT_RowIndex')
                ->title(localize('sl'))
                ->addClass('text-center column-sl')
                ->searchable(false)
                ->orderable(false)
                ->width(10),
            Column::make('subtype_name')
                ->title(localize('subtype_name'))
                ->searchable(true),
            Column::make('status')
                ->title(localize('status'))
                ->addClass('text-center')
                ->width(100)
                ->searchable(true),
            Column::make('action')
                ->title(localize('action'))->addClass('column-sl')->orderable(false)
                ->addClass('text-start')
                ->width(50)
                ->searchable(false)
                ->printable(false)
                ->exportable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Purchase_Return_' . date('YmdHis');
    }
}
