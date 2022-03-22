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
                            Create User
                        </h3>
                    </div>
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link  dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                 @permission('users-read')  
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                        <a class="dropdown-item" href="{{ route('manage.user.index') }}">User List</a>
                                    </div>
                                @endpermission
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'manage.user.store', 'id' => 'userForm', 'role' => 'form']) !!}
                <div class="row">
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name"
                                value="{{ old('name') }}">
                            @error('name') <code>{{ $message }}</code> @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Username:</label>
                            <input type="text" class="form-control" placeholder="Enter username" name="username"
                                value="{{ old('username') }}">
                            @error('username') <code>{{ $message }}</code> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email address:</label>
                            <input type="email" class="form-control" placeholder="Enter email" name="email"
                                value="{{ old('email') }}">
                            @error('email') <code>{{ $message }}</code> @enderror
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" placeholder="Enter password" name="password">
                            @error('password') <code>{{ $message }}</code> @enderror
                        </div>

                    </div>
                    <div class="col-sm-6">

                        <label for="roles" class="label">Roles:</label>
                        <input type="hidden" name="roles" :value="rolesSelected" />

                        @foreach ($roles as $role) 
                            <div class="form-check">
                                {{ Form::checkbox("roles[$role->id]", $role->id, old("roles[$role->id]"), ['id' => 'asap']) }}
                                <label class="form-check-label" for="exampleCheck1">{{ $role->display_name }}</label>
                            </div>
                        @endforeach
                        @error('roles') <code>{{ $message }}</code> @enderror
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div> 
             <div class="card-footer bg-primary text-white">
                &nbsp;
            </div>
        </div>
    </div>
@endsection
@push('js')


    <script src="{{ asset('/js/vue.min.js') }}"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                default_password: true,
                rolesSelected: [{!!old('roles') ? old('roles') : ''!!}]
            }
        });

    </script>
@endpush
