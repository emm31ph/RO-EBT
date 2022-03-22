<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DeliveryExport implements FromView, WithEvents, WithStyles
{
    public $view;
    public $data;
    public function __construct($view, $data = "")
    {
        $this->view = $view;
        $this->data = $data;
    }
    public function view(): View
    {
        return view($this->view, ['data' => $this->data]);
    }

     public function styles(Worksheet $sheet)
    {
 

        $data = [];
            $cnt = 2;

                $cnt += (request()->get('inputArea') != null) ? 1 : 0;
                $cnt += (request()->get('inputDriver') != null) ? 1 : 0;
                $cnt += (request()->get('status') != null) ? 1 : 0;
                $cnt += (request()->get('from_date') != null) ? 1 : 0;
                $cnt += (request()->get('submit') != 'excel') ? 1 : 0;
                
                for ($i = 0; $i <= $cnt; $i++) {
                    $data[] = ['font' => ['bold' => true]];
                } 

        return $data;

            // // Style the first row as bold text.
            // 1    => ['font' => ['bold' => true]],

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ;
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // $event->sheet->getStyle('A2:W2')->applyFromArray([
                //     'font' => [
                //         'bold' => true,
                //     ],
                // ]);
                $cnt = 1;

                $cnt += (request()->get('inputArea') != null) ? 1 : 0;
                $cnt += (request()->get('inputDriver') != null) ? 1 : 0;
                $cnt += (request()->get('status') != null) ? 1 : 0;
                $cnt += (request()->get('from_date') != null) ? 1 : 0;
                $cnt += (request()->get('submit') != 'excel') ? 1 : 0;
 
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(14);
                // $event->sheet->getStyle('A1')
                $event->sheet->getDelegate()->getStyle('A1')->ApplyFromArray(
                    ['alignment' => array(
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                        , 'font' => ['bold' => true],

                        
                    ]

                );

                $event->sheet->getDelegate()->getStyle('A1:A1000')->ApplyFromArray(
                    ['alignment' => array(
                        // 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    )]

                );

                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(10);
               

                if((request()->get('submit')!='excel'))
                {
                 $event->sheet->getDelegate()->getStyle('I1:I1000')->ApplyFromArray(
                    ['alignment' => array(
                        // 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    )]

                );
                
                // $event->sheet->getDelegate()->getStyle('E1:E1000')->ApplyFromArray(
                //     ['alignment' => array(
                //         // 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                //     )]

                // );
                // $event->sheet->getDelegate()->getStyle('I1:J1000')->ApplyFromArray(
                //     ['alignment' => array(
                //         // 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                //     )]

                // );
                
                // $event->sheet->getDelegate()->getStyle('H1:H1000')->ApplyFromArray(
                //     ['alignment' => array(
                //         // 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                //         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
                //     )]

                // );
                
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(10);
                //  $event->sheet->getDelegate()->setColumnFormat(['A' => '0.00',]);
            }
            },
        ];
    }

}
