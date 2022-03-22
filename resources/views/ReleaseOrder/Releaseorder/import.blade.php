@extends('layouts.manage.app')
@push('css')
@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('ro.index') }}">Release Order</a></li>

@endsection
@section('content')
    <div class="">
        <div class="card my-1 border border-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col col-3 {{ ($rolists == null)?"border-right":"" }} h-100">
                       
                         @include('ReleaseOrder.Releaseorder.rosidebar')
                    </div>
                    <div class="col {{ ($rolists != null)?"border-left":"" }} col-9">

                        <div class="form-group border-bottom">
                              {!! Form::open(['route' => 'release.import', 'role' => 'form'] ) !!}

                                <label for="DOCNo">Import Delivery Order</label>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Enter Document Number"
                                        aria-label="Enter Document Number" aria-describedby="basic-addon2" 
                                        value="{{request()->input('docno') }}"
                                        name="docno">
                                    <div class="input-group-append">
                                        <button class="input-group-text">Enter</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}

                            @if ($rolists != null)
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-8"><b>{{ $rolists[0]->Customer }}</b></div>
                                        <div class="col-sm-4 text-center"> <b>{{ $rolists[0]->docno }}</b></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-8">{{ $rolists[0]->Address }}</div>
                                        <div class="col-sm-4">

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="d-flex flex-column">
                                                        <div class="text-center">{{ $rolists[0]->Sales }}</div>
                                                        <div class="text-center">{{ $rolists[0]->SO_no }}</div>
                                                        <div class="text-center">{{ $rolists[0]->PO }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex flex-column">
                                                        <div class="text-center">{{ $rolists[0]->Date }}</div>
                                                        <div class="text-center">{{ $rolists[0]->PO_no }}</div>
                                                        <div class="text-center">{{ $rolists[0]->Terms }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive " id="div1">

                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>QTY</th>                                                
                                                <th>Unit</th>
                                                <th>Discription</th>
                                                <th class="text-right">Price</th>
                                                <th class="text-center">Discount</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $total = 0;$tqty = 0; @endphp
                                            @foreach ($rolists as $rolist)
                                                <tr class="">
                                                    <td class=""> {{ number_format($rolist->Qty,0) }}</td>
                                                    <td class=""> {{ $rolist->Unit }}</td>
                                                    <td class=""> {{ $rolist->Description }}</td>
                                                    <td class="text-right"> {{ number_format($rolist->Unit_price, 2) }}</td>
                                                    <td class="text-center"> {{ number_format($rolist->Line_Discount, 0) }}%
                                                    </td>
                                                    <td class="text-right"> {{ number_format($rolist->Amount, 2) }}</td>
                                                </tr>
                                                @php $total += $rolist->Amount; $tqty+=$rolist->Qty @endphp
                                                @endforeach
                                                <tfoot>

                                                    <tr>
                                                        
                                                        <td><b>Total</b></td>
                                                        <td><b>{{ number_format($tqty, 0) }}</b></td>
                                                        
                                                        <td colspan="4" class="text-right"><b>{{ number_format($total, 2) }}</b></td>
                                                        </tr>
                                                    </tfoot>
                                        </tbody>

                                    </table>
                                </div>
                            @elseif(request()->input('docno')!==null)
                            No record found!
                            @endif

                        </div>
                        <div class="form-group">
                           {!! Form::open(['route' => 'release.import.save', 'role' => 'form'] ) !!}
  
                            <input type="hidden" name="docno" value="{{ request()->input('docno') }}">
                            <button type="submit" class="btn btn-primary btn-sm" 
                            {{ ($rolists == null)?'disabled':'' }}>Import</button>
                            
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
@push('js')
<script> 

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
@endpush
