<table class="table">

    <tr>
        <td colspan=" @if((request()->get('submit')!='excel')) 13 @else 7 @endif">Delivery - {{ (request()->get('submit')=='excel')?"Summary":"detailed"}}</td>
    </tr>

    @if ((request()->get('inputArea')!= ''))
    <tr>
        <td class="text-center">Area</td>
        <td colspan="2">{{  (request()->get('inputArea')) }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @endif

    @if ((request()->get('inputDriver')!= ''))
    <tr>
        <td class="text-center">Driver</td>
        <td colspan="2">{{  (request()->get('inputDriver')) }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @endif

    @if ((request()->get('status')!= ''))
    <tr>
        <td class="text-center">Status</td>
        <td colspan="2">{{  (request()->get('status')=='00')?"Active":"Cancel" }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @endif

    @if ((request()->get('from_date')!= '') || (request()->get('to_date')!= ''))
    <tr>
        <td class="text-center">Date from </td>
        <td colspan="2">{{ request()->get('from_date') }} to {{ request()->get('to_date') }}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    @endif

    <tr>
        <td class="text-center">RO No.</td>
        @if ((request()->get('submit')!='excel'))
        <td></td>
        @endif
        <td>Driver</td>
        <td>Truck #</td>
        <td>Plate</td>
        <td>RO Date</td>
        <td>Area</td>
        @if ((request()->get('submit')!='excel'))
            
        <td></td>
        <td></td>
        <td></td>
        <td></td> 
        <td></td> 
        @endif
        <td>Status</td>
    </tr>

    @if (request()->get('submit')!='excel')
    <tr>
        <td></td>
        <td>SI/DR No.</td>
        <td>SI/DR Date</td>
        <td></td>
        <td></td>
        <td>Docno</td>
        <td>Customer</td>
        <td>Item Description</td>
        <td>Qty</td>
        <td>Unit Price</td>
        <td>Discount</td>
        <td style="font-display: center">Total</td>
        <td></td>
    </tr>

    @endif

    @foreach ($data->groupby(['ro_no']) as $items)
    <tr>
        <td> {{ $items[0]->ro_no }} </td>
        
        @if ((request()->get('submit')!='excel'))
        <td></td>
        @endif
        
        <td> {{ $items[0]->driver }} </td>
        <td> {{ $items[0]->truckno }} </td>
        <td> {{ sprintf('%d',$items[0]->plate) }} </td>


        <td data-format="dd/mm/yy"> {{ $items[0]->deliver_date }} </td>
        <td> {{ $items[0]->area }} </td>
        @if ((request()->get('submit')!='excel'))
            
        <td></td>
        <td></td> 
        <td></td>
        <td></td>
        <td></td>
        @endif
        <td> {{ $items[0]->status }} </td>


    </tr>
     @if (request()->get('submit')!='excel')
        @foreach($items->groupby(['Po_no']) as $item)
        
        <tr>
            <td></td>
            <td>{{ $item[0]->Po_no  }}</td>
            
            <td  data-format="dd/mm/yy">{{ $item[0]->Date  }}</td>
            <td></td>
            <td></td>
            <td>{{ $item[0]->docno  }}</td>
            <td>{{ $item[0]->Customer  }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td data-format="#,##0.00_-"></td>
        </tr>
            @foreach($item->groupby(['Description']) as $item)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $item[0]->Description  }}</td>
                <td>{{ $item[0]->Qty  }}</td>
                <td data-format="#,##0.00_-">{{ $item[0]->Unit_price  }}</td>
                <td>{{ (int)$item[0]->Line_Discount    }}%</td>
                <td data-format="#,##0.00_-">{{ ($item[0]->Qty*$item[0]->Unit_price )-(($item[0]->Qty*$item[0]->Unit_price)*((int)$item[0]->Line_Discount/100))  }}</td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        @endforeach
    @endif 

    @endforeach


</table>
