<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Reports\Reportheader;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReportheaderRequest;

class ReportheaderController extends Controller
{
    public function index()
    { 
        $reportheaders = Reportheader::paginate(10);
        return view('reportheader.index')->withreportheaders($reportheaders);
        
    }


    public function create()
    {
        return view('reportheader.create-js');
    
    }

    public function createItems()
    {
        $rec = DB::table('reportheaders as r1')
        ->leftJoin('reportheaders as r2','r2.id','r1.parents')
        ->leftJoin('reportheaders as r3','r3.id','r2.parents')
        ->select('r3.header as header1', 'r2.header as header2', 'r1.header as items', 'r1.id')
        ->where('r1.report_item','like','%102')
        ->get();
        
        return view('reportheader.create-items')->withRec($rec);
    
    }
    public function storeItems(ReportheaderRequest $request)
    { 


          foreach ($request->code as $key => $value) {
            $data = array('reportheaders_id'=>$key, 'content'=>$value,'code'=>$request->codedata[$key]);
             
             DB::table('reportitems')->insert( $data);
          }
        //   return redirect()->route('reportheader.index')->with('success', 'successfully insert new Report items');;
    }
    public function store(ReportheaderRequest $request)
    {
 
        $variable = ($request->all());
       echo "<pre>";
        dd($variable);
    //    for($q=0; $q<35; $q++){
    //     echo $request->header[$q].' '.$request->subheader[$q].'1<br>';

    //    }
    //    foreach($request->header as $data){
    //        echo $data.'1<br>';
    //    }
        

        die();
        // foreach ($variable as $value) {
            
        //      DB::table('reportheaders')->insert(array(
        //          'header' => $value->header ,
        //          'rowspan' => $value->rowspan,
        //          'colspan' => $value->colspan,
        //          'report_item' => sprintf('%05d', 100+($request->reportheader))
        //         )); 
              
        // }  
        // return redirect()->route('reportheader.index')->with('success', 'successfully insert new Reportheader');;
    }

    public function edit($id)
    {
        $reportheader = Reportheader::findOrFail($id);
        return view('reportheader.edit')->withreportheader($reportheader);
        
    }
    public function show($id)
    {
        $reportheader = Reportheader::findOrFail($id);

          return view('reportheader.show')->withreportheader($reportheader);
        
    
    }

    public function update(ReportheaderRequest $request, $id)
    {
        $reportheader = Reportheader::findOrFail($id);
        $reportheader->update($request->all());
        
        return redirect()->route('reportheader.index')->withToastSuccess('Successfully update Reportheader.');
       
    }

    public function destroy($id)
    {
        Reportheader::destroy($id);

         return redirect()->route('reportheader.index')->withToastWarning('Successfully delete Reportheader.');
       
    }
}