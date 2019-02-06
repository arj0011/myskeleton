<?php

namespace App\DataTables;

use App\Post;
use Builder;
use Auth;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;

class PostsDataTable extends DataTable
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
            ->editColumn('banner_image',function(Post $post){
                return '<img src="'.$post->banner_image.'" height="30" width="30" />';
            })
            ->addColumn('action', function(Post $post){
                return '<a href="'.url('posts.edit'.encrypt($post->id)).'" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                          <a href="javascript:void(0);" data-post_id="'.encrypt($post->id).'" class="btn btn-sm btn-danger deletePost"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['content','banner_image','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Post $model)
    {        
        $posts = Post::where('user_id',Auth::user()->id)->get();        
        return $this->applyScopes($posts);

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
                            4, // here is the column number
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
            'title',
            'content',
            'banner_image',
            'created_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Posts_' . date('YmdHis');
    }
}
