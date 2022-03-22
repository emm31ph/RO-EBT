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

                        <div class="row">

                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="image-flip">
                                    <div class="mainflip flip-0">
                                        <div class="frontside">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <p></p>
                                                    <h4 class="card-title">Un-process</h4>
                                                @if ( $counts['undelivered'] != 0)
                                                     <h4>{{ $counts['undelivered'] }}</h4>
                                                @endif
                                                   
                                                    <a href="{{ route('release.listUnprocess') }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                             <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="image-flip">
                                    <div class="mainflip flip-0">
                                        <div class="frontside">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <p></p>
                                                    <h4 class="card-title">Process</h4>
                                                    {{-- <h4>{{ $counts['process'] }}</h4> --}}
                                                    <a href="{{ route('release.listProcess') }}"
                                                        alt="asdasd"
                                                        class="btn btn-success btn-sm"><i class="fa fa-bar-chart "></i></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                             <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="image-flip">
                                    <div class="mainflip flip-0">
                                        <div class="frontside">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <p></p>
                                                    <h4 class="card-title">Delivered</h4> 
                                                    <h4>
                                                        {{-- {{ $counts['delivered'] }} --}}
                                                    </h4>
                                                    <a href="{{ route('release.delivery') }}"
                                                        class="btn btn-info btn-sm"><i class="fa fa-truck  text-white" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
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
