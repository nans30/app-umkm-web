<?php

namespace App\DataTables;

use App\Models\Category;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class CategoryDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', fn($row) => 
                '<input class="form-check-input file-item-check" type="checkbox" value="' . $row->id . '">'
            )

            ->editColumn('name', fn($row) => ucfirst($row->name))

            ->editColumn('type', fn($row) => 
                $row->type === 'income' 
                    ? '<span class="badge bg-success">Income</span>' 
                    : '<span class="badge bg-danger">Expense</span>'
            )

            ->addColumn('creator', fn($row) => 
                $row->creator?->name ?? '<em>Unknown</em>'
            )

            ->editColumn('created_at', fn($row) => 
                $row->created_at?->diffForHumans()
            )

            ->addColumn('action', function ($row) {
                $editUrl = route('admin.category.edit', $row->id);
                $deleteUrl = route('admin.category.destroy', $row->id);

                return '
                    <a href="' . $editUrl . '" class="btn btn-light btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" title="Edit">
                        <i class="ti ti-edit fs-lg"></i>
                    </a>
                    <a href="javascript:void(0)" data-id="' . $row->id . '" data-url="' . $deleteUrl . '" class="btn btn-light btn-icon btn-sm rounded-circle deleteBtn" data-bs-toggle="tooltip" title="Delete">
                        <i class="ti ti-trash fs-lg"></i>
                    </a>
                ';
            })

            ->rawColumns(['checkbox', 'type', 'creator', 'action']);
    }

    public function query(Category $model): QueryBuilder
    {
        // Join dengan user agar bisa ambil nama pembuat kategori
        return $model->newQuery()->with('creator');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('category-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->setTableAttribute('class', 'table table-striped dt-responsive align-middle mb-0')
            ->parameters([
                'pageLength' => 10,
                'lengthChange' => false,
                'searching' => true,
                'language' => [
                    'emptyTable' => 'No records found',
                    'zeroRecords' => 'No matching records found',
                ],
                'dom' => "<'row'<'col-sm-12'tr>>" .
                         "<'row'<'col-sm-5'i><'col-sm-7 d-flex justify-content-end'p>>",
                'drawCallback' => 'function() {
                    feather.replace();
                    $(".deleteBtn").tooltip();
                }',
                'initComplete' => 'function() {
                    $(".dataTables_filter").appendTo(".search-input");
                }',
            ]);
    }

    protected function getColumns(): array
    {
        return [
            [
                'data' => 'checkbox',
                'title' => '<input type="checkbox" data-table-select-all class="form-check-input">',
                'orderable' => false,
                'searchable' => false,
                'escape' => false
            ],
            ['data' => 'name', 'title' => 'Category Name'],
            ['data' => 'type', 'title' => 'Type', 'escape' => false],
            ['data' => 'creator', 'title' => 'Created By', 'orderable' => false, 'searchable' => false, 'escape' => false],
            ['data' => 'created_at', 'title' => 'Created At'],
            ['data' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }
}