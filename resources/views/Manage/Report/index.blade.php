@extends('layouts.manage.app')
@push('css')
@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('manage.role.index') }}">Roles</a></li>
    <li class="breadcrumb-item"><a href="{{ route('manage.permission.index') }}">Permission</a></li>
    <li class="breadcrumb-item">Settings </li>
@endsection
@section('content')
    <div class="container">
         <div class="card border border-primary">
             <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title">
                            Report Item
                        </h3>
                    </div>
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link  dropdown-toggle text-white" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                @permission('acl-create')
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                        <a class="dropdown-item" href="{{ route('report.create') }}">Create
                                            Report Header</a>
                                    </div>
                                    @endpermission
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-3 border-right h-100">
                        @include('manage.sidebar')

                    </div>
                    <div class=" col col-9 card-body d-flex flex-wrap">
                        <div class="row">
                        
                       
                        </div>

                        <div class="col-md-12">
                            <table class="table">
                                <thead> 
                                        <th>@sortablelink('header1','header', ['filter' => 'active, visible'])</th>
                                        <th>@sortablelink('header2','sub-header', ['filter' => 'active, visible'])</th>
                                        <th>@sortablelink('header3','item header', ['filter' => 'active, visible'])</th>
                                        <th>@sortablelink('itemcode','Itemcode', ['filter' => 'active, visible'])</th>
                                        <th>@sortablelink('type','Section', ['filter' => 'active, visible'])</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                        
                                    <tr>
                                        <td>{{ $data->header1 }}</td>
                                        <td>{{ $data->header2 }}</td>
                                        <td>{{ $data->header3 }}</td>
                                        <td>{{ $data->itemcode }}</td>
                                        <td>{{ ($data->type=='00001')?'1st Section':'2nd Section' }}</td>
                                        <td class=" text-center">       
                                                                        
                                     @permission('report items-update')  
                                             <a class="btn btn-primary btn-sm"
                                                 href="{{ route('report.edit', $data->id) }}">
                                                 <i class="fa fa-edit m-r-10"></i>
                                             </a>
                                          
                                     @endpermission
                                     @permission('report items-delete') 
                                         <button v-on:click="deleteUser({{ $data->id }})" class="btn btn-danger btn-sm">
                                             <i class="fa fa-trash"></i>
                                         </button>
                                     @endpermission


                                 </td>
                                    </tr>
                                    @endforeach
                                     <tfoot>
                                         <tr>
                                             <td colspan="6">{{ $datas->links() }}</td>
                                         </tr>
                                     </tfoot>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-primary">
                    &nbsp;
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
                 deleteUser: function(id) {
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
                             axios.post('/report/' + id, {
                                     _method: 'DELETE'
                                 })
                                 .then(response => {
                                     Swal.fire({
                                         title: "Deleted!",
                                         text: "Your imaginary file has been deleted.",
                                         icon: 'success',
                                         confirmButtonText: 'OK'
                                     }).then((result) => {
                                         if (result.isConfirmed) {
                                             window.location.href =
                                                 "{{ route('report.index') }}";
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
