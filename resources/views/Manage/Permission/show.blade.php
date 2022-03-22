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
                            View Permission
                        </h3>
                    </div>
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link  dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                @permission('acl-create','acl-update')
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                    @permission('acl-create')
                                    <a class="dropdown-item" href="{{ route('manage.permission.create') }}">Create Permission</a>
                                    @endpermission
                                    @permission('acl-update')
                                    <a class="dropdown-item" href="{{ route('manage.permission.edit', $permission->id) }}">Edit Permission</a>
                                @endpermission
                                </div>
                                @endpermission
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p>
                  <strong>{{$permission->display_name}}</strong> <small>{{$permission->name}}</small>
                  <br>
                  {{$permission->description}}
                </p>
            </div>
            <div class="card-footer bg-primary">
                &nbsp;
            </div>
        </div>
    </div>
@endsection
@push('js')
    
@endpush
