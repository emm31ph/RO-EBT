<?php

namespace App\Exports;

use App\Model\Releaseorder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UnprocessExport implements FromCollection,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
             $unprocess = Releaseorder::where('releasetfi.status', '00')
                ->groupby(['docno', 'Customer', 'Date'])
                ->select('docno', 'Customer', 'Date', DB::raw('sum(Amount) as total'))
                ->get();
        return $unprocess;
        
    }

     public function headings(): array
    {
        return [
            'Document Number',
            'Customer',
            'Date Created',
            'Total',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                
                $event->sheet->getDelegate()
                ->getStyle($cellRange)
                // ->setStyle(array(
                //         'font' => array(
                //             'name'      =>  'Calibri',
                //             'size'      =>  14,
                //             'bold'      =>  true
                //         )
                //     ))
                ->getFont()
                ->setSize(14);
                ;
            },
        ];
    }


}
