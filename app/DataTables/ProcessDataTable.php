<?php

namespace App\DataTables;
 
use App\Model\Releaseorder;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProcessDataTable extends DataTable
{
     

    protected $dataTableVariable = 'processDataTable';

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

            })->editColumn('Customer', function($query){ 

                return Str::limit($query->Customer,30);

            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Process $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {

         $process = Releaseorder::whereIn('releasetfi.status',[ '01','99','00'])
                ->join('release_items', 'release_items.releasetfi_id', '=', 'releasetfi.id')
                ->join('releaseprocess', 'releaseprocess.id', '=', 'release_items.releaseprocess_id')
                ->groupby(['releasetfi.docno', 'releasetfi.Customer', 'releaseprocess.deliver_date', 'releaseprocess.ro_no'])
                ->select('releasetfi.docno', 'releasetfi.Customer', 'releaseprocess.deliver_date', 'releaseprocess.ro_no', DB::raw('sum(Amount) as total'))
                ->orderByDesc('releasetfi.id');

        return ($process);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('process-table')
                    // ->columns($this->getColumns())
                    ->columns([
                        'docno' => [ 'title' => 'Doc. #'],
                        'Customer' => [ 'title' => 'Name' ],
                        'deliver_date' => [ 'title' => 'Delivery Date','class'=>'text-center','name' => 'releaseprocess.deliver_date' ],
                        'ro_no' => [ 'title' => 'RO. #' ,'class'=>'text-center','name' => 'releaseprocess.ro_no' ],
                        'total' => [ 'title' => 'Total&nbsp;','class'=>'text-right' ,'searchable'=> false ]
                    ])
                    ->minifiedAjax()
                    ->pageLength(15)
                    ->dom('Bfrtip')
                    ->orderBy(1) 
                    ->fixedColumns(2)
                    ->buttons(
                       
                        'reset',
                        'reload',
                        [
                            'extend'  => 'collection',
                            'text'    => '<i class="fa fa-download"></i> Export',
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
                    ->exportable(false)
                  ->printable(false)
                //   ->width(60)
                  ->addClass('text-left'),
            // Column::make('docno'),
            Column::make('Customer'),
            Column::make('deliver_date')
                  ->addClass('text-center'),
            Column::make('ro_no')
                  ->addClass('text-center'),
            Column::make('total')
                ->addClass('text-right'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Process_' . date('YmdHis');
    }
}
