@extends('layouts.manage.app')
@push('css')

@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('ro.index') }}">Release Order</a></li>
@endsection
@section('content')
    <div class="container">
        <div class="card my-1">
            <div class="card-body">
                <div class="row">
                    <div class="col col-3 border-right h-100">
                        @include('ReleaseOrder.Releaseorder.rosidebar')
                    </div>
                    <div class="col col-9">
                        <nav>
                            <div class="nav nav-sm nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link @if(request()->unprocess || !request()->process) active @endif" id="nav-unprocess-tab" data-toggle="tab" href="#nav-unprocess"
                                    role="tab" aria-controls="nav-unprocess" aria-selected="true">Un-process</a>
                                <a class="nav-item nav-link  @if(request()->process) active @endif" id="nav-process-tab" data-toggle="tab" href="#nav-process"
                                    role="tab" aria-controls="nav-process" aria-selected="false">Process</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade  @if(!request()->process || (request()->unprocess)) show active @endif " id="nav-unprocess" role="tabpanel"
                                aria-labelledby="nav-unprocess-tab">
                                <div class="form-group border-bottom">
                            <div class="table-responsive">
                                <table class="table table-sm" id="example">
                                    <thead>
                                                                         <tr> 
                                            <th colspan="4" class="text-right">
                          
                <form action="{{ route('release.list') }}/?unprocess=1" method="POST" role="search">
                {{ csrf_field() }}                                 
                <div class="input-group mb-3">
                <input type="text" class="form-control" name="q1" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
                </div>
                </form>

                        </th>
                                        </tr>
                                        <tr>
                                            <th>Document Number</th>
                                            <th>Customer</th>
                                            <th>Date Created</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0 @endphp
                                        @foreach ($unprocess as $rolist)
                                            <tr>
                                                <td class=""> <a href="{{ route('ro.show',$rolist->docno) }}">{{ $rolist->docno }}</a> </td>
                                                <td class=""> {{ Str::limit($rolist->Customer,40) }}</td>
                                                <td class=""> {{ $rolist->Date }}</td>
                                                <td class="text-right"> {{ number_format($rolist->total, 2) }}</td>
                                            </tr>
                                            @php $total += $rolist->total @endphp
                                        @endforeach
                                         
                                        <tr>
                                            <td colspan="4">{{ $unprocess->links() }}</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            </div>
                            <div class="tab-pane fade  @if(request()->process) show active @endif"  id="nav-process" role="tabpanel" aria-labelledby="nav-process-tab">
                                <div class="form-group border-bottom">
                            <div class="table-responsive">

                                {{-- <table class="table table-sm">
                                    <thead>
                                        <tr> 
                                            <th colspan="5" class="text-right">
                          
                                <form action="{{ route('release.list') }}/?process=1" method="POST" role="search">
                                {{ csrf_field() }}                                 
                                    <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="q" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                                    </div>
                                    </div>
                                    </form>

                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Document Number</th>
                                            <th>Customer</th>
                                            <th>Delivery Date</th>
                                            <th>R.O.#</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0 @endphp
                                        @foreach ($process as $rolist)
                                            <tr>
                                                <td class=""><a href="{{ route('ro.show',$rolist->docno) }}">{{ $rolist->docno }}</a></td>
                                                <td class=""> {{ Str::limit($rolist->Customer,40) }}</td>
                                                <td class=""> {{ $rolist->deliver_date }}</td>
                                                <td class=""> {{ $rolist->ro_no }}</td>
                                                <td class="text-right"> {{ number_format($rolist->total, 2) }}</td>
                                            </tr>
                                            @php $total += $rolist->total @endphp
                                        @endforeach
                                      
                                        <tr>
                                            <td colspan="5">{{ $process->links() }}</td>

                                        </tr>
                                         
                                    </tbody>

                                </table> --}}
                            </div>


                        </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
@push('js')

@endpush
