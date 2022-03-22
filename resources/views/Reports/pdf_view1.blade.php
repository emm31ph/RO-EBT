<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TOSEN Foods Inc.</title>
    {{--
    <link href="{{ public_path('css/app.css') }}" rel="stylesheet"> --}}

    <style type="text/css" media="all">
        /** Define the margins of your page **/
        @page {
            margin: 20px 10px;
            /* you can change  */
            /* size: 842pt 595pt; */
        }

        .borderless td,
        .borderless th {
            border: none;
        }


        .text-center {
            text-align: center;
        }

        .align-bottom {
            vertical-align: text-bottom;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .align-middle {
            vertical-align: text-middle;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }
        .sm-text{
            font-size: 8px;
        }
        h1,
        .h1 {
            font-size: 2.5rem;
        }

        h2,
        .h2 {
            font-size: 2rem;
        }

        h3,
        .h3 {
            font-size: 1.75rem;
        }

        h4,
        .h4 {
            font-size: 1.5rem;
        }

        h5,
        .h5 {
            font-size: 1.25rem;
        }

        h6,
        .h6 {
            font-size: 0.8rem;
        }

        .align-top {
            vertical-align: top !important;
        }

        .align-middle {
            vertical-align: middle !important;
        }

        .align-bottom {
            vertical-align: bottom !important;
        }

        .align-text-bottom {
            vertical-align: text-bottom !important;
        }

        .align-text-top {
            vertical-align: text-top !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-wrap {
            /* white-space: normal !important; */
        }

        label {
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        table {
            border-collapse: collapse;
        }

        .container-fluid {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .align-text-top {
            vertical-align: text-top !important;
        }

        .align-top {
            vertical-align: top !important;
        }

        footer {
            position: fixed;
            bottom: 0px;
            left: 10px;
            right: 4px;
            height: 100px;
            padding: 0 10px 0 10px;

            /* border: 1px solid blanchedalmond; */
            width: 100% !important;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            /* color: white; */
            /* text-align: center; */
            /* line-height: 35px; */
        }

        .d-inline-block {
            display: inline-block !important;
        }

        .signaturies {
            width: 20%;
            height: 80%;
            float: left;
            text-align: center;
            border-right: 1px solid black;
        }

        .left {
            float: left;
        }

        .right {
            float: right;
        }

        .table {
            width: 100%;
            font-size: 10px;
        }

        .table1 {
            width: 1200px;
            font-size: 10px;
            table-layout: auto;
        }

        td {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .border1 td,
        .border1 th {
            border: 1px solid black;
            font-size: 11px;
        }


        .name {
            width: 250px !important;
        }

        .sidr {
            width: 40px !important;
            white-space: normal !important;
        }

        .tdwidth {
            width: 15px !important;
            white-space: normal !important;

        }
        .totalwidth{
              width: 50px !important;
            white-space: normal !important;
        }
        .tdwidth-sm {
            width: 20px !important;
            white-space: normal !important;
        }

        .remarks {
            white-space: normal !important;
            text-align: justify;
            margin: 0 auto;
            left: 0;
            right: 0;
        }

        .remarks>p {
            text-align: justify;
            display: inline-block;
            text-align: justify;
        }

        .remarks>h4 {
            text-align: justify;
            display: inline-block;
            text-align: justify;
        }

    </style>
</head>

<body style="background-color: white ">

    @php
    $grandtotal = 0;
        $counts = [];
        $counts1 = [];
        $counts2 = [];
        $counts9 = [];
        $counts10 = [];
        $i =0;


        foreach ($rep1 as $row) {

        if(isset($counts[$row['header1']])){
        $counts[$row['header1']] +=1;
        }else{
        $counts[$row['header1']] =1;
        }

        if(isset($counts1[$row['header1'].','.$row['header2']])){
        $counts1[$row['header1'].','.$row['header2']] +=1;
        }else{
        $counts1[$row['header1'].','.$row['header2']] =1;
        }

        if(isset($counts9[$row['header1'].','.$row['header2'].','.$row['header3']])){
        $counts9[$row['header1'].','.$row['header2'].','.$row['header3']] +=1;
        }else{
        $counts9[$row['header1'].','.$row['header2'].','.$row['header3']] =1;
        }

        if(isset($counts9[$row['header1'].','.$row['header2'].','.$row['header3'].','.$row['itemcode']])){
        $counts10[$row['header1'].','.$row['header2'].','.$row['header3'].','.$row['itemcode']] +=1;
        }else{
        $counts10[$row['header1'].','.$row['header2'].','.$row['header3'].','.$row['itemcode']] =1;
        }
        $counts2[$row['header1'].','.$row['header2'].','.$row['header3'].','.$row['itemcode']] = 1;
        }

    @endphp


    @php
    $unit =[];
        $arrC =[];
        $arrG =[];

        foreach ($rec1 as $value) {

                    $unit[] = $value->Unit;
            foreach ($counts10 as $k => $item){
                if (($value->itemcode==(explode(',',$k)[3])))
                {
                    $arrC[$value->Po_no][$value->Customer][(explode(',',$k)[3])] = $value->qty;
                }

                if (($value->itemcode==(explode(',',$k)[3])))
                {
                    if(isset($arrG[(explode(',',$k)[3])])){
                        $arrG[(explode(',',$k)[3])] += $value->qty;
                    } else {
                        $arrG[(explode(',',$k)[3])] = $value->qty;
                    }
                }
            }
        }

         foreach ($rec2 as $value) {

                    $unit[] = $value->Unit;
         }
    @endphp


    <div class="container-fluid">

        <table class="table">
            <tr>
                <td style="width: 30%;  " class="align-middle">
                    <p class="h2" style="vertical-align: middle;">
                        <img src="{{ public_path('img/logo.png') }}" style=" display: block;
                        margin-left: auto;
                        margin-right: auto;" width="50px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tosen Foods, Inc.
                    </p>
                </td>
                <td colspan="3" class="text-center align-bottom">
                    <p class="h3">Release Order</p>
                </td>
                <td style="width: 15%;" class="text-center align-middle">
                </td>
                <td style="width: 15%;" class="text-center align-middle">
                    <p class="h5">
                        <b>RO No.</b>
                        {{ $details[0]->ro_no }}
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="align-bottom">
                    <b class="h5">TO: OPERATIONS</b>
                    <br><em class="h6"><label>Please release the following items for on</label>
                        <label style="width: 150px; text-align:center; border-bottom: 1px solid black"
                            class="font-weight-bold">
                            {{ date('d-M-Y', strtotime($details[0]->deliver_date)) }}
                        </label>
                        <label>to the following customers :</label></em>
                </td>
                <td class="align-bottom">
                    <span class="h5">
                    @php
                        $d = '';
                        $v = '';
                        $ii = 0;
                        foreach ((array_unique($unit)) as $key => $value) {
                            if($ii!=0){
                                $d = ' | ';
                            }

                            $v = $v.$d.$value.'S';
                            $ii++;
                        }

                        echo $v;
                    @endphp
                    </span>
                </td>
                <td class=" align-bottom" style="width:15%">
                    <em class="h6">
                        <label for="Area">Area</label>
                        <label style="width: 150px; text-align:center; border-bottom: 1px solid black"
                            class="font-weight-bold">

                            {{ $details[0]->area }}

                        </label>
                    </em>
                </td>
                <td class="align-bottom align-right">
                    <em class="h6"><label for="Area">Date</label>
                        <label style="width: 150px; text-align:center;  border-bottom: 1px solid black"
                            class="font-weight-bold">

                            {{ date('d-M-Y', strtotime($details[0]->created_at)) }}

                        </label>
                    </em>
                </td>
            </tr>
        </table>

        <table class="table1 border1" style="margin-top: 5px">
            <tr>
                <td rowspan="3" class="name text-center font-weight-bold">Customer/Location</td>
                <td rowspan="3" class="sidr text-center font-weight-bold">SI/DR No.</td>
                @php
                $rowCnt=0;
                @endphp
                @foreach ($counts as $k => $item)
                    @php
                    $rowCnt +=$item;
                    @endphp
                    <td colspan="{{ $item }}" class="tdwidth text-center font-weight-bold"><span class="sm-text">{{ $k }}</span></td>
                @endforeach

                @for ($i = $rowCnt; $i < 36; $i++)
                    <td>&nbsp;</td>
                @endfor

                <td class="text-center font-weight-bold totalwidth">Total</td>
            </tr>
            <tr>
                @php
                $rowCnt=0;
                @endphp
                @foreach ($counts1 as $k => $item)
                    @php
                    $rowCnt +=$item;
                    @endphp
                    @php
                    $val = explode(',',$k)[1];
                    $i = $item
                    @endphp
                    <td colspan="{{ $item }}" class="tdwidth text-center font-weight-bold">
                        <span class="sm-text">{!! $val !!}</span>
                    </td>
                @endforeach
                @for ($i = $rowCnt; $i < 36; $i++)
                    <td class="tdwidth">&nbsp;</td>
                @endfor
                <td></td>
            </tr>
            <tr>
                @php
                $rowCnt=0;
                @endphp
                @foreach ($counts9 as $k => $item)
                    @php
                    $rowCnt ++;
                    @endphp
                    <td class="tdwidth text-center font-weight-bold">
                        <span class="sm-text">{!! explode(',', $k)[2] !!}</span></td>
                @endforeach
                @for ($i = $rowCnt; $i < 36; $i++)
                    <td>&nbsp;</td>
                @endfor
                <td>&nbsp;</td>
            </tr>

            {{-- List Customer loop --}}
            @php
            $cnt = 1;
            @endphp
            @foreach ($arrC as $k => $v)
                <tr>
                    <td>
                        @php
                        $itemCode = [];
                        @endphp
                        @foreach ($v as $k1 => $v1)

                            @php
                            $itemCode = $v1;
                            @endphp

                            {{ $cnt }} {!! Str::limit($k1, 30) !!}
                        @endforeach
                    </td>
                    <td class="text-center">{!! $k !!}</td>
                    @php
                    $rowCnt = 0;
                    $sum = 0;
                    $sumTotal = 0;
                    $gTotal = [];
                    @endphp
                    @foreach ($counts10 as $k2 => $item)
                        <td class="text-center">
                            @foreach ($itemCode as $k3 => $item)
                                @if (explode(',', $k2)[3] == $k3)
                                    {{ number_format($item) }}
                                    @php
                                    $indx = explode(',',$k2)[3];
                                    // $gTotal[$indx] = $item;
                                    $sum +=$item
                                    @endphp
                                @endif

                            @endforeach
                            @php
                            $rowCnt++;
                            $sumTotal +=$sum;
                            @endphp
                        </td>
                    @endforeach
                    @for ($i = $rowCnt; $i < 36; $i++)
                        <td></td>
                    @endfor
                    <td class="text-center">{{ $sum }}</td>

                </tr>
                @php
                $cnt++;
                @endphp
            @endforeach
            {{-- End List of Customer loop --}}

            @for ($i = $cnt; $i <= 12; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    @for ($e = 0; $e < 38; $e++)
                        <td></td>
                    @endfor
                </tr>
            @endfor
            <tfoot>
                <tr>
                    <td class="text-right font-weight-bold">TOTAL </td>
                    <td></td>
                    @php
                    $sum = 0;$cnt = 0;
                    @endphp
                    @foreach ($counts10 as $k2 => $item)
                        @php
                        $cnt++;
                        @endphp
                        <td class="text-center">
                            @foreach ($arrG as $k3 => $v2)
                                @if ($k3 == explode(',', $k2)[3])
                                    {{ number_format($v2) }}
                                    @php
                                    $sum += $v2
                                    @endphp
                                @endif
                            @endforeach
                        </td>
                    @endforeach
                    @for ($i = $cnt; $i < 36; $i++)
                        <td></td>
                    @endfor
                    @php
                     $grandtotal += $sum
                    @endphp
                    <td class="text-center font-weight-bold">{{ $sum }}</td>
                </tr>
            </tfoot>
            </tbody>

        {{-- </table> --}}
        <tr>
            <td colspan="39"></td>
        </tr>
   @php
            $arrC =[];
            $arrG =[];
            foreach ($rec2 as $value) {

                    $unit[] = $value->Unit;

                foreach ($counts10 as $k => $item){
                    if (($value->itemcode==(explode(',',$k)[3])))
                    {
                        $arrC[$value->Po_no][$value->Customer][(explode(',',$k)[3])] = $value->qty;
                    }

                    if (($value->itemcode==(explode(',',$k)[3])))
                    {
                        if(isset($arrG[(explode(',',$k)[3])])){
                            $arrG[(explode(',',$k)[3])] += $value->qty;
                        } else {
                         $arrG[(explode(',',$k)[3])] = $value->qty;
                        }
                    }
                }
            }


        @endphp
        {{-- code rep 2 --}}
        @php
            $counts = [];
            $counts1 = [];
            $counts2 = [];
            $counts9 = [];
            $counts10 = [];
            $i =0;

            foreach ($rep2 as $row) {

            if(isset($counts[$row['header1']])){
                $counts[$row['header1']] +=1;
            }else{
                $counts[$row['header1']] =1;
            }

            if(isset($counts1[$row['header1'].','.$row['header2']])){
                $counts1[$row['header1'].','.$row['header2']] +=1;
            }else{
                $counts1[$row['header1'].','.$row['header2']] =1;
            }

            if(isset($counts9[$row['header1'].','.$row['header2'].','.$row['header3']])){
                $counts9[$row['header1'].','.$row['header2'].','.$row['header3']] +=1;
            }else{
                $counts9[$row['header1'].','.$row['header2'].','.$row['header3']] =1;
            }

            if(isset($counts9[$row['header1'].','.$row['header2'].','.$row['header3'].','.$row['itemcode']])){
                $counts10[$row['header1'].','.$row['header2'].','.$row['header3'].','.$row['itemcode']] +=1;
            }else{
                $counts10[$row['header1'].','.$row['header2'].','.$row['header3'].','.$row['itemcode']] =1;
            }
                $counts2[$row['header1'].','.$row['header2'].','.$row['header3'].','.$row['itemcode']] = 1;
            }

        @endphp

        {{-- end code rep2 --}}
        {{-- data 2 --}}
        {{-- <table class="table1 border1" style="margin-top: 5px"> --}}
            <tr>
                <td rowspan="3" class="name text-center font-weight-bold">Customer/Location</td>
                <td rowspan="3" class="sidr text-center font-weight-bold">SI/DR No.</td>
                @php
                $rowCnt=0;
                @endphp
                @foreach ($counts as $k => $item)
                    @php
                    $rowCnt +=$item;
                    @endphp
                    <td colspan="{{ $item }}" class="tdwidth text-center font-weight-bold">
                       <span class="sm-text">{{ $k }}</span>
                    </td>
                @endforeach

                @for ($i = $rowCnt; $i < 36; $i++)
                    <td class="tdwidth">&nbsp;</td>
                @endfor

                <td class="text-center font-weight-bold totalwidth">Total</td>
            </tr>
            <tr>
                @php
                $rowCnt=0;
                @endphp
                @foreach ($counts1 as $k => $item)
                    @php
                    $rowCnt +=$item;
                    @endphp
                    @php
                    $val = explode(',',$k)[1];
                    $i = $item
                    @endphp
                    <td colspan="{{ $item }}" class="tdwidth text-center font-weight-bold">
                        <span class="sm-text">{!! $val !!}</span>
                    </td>
                @endforeach
                @for ($i = $rowCnt; $i < 36; $i++)
                    <td class="tdwidth">&nbsp;</td>
                @endfor
                <td></td>
            </tr>
            <tr>
                @php
                $rowCnt=0;
                @endphp
                @foreach ($counts9 as $k => $item)
                    @php
                    $rowCnt ++;
                    @endphp
                    <td class="tdwidth text-center font-weight-bold">
                        <span class="sm-text">{!! explode(',', $k)[2] !!}</span></td>
                @endforeach
                @for ($i = $rowCnt; $i < 36; $i++)
                    <td>&nbsp;</td>
                @endfor
                <td>&nbsp;</td>
            </tr>

            {{-- List Customer loop --}}
            @php
            $cnt = 1;
            @endphp
            @foreach ($arrC as $k => $v)
                <tr>
                    <td>
                        @php
                        $itemCode = [];
                        @endphp
                        @foreach ($v as $k1 => $v1)

                            @php
                            $itemCode = $v1;
                            @endphp

                            {{ $cnt }} {!! Str::limit($k1, 30) !!}
                        @endforeach
                    </td>
                    <td class="text-center">{!! $k !!}</td>
                    @php
                    $rowCnt = 0;
                    $sum = 0;
                    $sumTotal = 0;
                    $gTotal = [];
                    @endphp
                    @foreach ($counts10 as $k2 => $item)
                        <td class="text-center">
                            @foreach ($itemCode as $k3 => $item)
                                @if (explode(',', $k2)[3] == $k3)
                                    {{ number_format($item) }}
                                    @php
                                    $indx = explode(',',$k2)[3];
                                    // $gTotal[$indx] = $item;
                                    $sum +=$item
                                    @endphp
                                @endif

                            @endforeach
                            @php
                            $rowCnt++;
                            $sumTotal +=$sum;
                            @endphp
                        </td>
                    @endforeach
                    @for ($i = $rowCnt; $i < 36; $i++)
                        <td></td>
                    @endfor
                    <td class="text-center">{{ $sum }}</td>

                </tr>
                @php
                $cnt++;
                @endphp
            @endforeach
            {{-- End List of Customer loop --}}

            @for ($i = $cnt; $i <= 12; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    @for ($e = 0; $e < 38; $e++)
                        <td></td>
                    @endfor
                </tr>
            @endfor
            <tfoot>
                <tr>
                    <td class="text-right font-weight-bold">TOTAL </td>
                    <td></td>
                    @php
                    $sum = 0;$cnt = 0;
                    @endphp
                    @foreach ($counts10 as $k2 => $item)
                        @php
                        $cnt++;
                        @endphp
                        <td class="text-center">
                            @foreach ($arrG as $k3 => $v2)
                                @if ($k3 == explode(',', $k2)[3])
                                    {{ number_format($v2) }}
                                    @php
                                    $sum += $v2
                                    @endphp
                                @endif
                            @endforeach
                        </td>
                    @endforeach
                    @for ($i = $cnt; $i < 36; $i++)
                        <td></td>
                    @endfor

                    @php
                     $grandtotal += $sum
                    @endphp
                    <td class="text-center font-weight-bold">{{ $sum }}</td>
                </tr>
            </tfoot>
            <tr>
                 {{-- @for ($i = 0; $i < 38; $i++)
                        <td></td>
                    @endfor --}}
                 <td colspan="38" class="text-right font-weight-bold">GRAND TOTAL </td>

                <td class="text-center  font-weight-bold">{{ $grandtotal }}</td>
            </tr>
            </tbody>

        </table>
        {{-- end data 2 --}}

        {{-- footer --}}
        <footer>
            <table style="width:99.8%;">
                <tr>
                    <td style=" height:80%; width:50%; line-height: 20px; padding-right:12px   " class="align-text-top">
                        <div class="remarks">

                            <p class="h6">
                            <h4 class="h5"> REMARKS:</h4>
                            @if ($details[0]->status=='99')
                                <h2>Cancelled</h2>
                            @else

                             {{ str_replace( "<br>", "",$details[0]->remarks) }}
                            @endif
                        </div>


                        </p>
                    </td>
                    <td style=" height:40px; border: 1px solid black;" class="align-top">
                        <div style="width: 100%; display: flex;">
                            <div class="signaturies">
                                <div style="width: 100%;" class="text-center">
                                    <p class="h6"><small>Prepared by:</small>
                                    </p>
                                </div>

                                <div style="width: 100%; height:20px; padding-top:20px;">
                                    <small>{{ Auth::user()->name }}</small>
                                </div>
                                <div style="width: 100%; border-top:1px solid black;" class="text-center">
                                    <p class="h6"><small>Logistic's Assistant</small>
                                    </p>
                                </div>
                            </div>

                            <div class="signaturies">
                                <div style="width: 100%;" class="text-center">
                                    <p class="h6"><small>Reviewed by:</small>
                                    </p>
                                </div>
                                <div style="width: 100%; height:20px; padding-top:20px;">
                                    <small>{{ $signatory[0]->signatory1 }}</small>

                                </div>
                                <div style="width: 100%; border-top:1px solid black;" class="text-center">
                                    <p class="h6"><small>Warehouse Supervisor</small>
                                    </p>
                                </div>
                            </div>

                            <div class="signaturies">
                                <div style="width: 100%;" class="text-center">
                                    <p class="h6"><small>Approved by:</small>
                                    </p>
                                </div>
                                <div style="width: 100%; height:20px; padding-top:20px;">
                                    <small>{{ $signatory[0]->signatory2 }}</small>
                                </div>
                                <div style="width: 100%; border-top:1px solid black;" class="text-center">
                                    <p class="h6"><small>Logistic's Supervisor</small>
                                    </p>
                                </div>

                            </div>

                            <div class="signaturies" style="width: 40% !impotant; border-right: 1px solid black ">
                                <div style="border-right:1px solid black !important; width:50%; height: 56px;   "
                                    class="left">
                                    <p class="h6">Truck No</p>
                                    <p class="h6">
                                        <small>{{ $details[0]->truckno }}</small>
                                    </p>
                                </div>
                                <div style="width:50%;" class="right">
                                    <p class="h6">Plate No</p>
                                    <p class="h6">
                                        <small>{{ $details[0]->plate }}</small>
                                    </p>
                                </div>
                                <div
                                    style="border-top:1px solid black !important;  width:100%; height: 15px;  position:absolute;  bottom:60px; text-align:left  ">
                                    <p style=" position:absolute;  left:2px;" class="h6">Driver</p>
                                    <h4 style="position:absolute; right:0; width:80%">
                                       <small> {{ $details[0]->driver }}</small>
                                    </h4>
                                </div>

                            </div>




                        </div>
                    </td>

                </tr>
            </table>
        </footer>
        {{-- end footer --}}
    </div>
</body>

</html>
