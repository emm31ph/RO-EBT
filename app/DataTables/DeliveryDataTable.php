<?php

namespace App\DataTables;

use App\Model\ReleaseProcess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DeliveryDataTable extends DataTable implements ShouldAutoSize
{

    protected $actions = ['print', 'csv', 'excel', 'pdf'];
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
            ->addIndexColumn()
            ->filter(function ($query) {

                $query->whereRaw("IF('" . request()->get('from_date')
                    . "'='',''='',deliver_date between '" . request()->get('from_date') . "' and '" . request()->get('to_date') . "' )")
                    ->whereRaw("IF('" . request()->get('status')
                    . "'='',''='',releaseprocess.status ='" . request()->get('status') . "' )")
                    ->whereRaw("IF('" . request()->get('area')
                    . "'='',''='',releaseprocess.area ='" . request()->get('area') . "' )")
                    ->whereRaw("IF('" . request()->get('driver')
                    . "'='',''='',releaseprocess.driver ='" . request()->get('driver') . "' )");

            })
            ->editColumn('ro_no', function ($query) {
                $btn = '<a href="' . route('release.print', $query->ro_no) . '" target="_blank">' . $query->ro_no . '</a>';
                return $btn;
            })
            ->addColumn('action', function ($query) {
                $btn = '';
                if ($query->status != 'cancel') {
                    if (Auth::user()->hasPermission(['release-update'])) {
                        $btn = '<a href="' . route('ro.edit', $query->ro_no) . '" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                    </a>  ';
                    }
                }
                if ($query->status != 'cancel') {
                    if (Auth::user()->hasPermission(['release-delete'])) {
                        $btn = $btn . '<a href="javascript:;" data-toggle="modal" class="d-cancel btn btn-danger btn-sm" data-id="' . $query->id . '" data-target="#exampleModalCenter" ><i class="fa fa-trash"></i></a>';
                    }
                }
                return $btn;
            })->editColumn('status', function ($query) {

            return ($query->status == 'cancel') ? '<span class="badge badge-warning">Cancel</span>' : '';
        })->filterColumn('status', function ($query, $keyword) {
            $query->whereRaw("case (releaseprocess.status) when '99' then 'cancel' when '00' then 'active' end like ?", ["%{$keyword}%"]);
        })
            ->rawColumns(['action', 'ro_no', 'status'])

        ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Delivery $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $process = ReleaseProcess::whereIn('releasetfi.status', ['01', '99'])
            ->join('release_items', 'release_items.releaseprocess_id', '=', 'releaseprocess.id')
            ->join('releasetfi', 'releasetfi.id', '=', 'release_items.releasetfi_id')
            ->groupby(['releaseprocess.ro_no', 'releaseprocess.area', 'releaseprocess.plate', 'releaseprocess.truckno', 'releaseprocess.driver', 'releaseprocess.deliver_date', 'releaseprocess.status', 'releaseprocess.id',
            ])
            ->select(['releaseprocess.ro_no', 'releaseprocess.area', 'releaseprocess.plate', 'releaseprocess.truckno', 'releaseprocess.driver', 'releaseprocess.deliver_date', 'releaseprocess.id'
                , DB::raw("case (releaseprocess.status) when '99' then 'cancel' when '00' then 'active' end as status")])
            ->orderByDesc('id');

        return $process;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */

    public function html()
    {
        return $this->builder()
            ->setTableId('delivery-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->pageLength(15)
            ->dom('<"top"><"bottom"rtip><"clear">')
            ->orderBy(1)
            ->fixedColumns(2)
           ->parameters([
                'buttons'      => []

        ]) 
        ;
    }

   

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            // 'ro_no' => [ 'title' => 'RO. #' ,'class'=>'text-center','name' => 'releaseprocess.ro_no' ],

            Column::make('ro_no')
                ->class('text-center')
                ->title('RO. #')
            ,
            Column::make('area'),
            Column::make('driver'),
            Column::make('truckno')
                ->title('Truck #')
                ->class('text-center'),
            Column::make('plate')
                ->title('Plate #')
                ->class('text-center'),
            Column::make('deliver_date')
                ->class('text-center'),
            Column::make('status')
                ->name('status')
                ->class('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->class('text-right')
                ->printable(false),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Delivery_' . date('YmdHis');
    }

}
