@extends('layouts.manage.app')
@push('css')
@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('manage.role.index') }}">Roles</a></li>
    <li class="breadcrumb-item">Settings </li>
@endsection
@section('content')
    <div class="container">
         <div class="card border border-primary">
             <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title">
                            Roles List
                        </h3>
                    </div>
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link  dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>

                                @permission('acl-create', 'ac-read')
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                        @permission('acl-create')
                                            <a class="dropdown-item" href="{{ route('manage.role.create') }}">Create
                                                Role</a>
                                            @endpermission
                                            @permission('acl-read')
                                                <a class="dropdown-item" href="{{ route('manage.permission.index') }}">View
                                                    Permissions</a>
                                                @endpermission
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

                                @foreach ($roles as $role)
                                    <div class="card m-1" style="width: 16rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $role->display_name }}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted"><em>{{ $role->name }}</em></h6>
                                            <p class="card-text">{{ $role->description }}</p>

                                        </div>
                                        <div class="card-body d-flex justify-content-between">
                                            @if (Auth::user()->hasPermission(['acl-read']))
                                                <div class="column is-one-half">
                                                    <a href="{{ route('manage.role.show', $role->id) }}"
                                                        class="button is-primary is-fullwidth">Details</a>
                                                </div>
                                            @endif
                                            @if (Auth::user()->hasPermission(['acl-update']))
                                                <div class="column is-one-half">
                                                    <a href="{{ route('manage.role.edit', $role->id) }}"
                                                        class="button is-light is-fullwidth">Edit</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer bg-primary">
                            &nbsp; {{ $roles->links() }}
                        </div>
                    </div>
                </div>
            @endsection
            @push('js')

            @endpush
