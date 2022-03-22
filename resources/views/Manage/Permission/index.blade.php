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
                            Permissions List
                        </h3>
                    </div>
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link  dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                @permission('acl-create')
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                        <a class="dropdown-item" href="{{ route('manage.permission.create') }}">Create
                                            Permission</a>
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
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="th">Name/Code</th>
                                    <th class="th">Display Name</th>
                                    <th class="th">Description</th>
                                    <th class="text-center" style="width: 150px">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td class="td text-sm leading-5 text-gray-900">
                                            {{ $permission->id }}
                                        </td>
                                        <td class="td text-sm leading-5 text-gray-900">
                                            {{ $permission->name }}
                                        </td>
                                        <td class="td text-sm leading-5 text-gray-900">
                                            {{ $permission->display_name }}
                                        </td>
                                        <td class="td text-sm leading-5 text-gray-900">
                                            {{ $permission->description }}
                                        </td>
                                        <td class=" text-center">
                                            @permission('acl-read')
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('manage.permission.show', $permission->id) }}">
                                                    <i class="fa fa-eye m-r-10"></i>
                                                </a>
                                                @endpermission
                                                @permission('acl-update')
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('manage.permission.edit', $permission->id) }}">
                                                        <i class="fa fa-edit m-r-10"></i>
                                                    </a>
                                                @endpermission
                                                @permission('acl-delete')
                                                        <button v-on:click="deletePermission({{ $permission->id }})"
                                                            class="btn btn-danger btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                @endpermission
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        {{ $permissions->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
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

                                },
                                methods: {
                                    deletePermission: function(id) {
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
                                                axios.post('/manage/permissions/' + id, {
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
                                                                    "{{ url()->full() }}";
                                                            }
                                                        });

                                                    })
                                                    .catch(error => {
                                                        //handle failure
                                                        console.log(error);
                                                    })
                                            }
                                        })
                                    }
                                }
                            })

                        </script>
                    @endpush
