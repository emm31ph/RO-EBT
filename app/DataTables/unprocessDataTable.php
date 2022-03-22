<?php

namespace App\DataTables;

use App\App\unprocess;
use App\Model\Releaseorder;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class unprocessDataTable extends DataTable
{
    
    protected $dataTableVariable = 'unprocessDataTable';
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    { 
        return datatables()
            ->eloquent($query)
            ->editColumn('docno', function($query){
                $btn = '<a href="'.route('ro.show',$query->docno) .'">'. $query->docno .'</a>';
                return $btn;
            })->rawColumns(['docno'])
            ->editColumn('total', function($query){ 
                return number_format($query->total,2);
            })
            ->editColumn('Customer', function($query){
                return Str::limit($query->Customer,30);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\unprocess $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $unprocess = Releaseorder::whereIn('releasetfi.status', ['00'])
                ->groupby(['docno', 'Customer', 'Date'])
                ->select('docno', 'Customer', 'Date', DB::raw('sum(Amount) as total'))
                // ->select('docno', 'Customer', 'Date')
                ;
        return $unprocess;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('unprocess-table') 
                    ->pageLength(15)
                    // ->columns($this->getColumns())
                    ->columns([
                        'docno' => [ 'title' => 'Doc. #' ],
                        'Customer' => [ 'title' => 'Name' ],
                        'Date' => [ 'title' => 'Date Create','class'=>'text-center' ], 
                        // 'total' => [ 'title' => 'Total&nbsp;','class'=>'text-right' ,'searchable'=> false ]
                    ])
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                      ->buttons(
                'reset',
                'reload',
                [
                    'extend' => 'collection',
                    'text' => '<i class="fa fa-download"></i> Export',
                    'buttons' => [
                        'csv',
                        'excel',
                        // 'pdf',
                    ],
                ]
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
                Column::make('docno')
                    ->exportable(true)
                    ->searchable(true)
                  ->printable(true)
                  ->orderable(true)
                //   ->width(60)
                  ->addClass('text-left'),
            // Column::make('docno'),
            Column::make('Customer'),
            Column::make('Date')
                  ->addClass('text-center'),
            // Column::make('total')  , 
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'unprocess_' . date('YmdHis');
    }
}
