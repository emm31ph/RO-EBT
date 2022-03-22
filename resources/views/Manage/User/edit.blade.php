@extends('layouts.manage.app')
@push('css')
@endpush
@section('breadcrumbs')
  @if($user->id == Auth::user()->id)
<li class="breadcrumb-item">Profile</li>
       @else
    <li class="breadcrumb-item"><a href="{{ route('manage.user.index') }}">User</a></li>
    @endif
    <li class="breadcrumb-item">Settings </li>
@endsection
@section('content')
    <div class="container">
         <div class="card border border-primary">
             <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title">
                        @if($user->id == Auth::user()->id)
                        Profile Update
                        @else
                        Edit User
                        @endif
                            
                        </h3>
                    </div>
                    @if($user->id != Auth::user()->id)
                    <div class="col-2">
                        <ul class="navbar-nav float-right">
                            <li class="nav-item dropdown">
                                <a id="my-dropdown" class="nav-link  dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Options
                                </a>
                                 @permission('users-create','users-read')
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                   @permission('users-create')  
                                    <a class="dropdown-item" href="{{ route('manage.user.create') }}">Create User</a>
                                    @endpermission
                                      @permission('users-read') 
                                    @if ($user->status != '99')
                                        <a class="dropdown-item" href="{{ route('manage.user.show', $user->id) }}">View
                                            User</a>
                                    @endif
                                    @endpermission
                                </div>
                                @endpermission
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('manage.user.update', $user->id) }}" method="POST">

                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="row">
                        <div 
                        @if($user->id == Auth::user()->id)
                        class="col-sm-12"
                        @else
                        class="col-sm-6"
                        @endif
                        >

                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" placeholder="Enter name" name="name"
                                    value="{{ old('name', $user->name) }}">
                                @error('name') <code>{{ $message }}</code> @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Username:</label>
                                <input type="text" class="form-control" placeholder="Enter username" name="username"
                                    @if($user->id == Auth::user()->id)
                                        readonly
                                    @endif
                                    value="{{ old('username', $user->username) }}">
                                @error('username') <code>{{ $message }}</code> @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control" placeholder="Enter email" name="email"
                                    value="{{ old('email', $user->email) }}">
                                @error('email') <code>{{ $message }}</code> @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Change Password</label>
                                <input type="checkbox" v-on:click="seen = !seen" name="chngpass">
                            </div>
                            <div class="form-group" v-if="seen">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" placeholder="Enter password" name="password">
                                @error('password') <code>{{ $message }}</code> @enderror
                                </>

                            </div>
                        </div>
                        <input type="hidden" name="roles" :value="rolesSelected" />
                        @if ($user->id != Auth::user()->id)
                            <div class="col-sm-6">
                                <label for="roles" class="label">Roles:</label>
                                <input type="hidden" name="roles" :value="rolesSelected" />

                                @foreach ($roles as $role)
                                    <div class="form-check">
                                        {{ Form::checkbox("roles[$role->id]", $role->id, old("roles[$role->id]"), ['id' => 'asap' , 'v-model' => 'rolesSelected']) }}
                                        <label class="form-check-label" for="exampleCheck1">{{ $role->display_name }}</label>
                                    </div>
                                @endforeach
                                @error('roles') <code>{{ $message }}</code> @enderror
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    
                    {{ Form::close() }}
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
        new Vue({
            el: '#app',
            data: {
                seen: false,
                default_password: true,
                rolesSelected: {!! $user->roles->pluck('id') !!}
                 
            }
        })

    </script>

@endpush
