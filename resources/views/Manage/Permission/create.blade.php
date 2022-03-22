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
                            Create Permission
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
                                        <a class="dropdown-item" href="{{ route('manage.permission.index') }}">Permission
                                            List</a>
                                    </div>
                                @endpermission
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('manage.permission.store') }}" method="POST">
                    {{ csrf_field() }}
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true"
                                v-on:click="permissionType('basic')">Basic Permission</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                role="tab" aria-controls="nav-profile" aria-selected="false"
                                v-on:click="permissionType('crud')">CRUD Permission</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="from-group" v-if="permissionTypeValue == 'basic'">
                                <input type="hidden" name="permissionvalue" value="basic">
                                <label for="display_name" class="label">Name (Display Name)</label>
                                <p class="control">
                                    <input type="text" class="form-control" name="display_name" id="display_name">

                                    @error('display_name') <code>{{ $message }}</code> @enderror
                                </p>
                            </div>

                            <div class="from-group" v-if="permissionTypeValue == 'basic'">
                                <label for="name" class="label">Slug</label>
                                <p class="control">
                                    <input type="text" class="form-control" name="name" id="name">
                                    @error('name') <code>{{ $message }}</code> @enderror
                                </p>
                            </div>

                            <div class="from-group" v-if="permissionTypeValue == 'basic'">
                                <label for="description" class="label">Description</label>
                                <p class="control">
                                    <input type="text" class="form-control" name="description" id="description"
                                        placeholder="Describe what this permission does">
                                </p>
                            </div>


                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                            <div class="form-group" v-if="permissionTypeValue == 'crud'">
                                <input type="hidden" name="permissionvalue" value="crud">
                                <label for="resource">Resource</label>
                                <p class="control">
                                    <input type="text" class="form-control" name="resource" id="resource" v-model="resource"
                                        placeholder="The name of the resource">
                                </p>
                            </div>
                            <div class="form-group" v-if="permissionTypeValue == 'crud'">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="crudSelected" value="create"
                                        name="crud[1]" id="crud[1]">
                                    <label class="form-check-label" for="crud[1]">
                                        Create
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="crudSelected" value="read"
                                        name="crud[2]" id="crud[2]">
                                    <label class="form-check-label" for="crud[2]">
                                        Read
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="crudSelected" value="update"
                                        name="crud[3]" id="crud[3]">
                                    <label class="form-check-label" for="crud[3]">
                                        Update
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="crudSelected" value="delete"
                                        name="crud[4]" id="crud[4]">
                                    <label class="form-check-label" for="crud[4]">
                                        Delete
                                    </label>
                                </div>


                                <input type="hidden" name="crud_selected" :value="crudSelected">

                                <div class="column">
                                    <table class="table" v-if="resource.length >= 3 ">
                                        <thead>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Description</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="item in crudSelected">
                                                <td v-text="crudName(item)"></td>
                                                <td v-text="crudSlug(item)"></td>
                                                <td v-text="crudDescription(item)"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                    <button class="btn btn-sm btn-success">Create Permission</button>
                </form>
            </div>
            <div class="card-footer bg-primary">
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
                permissionTypeValue: 'basic',
                resource: '',
                crudSelected: ['create', 'read', 'update', 'delete']
            },
            methods: {
                permissionType: function(value) {
                    this.permissionTypeValue = value;
                },
                crudName: function(item) {
                    return item.substr(0, 1).toUpperCase() + item.substr(1) + " " + this.resource.substr(0, 1)
                        .toUpperCase() + this.resource.substr(1);
                },
                crudSlug: function(item) {
                    return item.toLowerCase() + "-" + this.resource.toLowerCase();
                },
                crudDescription: function(item) {
                    return "Allow a User to " + item.toUpperCase() + " a " + this.resource.substr(0, 1)
                        .toUpperCase() + this.resource.substr(1);
                }
            }
        });

    </script>
@endpush
