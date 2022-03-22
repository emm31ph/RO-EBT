<?php

namespace App\Http\Controllers\Reports;

use App\Model\ReportItems;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
     

    public function index()
    {
         
       $datas = ReportItems::sortable()
       ->select('header1','header2','header3','itemcode','type','id')
       ->paginate(15);

        return view('manage.report.index')->withDatas($datas);
    }

    public function create()
    { 
         
        return view('manage.report.create');
    }

      public function store(Request $request)
    {
        
        $ReportItems = ReportItems::updateOrCreate(
             ['itemcode' => $request->itemcode],

             [
                'itemcode' => $request->itemcode,
                'header1' => $request->header,
                'header2' => $request->subheader,
                'header3' => $request->itemheader,
                'type' => $request->section, 
                ]
         );


        if(!$ReportItems->wasRecentlyCreated && $ReportItems->wasChanged()){
        return redirect()->route('report.index')->withToastSuccess('Successfully update report item.');
        }

        if(!$ReportItems->wasRecentlyCreated && !$ReportItems->wasChanged()){
            return redirect()->route('report.index')->withToastSuccess('nothing changes report item.');
        }

        if($ReportItems->wasRecentlyCreated){
        return redirect()->route('report.index')->withToastSuccess('Successfully create report item.');
        }

        
    }
    public function edit($id)
    {  
        $reportitem = ReportItems::findOrFail($id);
        
        return view('manage.report.edit')->withData($reportitem);
    }
    public function show($id)
    { 
    
    }

    public function update(Request $request, $id)
    {
         
    }

    public function destroy($id)
    {
        ReportItems::destroy($id);
    }
}
