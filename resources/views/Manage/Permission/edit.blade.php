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
                            Edit Permission
                        </h3>
                    </div>
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link  dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                    @permission('acl-read', 'acl-create')
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                        @permission('acl-create')
                                            <a class="dropdown-item" href="{{ route('manage.permission.create') }}">Create
                                                Permission</a>
                                            @endpermission
                                            @permission('acl-read')
                                                <a class="dropdown-item"
                                                    href="{{ route('manage.permission.show', $permission->id) }}">View
                                                    Permission</a>
                                                @endpermission
                                            </div>
                                            @endpermission
                                        </li>
                                    </ul>
                                </div>
                    </div>
                    </div>
                        <div class="card-body">

                            <form action="{{ route('manage.permission.update', $permission->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <div class="field">
                                    <label for="display_name" class="label">Name (Display Name)</label>
                                    <p class="control">
                                        <input type="text" class="form-control" name="display_name" id="display_name"
                                            value="{{ $permission->display_name }}">
                                    </p>
                                </div>

                                <div class="field">
                                    <label for="name" class="label">Slug <small>(Cannot be changed)</small></label>
                                    <p class="control">
                                        <input type="text" class="form-control" name="name" id="name" value="{{ $permission->name }}"
                                            disabled>
                                    </p>
                                </div>

                                <div class="field">
                                    <label for="description" class="label">Description</label>
                                    <p class="control">
                                        <input type="text" class="form-control" name="description" id="description"
                                            placeholder="Describe what this permission does" value="{{ $permission->description }}">
                                    </p>
                                </div>

                                <button class="btn btn-sm btn-primary">Save Changes</button>
                            </form>
                        </div>
                        <div class="card-footer bg-primary">
                            &nbsp;
                        </div>
                    </div>
                </div>
            @endsection
            @push('js')

            @endpush
