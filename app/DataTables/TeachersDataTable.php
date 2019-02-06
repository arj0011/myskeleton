<?php

namespace App\DataTables;

use App\User;
use DB;
use Builder;
use Auth;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;

class TeachersDataTable extends DataTable
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
            ->editColumn('status', function(User $user){
                if($user->status == 1)
                return '<label class="label label-success">Active</label>';
                else return '<label class="label label-danger">Deactive</label>';
            })
            ->editColumn('created_at', function(User $user){
                return date('d-m-Y H:i:s',strtotime($user->created_at));
            })

            ->editColumn('checkbox', function(User $user){
                $chk = '';
                if(Auth::user()->can('Delete User'))
                    $chk = '<input type="checkbox" data-id="'.$user->id.'" class="sub_chk" name="ids[]" />';
                return $chk;
            })
            ->addColumn('action', function(User $user){
                $actionBtn='';
                if(Auth::user()->can('View Teacher')){
                    $actionBtn = '<a href="javascript:void(0);" data-user_id="'.encrypt($user->id).'" class="btn btn-sm btn-default viewUser"><i class="fa fa-eye"></i></a>&nbsp;';
                }
                if(Auth::user()->can('Edit Teacher')){
                    $actionBtn .= '<a href="'.url('admin/editTeacher/'.encrypt($user->id)).'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if(Auth::user()->can('Delete Teacher')){
                    $actionBtn .= '<a href="javascript:void(0);" data-user_id="'.encrypt($user->id).'" class="btn btn-sm btn-danger deleteUser"><i class="fa fa-trash"></i></a>';
                }  
                return $actionBtn;
            })
            //View Approach
            // ->addColumn('action', function(User $user) {
            //     return view('backend.users.usersaction', compact('user'))->render();
            // })
            ->rawColumns(['checkbox','status','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {

        $users = User::select('id','name','email','status', 'created_at', 'updated_at');
        if($this->request()->get('startDate')) {
            $st = $this->request()->get('startDate');
            $dt = ($this->request()->get('endDate') == '') ? date('Y-m-d') : $this->request()->get('endDate');
            $users->whereDate('created_at','<=', "$dt");
            $users->whereDate('created_at','>=', "$st");
        }
        if($this->request()->get('status') == '0' || $this->request()->get('status') == '1') {
            $users->where('status', $this->request()->get('status'));
        }
        $users->where('role',3)
       // $users->orderBy('created_at','DESC')             
       ->get();

       return $this->applyScopes($users);

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
                    ->addCheckbox(['width'=> '10px'],true)
                    ->parameters($this->getBuilderParameters())
                    ->parameters([
                        'order' => [
                            5, // here is the column number
                            'desc'
                        ],
                        // 'scrollX' => true,
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
            'email',
            'status',
            'created_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Teachers_' . date('YmdHis');
    }
}
