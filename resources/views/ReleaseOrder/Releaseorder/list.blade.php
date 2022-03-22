@extends('layouts.manage.app')
@push('css')

@endpush
@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('ro.index') }}">Release Order</a></li>
@endsection
@section('content')
<div class="">
    <div class="card my-1">
        <div class="card-body">
            <div class="row">
                <div class="col col-3 border-right h-100">
                    @include('ReleaseOrder.Releaseorder.rosidebar')
                </div>
                <div class="col col-9">
                    <nav>
                        <div class="nav nav-sm nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link @if(request()->unprocess || !request()->process) active @endif" id="nav-unprocess-tab" data-toggle="tab" href="#nav-unprocess" role="tab" aria-controls="nav-unprocess" aria-selected="true">Un-process</a>
                            <a class="nav-item nav-link  @if(request()->process) active @endif" id="nav-process-tab" data-toggle="tab" href="#nav-process" role="tab" aria-controls="nav-process" aria-selected="false">Process</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade  @if(!request()->process || (request()->unprocess)) show active @endif " id="nav-unprocess" role="tabpanel" aria-labelledby="nav-unprocess-tab">
                            <div class="form-group border-bottom">
                                <div class="table-responsive">
                                    {{$processDataTable->table()}}

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

<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>


{{$processDataTable->scripts()}}
{{-- {{$unprocessDataTable->scripts()}} --}}


@endpush
