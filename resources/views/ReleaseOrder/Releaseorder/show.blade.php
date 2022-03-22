@extends('layouts.manage.app')
@push('css')
@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('ro.index') }}">Release Order</a></li>
    <li class="breadcrumb-item">Settings </li>
@endsection
@section('content')
    <div class="container">
         <div class="card border border-primary">
             <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title">
                            Release order

                        </h3>
                    </div>
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                              @permission(['release-create','release-edit']) 
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link text-white  dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                    @permission('release-create') 
                                    <a class="dropdown-item" href="{{ route('ro.create') }}">Create Releaseorder</a>
                                    @endpermission
                                    @permission('release-edit') 
                                    <a class="dropdown-item" href="{{ route('ro.edit', $releaseorder[0]->docno) }}">Edit
                                        Release Order</a>
                                    @endpermission
                                </div>
                            </li>
                              @endpermission     
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-8"><b>{{ $releaseorder[0]->Customer }}</b></div>
                        <div class="col-sm-4 text-center"> <b>{{ $releaseorder[0]->docno }}</b></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8">{{ $releaseorder[0]->Address }}</div>
                        <div class="col-sm-4">

                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex flex-column">
                                        <div class="text-center">{{ $releaseorder[0]->Sales }}</div>
                                        <div class="text-center">{{ $releaseorder[0]->SO_no }}</div>
                                        <div class="text-center">{{ $releaseorder[0]->PO }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex flex-column">
                                        <div class="text-center">{{ $releaseorder[0]->Date }}</div>
                                        <div class="text-center">{{ $releaseorder[0]->PO_no }}</div>
                                        <div class="text-center">{{ $releaseorder[0]->Terms }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">

                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>QTY</th>     
                                <th>Unit</th>
                                <th>Discription</th>
                                <th class="text-right">Unit Price</th>
                                <th class="text-center">Discount</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0;$tqty = 0; @endphp
                            @foreach ($releaseorder as $rolist)
                                <tr>
                                    <td class=""> {{ number_format($rolist->Qty,0) }}</td>
                                    <td> {{ $rolist->Unit }}</td>
                                    <td> {{ $rolist->Description }}</td>
                                    <td class="text-right"> {{ number_format($rolist->Unit_price, 2) }}</td>
                                    <td class="text-center"> {{ number_format($rolist->Line_Discount, 0) }}%
                                    </td>
                                    <td class="text-right"> {{ (number_format(($rolist->Qty*$rolist->Unit_price)-(($rolist->Qty*$rolist->Unit_price)*($rolist->Line_Discount/100)), 2)) }}</td>
                                </tr>
                                 @php 
                                 $total +=($rolist->Qty*$rolist->Unit_price)-(($rolist->Qty*$rolist->Unit_price)*($rolist->Line_Discount/100)); 
                                 $tqty+=$rolist->Qty 
                                 @endphp
                                             
                            @endforeach
                        <tfoot>

                            <tr>
                                <td><b>Total</b></td>
                                <td><b>{{ number_format($tqty, 0) }}</b></td>
                                <td  colspan="4"  class="text-right"> {{ number_format($total, 2) }}</td>
                            </tr>
                        </tfoot>
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="card-footer bg-primary">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">Back</a>
                
                @if ($releaseorder[0]->status=='01' )
                    
                @permission('release-cancel') 
                <button v-on:click="cancelRO('{{ $releaseorder[0]->docno }},cancel')" class="btn btn-warning btn-sm">
                    Cancel 
                </button>    
                @endpermission
                
                @endif
                
                @if ($releaseorder[0]->status=='01' || $releaseorder[0]->status=='00' )
                 @permission('release-delete') 
                <button v-on:click="deleteRO('{{ $releaseorder[0]->docno }},delete')" class="btn btn-danger btn-sm">
                    Delete 
                </button>    
                @endpermission
                
                @endif
            </div>
        </div>
    </div>
@endsection
@push('js')

     <script src="{{ asset('/js/vue.min.js') }}"></script>
     <script>
         new Vue({
             el: '#app',
             data: {
                 seen: false
             },
             methods: {
                 deleteRO: function(id) {
                     Swal.fire({
                         title: 'Are you sure?',
                         text: "You won't be able to revert this!",
                         icon: 'warning',
                         showCancelButton: true,
                         confirmButtonColor: '#3085d6',
                         cancelButtonColor: '#d33',
                         confirmButtonText: 'Yes, delete it!'
                     }).then((result) => {
                         if (result.isConfirmed) {
                             axios.post('/ro/' + id, {
                                     _method: 'DELETE'
                                 })
                                 .then(response => {
                                     Swal.fire({
                                         title: "Deleted!",
                                         text: "The data has been deleted.",
                                         icon: 'success',
                                         confirmButtonText: 'OK'
                                     }).then((result) => {
                                         if (result.isConfirmed) {
                                             window.location.href =
                                                 "{{ url()->previous()  }}";
                                         }
                                     });

                                 })
                                 .catch(error => {
                                     //handle failure
                                     console.log("error");
                                 })
                         }
                     })
                 },

                 cancelRO: function(id) {
                     Swal.fire({
                         title: 'Are you sure?',
                         text: "You want to cancel!",
                         icon: 'warning',
                         showCancelButton: true,
                         confirmButtonColor: '#3085d6',
                         cancelButtonColor: '#d33',
                         confirmButtonText: 'Yes, cancel it!'
                     }).then((result) => {
                         if (result.isConfirmed) {
                             axios.post('/ro/' + id, {
                                     _method: 'DELETE'
                                 })
                                 .then(response => {
                                     Swal.fire({
                                         title: "Canceled!",
                                         text: "The data has been canceled.",
                                         icon: 'success',
                                         confirmButtonText: 'OK'
                                     }).then((result) => {
                                         if (result.isConfirmed) {
                                             window.location.href =
                                                 "{{ url()->previous()  }}";
                                         }
                                     });

                                 })
                                 .catch(error => {
                                     //handle failure
                                     console.log("error");
                                 })
                         }
                     })
                 }
             }
         })

     </script>

 @endpush
