@extends('layouts.manage.app')
@push('css')
@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('manage.role.index') }}">Role</a></li>
    <li class="breadcrumb-item">Settings </li>
@endsection
@section('content')
    <div class="container">
         <div class="card border border-primary">
             <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title">
                            Create Role
                        </h3>
                    </div>
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link  dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                   @permission('acl-read') 
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                          @permission('acl-read') 
                                            <a class="dropdown-item" href="{{ route('manage.role.index') }}">Role List</a>
                                        @endpermission
                                    </div>
                                @endpermission
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('manage.role.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><b>Role Details:</b></h5>
                                    <div class="form-group">
                                        <label for="display_name">Name (Human Readable)</label>
                                        <input type="text" class="form-control" name="display_name"
                                            value="{{ old('display_name') }}">
                                        @error('display_name') <code>{{ $message }}</code> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Slug (Can not be changed)</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                        @error('name') <code>{{ $message }}</code> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" name="description"
                                            value="{{ old('description') }}">
                                        @error('description') <code>{{ $message }}</code> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><b>Permissions:</b></h5>
                                    <p class="card-text">
                                        @foreach ($permissions as $permission)
                                            <div class="checkbox">
                                                <label>
                                                    {{-- <input type="checkbox"
                                                        name="permission[{{ $i }}]" value="{{ $i }}]">
                                                    --}}
                                                    {{ Form::checkbox("permission[$permission->id]", $permission->id, old("permission[$permission->id]"), ['id' => 'asap']) }}
                                                    {{ $permission->display_name }}
                                                    <em>({{ $permission->description }})</em></label>
                                            </div>
                                        @endforeach

                                    </p>

                                    @error('permission') <code>{{ $message }}</code> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm">Create</button>
                    </div>
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
