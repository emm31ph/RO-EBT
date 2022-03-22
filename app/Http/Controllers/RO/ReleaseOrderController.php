<?php

namespace App\Http\Controllers\RO;

use App\DataTables\DeliveryDataTable;
use App\DataTables\ProcessDataTable;
use App\DataTables\unprocessDataTable;
use App\Exports\DeliveryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReleaseOrderRequest;
use App\Http\Requests\ReleaseOrderUpdate;
use App\Model\ReleaseItems;
use App\Model\Releaseorder;
use App\Model\ReleaseProcess;
use App\Model\Signatories;
use App\Model\Trucker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReleaseOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $counts = [
            'undelivered' => Releaseorder::where('status', '00')->distinct('docno')->count(),
            'process' => Releaseorder::whereIn('status', ['01', '99'])->distinct('docno')->count(),
            'delivered' => ReleaseProcess::whereIn('status', ['01', '99'])->count(),
            // And so on
        ];

        if (Auth::user()->hasPermission(['release-read'])) {
            return view('releaseorder.releaseorder.index')->withcounts($counts);
        } elseif (Auth::user()->hasPermission(['release-import'])) {
            return redirect()->route('release.import');
        } elseif (Auth::user()->hasPermission(['release-release order list'])) {
            return redirect()->route('release.list');
        } elseif (Auth::user()->hasPermission(['release-delivery list'])) {
            return redirect()->route('release.delivery');
        }
    }
    public function DeliveryCancel(Request $request)
    {
        $user = ReleaseProcess::findOrFail($request->id);

        $user->status = '99';
        $user->save();

        DB::table('releaseprocess')
            ->join('release_items', 'release_items.releaseprocess_id', '=', 'releaseprocess.id')
            ->join('releasetfi', 'releasetfi.id', '=', 'release_items.releasetfi_id')
            ->where('releaseprocess.id', $request->id)
            ->update(['releasetfi.status' => '99']);
        return back()->with('success', 'successfully cancel');
    }
    public function Deliverylist(DeliveryDataTable $unprocessDataTable)
    {

        return $unprocessDataTable->render('releaseorder.releaseorder.delivery');

    }
    function list(Request $request) {
        #region
        $q1 = $request->q1;
        if ($q1 != "") {

            $unprocess = Releaseorder::where(function ($query) use ($q1) {
                $query->where('releasetfi.status', '00')
                    ->where('docno', 'like', '%' . $q1 . '%')
                    ->orWhere('Customer', 'like', '%' . $q1 . '%');
            })
                ->groupby(['docno', 'Customer', 'Date'])
                ->select('docno', 'Customer', 'Date', DB::raw('sum(Amount) as total'))
                ->paginate(15, '*', 'unprocess');
            $unprocess->setPageName('unprocess');

        } else {

            $unprocess = Releaseorder::where('releasetfi.status', '00')
                ->groupby(['docno', 'Customer', 'Date'])
                ->select('docno', 'Customer', 'Date', DB::raw('sum(Amount) as total'))
                ->paginate(15, '*', 'unprocess');
            $unprocess->setPageName('unprocess');

        }

        $q = $request->q;
        if ($q != "") {
            $process = Releaseorder::where(function ($query) use ($q) {
                $query->whereIn('releasetfi.status', ['01', '99'])
                    ->where('docno', 'like', '%' . $q . '%')
                    ->orWhere('Customer', 'like', '%' . $q . '%')
                    ->orWhere('ro_no', 'like', '%' . $q . '%');
            }
            )
                ->join('release_items', 'release_items.releasetfi_id', '=', 'releasetfi.id')
                ->join('releaseprocess', 'releaseprocess.id', '=', 'release_items.releaseprocess_id')
                ->groupby(['docno', 'Customer', 'deliver_date', 'ro_no'])
                ->select('docno', 'Customer', 'deliver_date', 'ro_no', DB::raw('sum(Amount) as total'))
                ->orderByDesc('releasetfi.id')
                ->paginate(15, '*', 'process');

            $process->setPageName('process');
            $process->appends(['q' => $q]);
        } else {

            $process = Releaseorder::whereIn('releasetfi.status', ['01', '99'])
                ->join('release_items', 'release_items.releasetfi_id', '=', 'releasetfi.id')
                ->join('releaseprocess', 'releaseprocess.id', '=', 'release_items.releaseprocess_id')
                ->groupby(['docno', 'Customer', 'deliver_date', 'ro_no'])
                ->select('docno', 'Customer', 'deliver_date', 'ro_no', DB::raw('sum(Amount) as total'))
                ->orderByDesc('releasetfi.id')
                ->paginate(15, '*', 'process');

            $process->setPageName('process');
        }
        #endregion

        // dd($processDataTable);
        // return $processDataTable->render('releaseorder.releaseorder.list');

        return view('releaseorder.releaseorder.list');
    }

    public function listUnprocess(unprocessDataTable $unprocessDataTable)
    {
        return $unprocessDataTable->render('releaseorder.releaseorder.list-unprocess');
    }

    public function listProcess(ProcessDataTable $processDataTable)
    {

        return $processDataTable->render('releaseorder.releaseorder.list-process');
    }

    public function search(Request $request)
    {
        $posts = Releaseorder::where('PO_no', $request->keywords)->orWhere('docno', $request->keywords)
            ->groupby(['docno', 'Customer', 'PO_no', 'status'])
            ->select('docno', 'Customer', 'PO_no', 'status')
            ->first();

        if (!$posts && $request->keywords != null) {
            $posts = [['error' => 'no record found']];
        } elseif ($request->keywords == null) {
            $posts = [['required' => 'Invalid input']];
        }

        return response()->json($posts);
    }
    public function create()
    {
        if (!Auth::user()->hasPermission(['release-create'])) {
            return redirect()->back()->withToastWarning("unable to access");
        }

        $signatory = Signatories::where('type', '00001')->first();
        $utrucker = Trucker::pluck('fulltitle');
        $rono = DB::table('releaseprocess')->select(DB::raw('1+ro_no as ro_no'))->orderBy('id', 'desc')->first();
        $data = [
            'utrucker' => $utrucker,
            'signatories' => $signatory,
            'rono' => $rono,
        ];

        return view('releaseorder.releaseorder.create')->with($data);
    }

    public function store(ReleaseOrderRequest $request)
    {

        $truck = explode("-", $request->trucker);

        if (count($truck) == 1) {
            # return response()->json(['errors' => ['trucker' => ['Invalid trucker']]], 422);
            $truck[0] = "";
            $truck[1] = "";
        }

        $releaseorder = new ReleaseProcess();
        $releaseorder->ro_no = $request->rono;
        $releaseorder->deliver_date = $request->dateInput;
        $releaseorder->driver = $request->driver;
        if (count($truck) != 1) {
            $releaseorder->plate = $truck[1];
            $releaseorder->truckno = $truck[0];
        }
        $releaseorder->area = $request->area;
        $releaseorder->remarks = $request->remarks;
        $releaseorder->user_id = Auth::user()->id;
        $releaseorder->save();

        Signatories::updateOrCreate(
            ['type' => '00001'],
            ['type' => '00001',
                'signatory1' => $request->signa1,
                'signatory2' => $request->signa2]
        );

        $pono = json_decode($request->po_no);

        foreach ($pono as $po_no) {

            $posts = Releaseorder::where('PO_no', $po_no->product_no)->get();

            //////update status of release items
            DB::table('releasetfi')->whereIn('id', $posts->pluck('id'))->update(['status' => '01']);
            foreach ($posts as $post) {
                $rItems = new ReleaseItems();
                $rItems->releaseprocess_id = $releaseorder->id;
                $rItems->releasetfi_id = $post->id;
                $rItems->save();
                // ReleaseItems::updateOrCreate(['releaseprocess_id'=>$releaseorder->id],['releaseprocess_id'=>$releaseorder->id,'releasetfi_id'=>$post->id]);
            }
        }
        $msg = ['status' => 'ok'];
        return response()->json($msg);
        //$releaseorder = Releaseorder::create($request->all());

        //return redirect()->route('releaseorder.releaseorder.index')->with('success', 'successfully inser new Releaseorder');;
    }

    public function edit($ro)
    {

        if (!Auth::user()->hasPermission(['release-update'])) {
            return redirect()->back()->withToastWarning("unable to access");
        }

        // $items = Releaseorder::where('ro_no', $ro)
        //     ->groupby(['docno', 'Customer', 'PO_no', 'status'])
        //     ->select('docno', 'Customer', 'PO_no', 'status')
        //     ->first();

        $items = Releaseorder::where('releaseprocess.ro_no', $ro)
            ->where('report_item.type', '00001')
            ->join('release_items', 'release_items.releasetfi_id', '=', 'releasetfi.id')
            ->whereIn('releasetfi.status', ['01', '99'])
            ->join('releaseprocess', 'releaseprocess.id', '=', 'release_items.releaseprocess_id')
            ->join('report_item', 'report_item.itemcode', '=', 'releasetfi.U_STOCKCODE')
            ->groupby(['Po_no', 'Customer'])
            ->select('Po_no', 'Customer')
            ->get();

        $signatory = Signatories::where('type', '00001')->first();

        $details = DB::table('releaseprocess')->where('ro_no', $ro)->get();

        $utrucker = Trucker::pluck('fulltitle');
        $data = [
            'utrucker' => $utrucker,
            'details' => $details,
            'items' => $items,
            'signatories' => $signatory,
        ];

        return view('releaseorder.releaseorder.edit')->with($data);
    }

    public function itemslist($ro)
    {
        $items = Releaseorder::where('releaseprocess.ro_no', $ro)
            ->where('releasetfi.status', '01')
            ->join('release_items', 'release_items.releasetfi_id', '=', 'releasetfi.id')
            ->join('releaseprocess', 'releaseprocess.id', '=', 'release_items.releaseprocess_id')
            ->groupby(['Po_no', 'Customer'])
            ->select('Po_no as product_no', 'Customer as product_name')
            ->get();
        return response()->json($items);

    }
    public function show($ro)
    {
        if (!Auth::user()->hasPermission(['release-read'])) {
            return redirect()->back()->withToastWarning("unable to access");
        }
        $releaseorder = Releaseorder::where('docno', $ro)->get();

        return view('releaseorder.releaseorder.show')->withreleaseorder($releaseorder);
    }

    public function update(ReleaseOrderUpdate $request, $id)
    {

    }
    public function updateList(ReleaseOrderUpdate $request)
    {

        $truck = explode("-", $request->trucker);

        if (count($truck) == 1) {
            #return response()->json(['errors' => ['trucker' => ['Invalid trucker']]], 422);
            $truck[0] = "";
            $truck[1] = "";

        }

        $releaseorder = ReleaseProcess::updateOrCreate(
            ['ro_no' => $request->rono],
            ['ro_no' => $request->rono,
                'deliver_date' => $request->dateInput,
                'driver' => $request->driver,

                'plate' => $truck[1],
                'truckno' => $truck[0],

                'area' => $request->area,
                'remarks' => $request->remarks,
                'user_id' => Auth::user()->id]
        );

        Signatories::updateOrCreate(
            ['type' => '00001'],
            ['type' => '00001',
                'signatory1' => $request->signa1,
                'signatory2' => $request->signa2]
        );
        $pono = json_decode($request->po_no);
        $rp_id = '';
        $items = Releaseorder::where('releaseprocess.ro_no', $request->rono)
            ->join('release_items', 'release_items.releasetfi_id', '=', 'releasetfi.id')
            ->join('releaseprocess', 'releaseprocess.id', '=', 'release_items.releaseprocess_id')
            ->select('releaseprocess.id  as rp_id', 'release_items.releasetfi_id', 'releasetfi.PO_no')
            ->get();
        $po_no1 = [];
        foreach ($items as $item) {
            $rp_id = $item->rp_id;
            $po_no1[$item->PO_no] = $item->PO_no;
            DB::table('releasetfi')->where('Po_no', $item->PO_no)->update(array('status' => '00'));
        }

        $po_no2 = [];
        if ($rp_id != null) {
            foreach ($pono as $po_no) {
                $po_no2[$po_no->product_no] = $po_no->product_no;
                $posts = Releaseorder::where('PO_no', $po_no->product_no)->get();

                //////update status of release items
                DB::table('releasetfi')->whereIn('id', $posts->pluck('id'))->update(['status' => '01']);
                foreach ($posts as $post) {
                    ReleaseItems::firstOrCreate(
                        ['releaseprocess_id' => $rp_id, 'releasetfi_id' => $post->id],
                        ['releaseprocess_id' => $rp_id, 'releasetfi_id' => $post->id]
                    );

                }
            }
        }

        $arr = array_diff(array_unique($po_no1), array_unique($po_no2));

        DB::table('release_items')
            ->leftJoin('releasetfi', 'release_items.releasetfi_id', '=', 'releasetfi.id')
            ->whereIn('releasetfi.PO_no', array_keys($arr))->delete();

        return response()->json($arr, 201);

    }

    public function destroy($id)
    {
        $v = explode(",", $id);

        switch ($v[1]) {
            case 'delete':
                Releaseorder::where('docno', $v[0])->delete();

                break;
            case 'cancel':
                $release = Releaseorder::where('docno', $v[0])->update(array('status' => '00'));
                // $user->status = '00';
                DB::table('release_items')
                    ->join('releasetfi', 'releasetfi.id', 'release_items.releasetfi_id')
                    ->where('releasetfi.docno', $v[0])->delete();
                // $user->save();

                break;
        }

        // Releaseorder::where('docno', $id)->delete();

        // return redirect()->route('release.list')->withToastWarning('Successfully delete Releaseorder.');
    }

    public function import(Request $request)
    {
        if (!Auth::user()->hasPermission(['release-import'])) {
            return redirect()->back()->withToastWarning("unable to access");
        }

        $docno = $request->docno ?: '';

        if ($docno != '') {
            $rolists = DB::connection('mysql2')
                ->select("call sp_release(?)", array($docno));

            $request->docno = '';
            return view('releaseorder.releaseorder.import')->withrolists($rolists);

        }

        // dd($rolists);
        return view('releaseorder.releaseorder.import')->withrolists([]);
    }
    public function importSave(Request $request)
    {

        $docno = $request->docno ?: '';

        if (!Releaseorder::where('docno', $docno)->orwhere('PO_no', $docno)->exists()) {

            $rolists = DB::connection('mysql2')
                ->select("call sp_release(?)", array($docno));

            foreach ($rolists as $rolist) {
                $ro = new Releaseorder;
                $ro->docno = $rolist->docno;
                $ro->Customer = $rolist->Customer;
                $ro->Address = $rolist->Address;
                $ro->Sales = $rolist->Sales;
                $ro->SO_no = $rolist->SO_no;
                $ro->PO_no = $rolist->PO_no;
                $ro->Date = $rolist->Date;
                $ro->Attention = $rolist->Attention;
                $ro->Qty = $rolist->Qty;
                $ro->Description = $rolist->Description;
                $ro->Stock_Condition = $rolist->Stock_Condition;
                $ro->Unit_price = $rolist->Unit_price;
                $ro->Amount = $rolist->Amount;
                $ro->VAT_Amount = $rolist->VAT_Amount;
                $ro->Discounted_Amount = $rolist->Discounted_Amount;
                $ro->Terms = $rolist->Terms;
                $ro->Unit = $rolist->Unit;
                $ro->fieldvaluedesc = $rolist->fieldvaluedesc;
                $ro->Line_Discount = $rolist->Line_Discount;
                $ro->Percentage_Disc = $rolist->Percentage_Disc;
                $ro->discamount = $rolist->discamount;
                $ro->u_qty_service = $rolist->u_qty_service;
                $ro->itemcode = $rolist->itemcode;
                $ro->MAKENAME = $rolist->MAKENAME;
                $ro->U_STOCKCODE = $rolist->U_STOCKCODE;
                $ro->importby = Auth::user()->id;
                $ro->save();
            }
            return redirect()->route('release.import')->withToastSuccess('Successfully Import Data.');
        } else {
            return redirect()->back()->withToastWarning('Data is already import.');
        }
    }

    public function print1($ro)
    {
        // This  $data array will be passed to our PDF blade
        $rec1 = DB::select('call sp_release_process(?,?)', array($ro, "0"));
        $rec2 = DB::select('call sp_release_process(?,?)', array($ro, "1"));
        $header1 = DB::table('reportheaders')->where('report_item', '00000')->get();
        $subheader1 = DB::table('reportheaders')->where('report_item', '00001')->get();
        $item1 = DB::table('reportheaders')->where('report_item', '00002')->get();

        $header2 = DB::table('reportheaders')->where('report_item', '00100')->get();
        $subheader2 = DB::table('reportheaders')->where('report_item', '00101')->get();
        $item2 = DB::table('reportheaders')->where('report_item', '00102')->get();

        $signatory = Signatories::where('type', '00001')->get();
        $data = [
            'title' => 'Release Order Receipt',
            'rec1' => $rec1,
            'rec2' => $rec2,
            'header1' => $header1,
            'subheader1' => $subheader1,
            'item1' => $item1,
            'header2' => $header2,
            'subheader2' => $subheader2,
            'item2' => $item2,
            'signatory' => $signatory,
            'heading' => ''];

        if ($data['rec1'] == null && $data['rec2'] == null) {
            return redirect('home')->withToastWarning('No record found!');
        }
        //portrait
        $pdf = \PDF::loadView('reports.pdf_view1', $data);
        // $pdf->setPaper('a4', 'landscape');
        $customPaper = array(0, 0, 1200, 612);
        $pdf->setPaper($customPaper);
        // $pdf = PDF::loadHTML($data)->setPaper('a4', 'landscape');
        return $pdf->stream();
        //return $pdf->download('medium.pdf');
        //  return view('reports.pdf_view')->with($data);

    }

    function print($ro) {

        $rep1 = Releaseorder::where('releaseprocess.ro_no', $ro)
            ->where('report_item.type', '00001')
            ->join('release_items', 'release_items.releasetfi_id', '=', 'releasetfi.id')
            ->join('releaseprocess', 'releaseprocess.id', '=', 'release_items.releaseprocess_id')
            ->join('report_item', 'report_item.itemcode', '=', 'releasetfi.U_STOCKCODE')
            ->groupby(['header1', 'header2', 'header3', 'report_item.itemcode'])
            ->select('header1', 'header2', 'header3', 'report_item.itemcode')
        // ->OrderBy('report_item.type', 'Asc')
            ->OrderBy(DB::raw("(case
                    when report_item.header1 like 'SWAN Sa%' then '0'
                    when report_item.header1 like 'SWAN Ma%' then '1'
                    when report_item.header1 like 'Toyo Sa%' then '2'
                    when report_item.header1 like 'Toyo Ma%' then '3'
                    when report_item.header1 like 'Se%' then '4'
                    when report_item.header1 like 'OBT%' then '5'
                    when  report_item.header1 like 'Ma%' then '6' else '7' end )"), 'Asc')
            ->OrderBy('report_item.header2', 'Asc')
            ->OrderBy('report_item.header3', 'Asc')
            ->OrderBy('report_item.itemcode', 'Asc')
            ->get();
        // DB::enableQueryLog();
        // $queries = DB::getQueryLog();
        // echo '<pre>';

        // foreach($rep1 as $v){
        //     echo '<br>'.$v;
        // }
        $rep2 = Releaseorder::where('releaseprocess.ro_no', $ro)
            ->where('report_item.type', '00002')
            ->join('release_items', 'release_items.releasetfi_id', '=', 'releasetfi.id')
            ->join('releaseprocess', 'releaseprocess.id', '=', 'release_items.releaseprocess_id')
            ->join('report_item', 'report_item.itemcode', '=', 'releasetfi.U_STOCKCODE')
            ->groupby(['header1', 'header2', 'header3', 'report_item.itemcode'])
            ->select('header1', 'header2', 'header3', 'report_item.itemcode')
        // ->OrderBy('report_item.type', 'Asc')
            ->OrderBy(DB::raw("(case
                    when report_item.header1 like 'SWAN Sa%' then '0'
                    when report_item.header1 like 'SWAN Ma%' then '1'
                    when report_item.header1 like 'Toyo Sa%' then '2'
                    when report_item.header1 like 'Toyo Ma%' then '3'
                    when report_item.header1 like 'Se%' then '4'
                    when report_item.header1 like 'OBT%' then '5'
                    when  report_item.header1 like 'Ma%' then '6' else '7' end )"), 'Asc')
            ->OrderBy('report_item.header2', 'Asc')
            ->OrderBy('report_item.header3', 'Asc')
            ->OrderBy('report_item.itemcode', 'Asc')
            ->get();

        $rec1 = Releaseorder::where('releaseprocess.ro_no', $ro)
            ->where('report_item.type', '00001')
            ->join('release_items', 'release_items.releasetfi_id', '=', 'releasetfi.id')
            ->join('releaseprocess', 'releaseprocess.id', '=', 'release_items.releaseprocess_id')
            ->join('report_item', 'report_item.itemcode', '=', 'releasetfi.U_STOCKCODE')

            ->select('releasetfi.Customer',
                'releasetfi.Po_no',
                'releasetfi.Unit',
                'report_item.itemcode as itemcode',
                DB::raw('sum(releasetfi.Qty) as qty'))
            ->OrderBy('releasetfi.Po_no', 'Asc')
            ->OrderBy('report_item.type', 'Asc')
            ->OrderBy(DB::raw("(case
                    when report_item.header1 like 'SWAN Sa%' then '0'
                    when report_item.header1 like 'SWAN Ma%' then '1'
                    when report_item.header1 like 'Toyo Sa%' then '2'
                    when report_item.header1 like 'Toyo Ma%' then '3'
                    when report_item.header1 like 'Se%' then '4'
                    when report_item.header1 like 'OBT%' then '5'
                    when  report_item.header1 like 'Ma%' then '6' else '7' end )"), 'Asc')
            ->OrderBy('report_item.header2', 'Asc')
            ->OrderBy('report_item.header3', 'Asc')
            ->OrderBy('report_item.itemcode', 'Asc')
            ->OrderBy('report_item.header2', 'Asc')
            ->OrderBy('report_item.header3', 'Asc')
            ->OrderBy('report_item.itemcode', 'Asc')
            ->GroupBy('releasetfi.Customer')
            ->Groupby('releasetfi.Po_no')
            ->Groupby('releasetfi.Unit')
            ->Groupby('report_item.itemcode')
            ->get();

        // echo '<pre>';
        //  foreach($rec1 as $v){
        //     echo '<br>'.$v;
        // }
        // die();

        $rec2 = Releaseorder::where('releaseprocess.ro_no', $ro)
            ->where('report_item.type', '00002')
            ->join('release_items', 'release_items.releasetfi_id', '=', 'releasetfi.id')
            ->join('releaseprocess', 'releaseprocess.id', '=', 'release_items.releaseprocess_id')
            ->join('report_item', 'report_item.itemcode', '=', 'releasetfi.U_STOCKCODE')

            ->select('releasetfi.Customer',
                'releasetfi.Po_no',
                'releasetfi.Unit',
                'report_item.itemcode as itemcode',
                DB::raw('sum(releasetfi.Qty) as qty')
            )

            ->OrderBy('releasetfi.Po_no', 'Asc')
            ->OrderBy('report_item.type', 'Asc')
            ->OrderBy(DB::raw("(case
                    when report_item.header1 like 'SWAN Sa%' then '0'
                    when report_item.header1 like 'SWAN Ma%' then '1'
                    when report_item.header1 like 'Toyo Sa%' then '2'
                    when report_item.header1 like 'Toyo Ma%' then '3'
                    when report_item.header1 like 'Se%' then '4'
                    when report_item.header1 like 'OBT%' then '5'
                    when  report_item.header1 like 'Ma%' then '6' else '7' end )"), 'Asc')
            ->OrderBy('report_item.header2', 'Asc')
            ->OrderBy('report_item.header3', 'Asc')
            ->OrderBy('report_item.itemcode', 'Asc')
            ->GroupBy('releasetfi.Customer')
            ->Groupby('releasetfi.Po_no')
            ->Groupby('releasetfi.Unit')
            ->Groupby('report_item.itemcode')

            ->get();

        $rd = DB::table('releaseprocess')->where('ro_no', $ro)->get();

        $signatory = Signatories::where('type', '00001')->get();
        $data = [
            'details' => $rd,
            'rep1' => $rep1,
            'rep2' => $rep2,
            'rec1' => $rec1,
            'rec2' => $rec2,
            'signatory' => $signatory,

        ];

        // echo "<pre>";
        // var_dump($rep2);
        // die();
        $pdf = \PDF::loadView('reports.pdf_view', $data);
        $pdf->setPaper('folio', 'landscape');
        // $customPaper = array(0, 0, 936, 612);
        // $pdf->setPaper($customPaper);
        // $pdf = PDF::loadHTML($data)->setPaper('a4', 'landscape');
        return $pdf->stream();

        return view('reports.pdf_view')->with($data);
    }

    public function exportDelivery(Request $request)
    {

        // if ($request->submit == "excel") {
        //     var_dump('aa');
        // } else if ($request->submit == "excel-detailed") {
        //     var_dump('bb');
        // }

        // die();

        // $data = ReleaseProcess::whereIn('releasetfi.status', ['01', '99'])

        $data = ReleaseProcess::where(function ($query) {

            $query->whereRaw("IF('" . request()->get('from_date')
                . "'='',''='',deliver_date between '" . request()->get('from_date') . "' and '" . request()->get('to_date') . "' )")
                ->whereRaw("IF('" . request()->get('status')
                    . "'='',''='',releaseprocess.status ='" . request()->get('status') . "' )")
                ->whereRaw("IF('" . request()->get('inputArea')
                    . "'='',''='',releaseprocess.area ='" . request()->get('inputArea') . "' )")
                ->whereRaw("IF('" . request()->get('driver')
                    . "'='',''='',releaseprocess.driver ='" . request()->get('driver') . "' )")
                ->whereIn('releasetfi.status', ['01', '99']);

        })->join('release_items', 'release_items.releaseprocess_id', '=', 'releaseprocess.id')
            ->join('releasetfi', 'releasetfi.id', '=', 'release_items.releasetfi_id')
        // ->groupby(['releasetfi.Customer','releaseprocess.ro_no', 'releaseprocess.area', 'releaseprocess.plate', 'releaseprocess.truckno', 'releaseprocess.driver', 'releaseprocess.deliver_date', 'releaseprocess.status', 'releaseprocess.id',])
            ->select([
                'releasetfi.docno',
                'releasetfi.Description',
                'releasetfi.Qty',
                'releasetfi.Unit_price',
                'releasetfi.sales',
                'releasetfi.Line_Discount',
                'releasetfi.Customer',
                'releasetfi.Po_no',
                'releasetfi.Date',
                'releaseprocess.ro_no',
                'releaseprocess.area',
                'releaseprocess.plate',
                'releaseprocess.truckno',
                'releaseprocess.driver',
                'releaseprocess.deliver_date',
                'releaseprocess.id',
                'releasetfi.Amount',
                DB::raw("case (releaseprocess.status) when '99' then 'cancel' when '00' then 'active' end as status"),
                // DB::raw("SUM(Amount) as total"),
            ])
            ->orderByDesc('id')
            ->get();
        // $data->map(function ($group) { return ['total' =>$group->sum('releasetfi.Amount')]; });
        // echo '<pre>';
        // var_dump($data);
        //     die();
        return Excel::download(new DeliveryExport('export.view.delivery', $data), 'Delivery_' . date('YmdHis') . '.xlsx')
        ;
    }

    public function filters()
    {
        //returns associative array of request body key value pairs
        return $this->request->all();
    }

}
