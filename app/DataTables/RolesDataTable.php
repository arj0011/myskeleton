<?php

namespace App\DataTables;

use Spatie\Permission\Models\Role;
use Builder;
use Auth;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;

class RolesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('permission',function(Role $role){
                return (str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')));
            })
            ->addColumn('action', function(Role $role){
                return '<a href="'.url('admin/edit-role/'.encrypt($role->id)).'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                          <a href="javascript:void(0);" data-role_id="'.encrypt($role->id).'" class="btn btn-sm btn-danger deleteRole"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
    {        
        $roles = Role::all();        
        return $this->applyScopes($roles);

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '10%'])
                    ->parameters($this->getBuilderParameters())
                    ->parameters([
                        'order' => [
                            1, // here is the column number
                            'asc'
                        ],
                        'extend'  => 'collection',
                        'text'    => 'Export',
                        'dom'     => 'Bfrtipl',
                        // 'buttons' =>  ['csv', 'excel', 'pdf' , 'print'],
                        // 'initComplete' => "function () {
                        //     this.api().columns().every(function () {
                        //         var column = this;
                        //         var input = document.createElement(\"input\");
                        //         $(input).appendTo($(column.footer()).empty())
                        //         .on('change', function () {
                        //             column.search($(this).val(), false, false, true).draw();
                        //         });
                        //     });
                        // }",
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'DT_RowIndex'=>['width'=>'10px','title'=>'S.No','searchable'=>false,'orderable'=>false],
            'name',
            'permission'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Roles_' . date('YmdHis');
    }
}
