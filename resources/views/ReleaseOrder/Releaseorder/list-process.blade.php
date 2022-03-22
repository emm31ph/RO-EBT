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
                <div class="col col-3 border-right h-100">
                    @include('ReleaseOrder.Releaseorder.rosidebar')
                </div> 
                <div class="col col-9">
                    <h4>Process List</h4>
                    {{$processDataTable->table(['class' => 'table table-sm', 'id' => 'table-id'])}}

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
