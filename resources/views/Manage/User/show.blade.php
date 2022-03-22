@extends('layouts.manage.app')
@push('css')
@endpush
@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('manage.user.index') }}">User</a></li>
    <li class="breadcrumb-item">Settings </li>
@endsection
@section('content')
    <div class="container">
         <div class="card border border-primary">
             <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title">
                            View User
                        </h3>
                    </div>
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link  dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                       @permission('users-create')
                                    <a class="dropdown-item" href="{{ route('manage.user.create') }}">Create User</a>
                                    @endpermission
                                    @permission('users-update')
                                    @if ($user->status != '99')
                                        <a class="dropdown-item" href="{{ route('manage.user.edit', $user->id) }}">Edit
                                            User</a>
                                    @endif
                                    @endpermission
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{ Form::model($user, ['route' => ['manage.user.update', $user->id], 'method' => 'PUT', 'id' => 'userForm']) }}
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" placeholder="Enter name" name="name"
                        value="{{ old('name', $user->name) }}" readonly>
                    @error('name') <code>{{ $message }}</code> @enderror
                </div>
                <div class="form-group">
                    <label for="name">Username:</label>
                    <input type="text" class="form-control" placeholder="Enter username" name="username"
                        value="{{ old('username', $user->username) }}" readonly>
                    @error('username') <code>{{ $message }}</code> @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" placeholder="Enter email" name="email"
                        value="{{ old('email', $user->email) }}" readonly>
                    @error('email') <code>{{ $message }}</code> @enderror
                </div>
                {{ Form::close() }}
            </div>
             <div class="card-footer bg-primary text-white">
                &nbsp;
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
