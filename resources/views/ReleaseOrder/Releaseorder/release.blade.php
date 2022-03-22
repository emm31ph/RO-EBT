@extends('layouts.manage.app')
@push('css')
@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('ro.index') }}">Release Order</a></li>

@endsection
@section('content')
    <div class="">
         <div class="card border border-primary">
             <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col col-3 border-right h-100">

                        @include('ReleaseOrder.Releaseorder.rosidebar')
                    </div>
                    <div class="col col-9">
                        <nav>
                            <div class="nav nav-sm nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-unprocess-tab" data-toggle="tab" href="#nav-unprocess"
                                    role="tab" aria-controls="nav-unprocess" aria-selected="true">Un-Process</a>
                                <a class="nav-item nav-link" id="nav-process-tab" data-toggle="tab" href="#nav-process"
                                    role="tab" aria-controls="nav-process" aria-selected="false">Process</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-unprocess" role="tabpanel"
                                aria-labelledby="nav-unprocess-tab">
                                1
                            </div>
                            <div class="tab-pane fade" id="nav-process" role="tabpanel" aria-labelledby="nav-process-tab">
                                2
                            </div>
                        </div>
                        <div class="form-group border-bottom">
                            {{ $title }}
                            <div class="table-responsive">

                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Document Number</th>
                                            <th>Customer</th>
                                            <th>Delivery Date</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0 @endphp
                                        @foreach ($rolists as $rolist)
                                            <tr>
                                                <td class=""> {{ $rolist->docno }}</td>
                                                <td class=""> {{ $rolist->Customer }}</td>
                                                <td class=""> {{ $rolist->deliver_date }}</td>
                                                <td class="text-right"> {{ number_format($rolist->total, 2) }}</td>
                                            </tr>
                                            @php $total += $rolist->total @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="3">{{ $rolists->links() }}</td>

                                        </tr>
                                    </tbody>

                                </table>
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
