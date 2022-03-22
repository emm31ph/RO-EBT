 @extends('layouts.manage.app')
 @push('css')

 @endpush
 @section('breadcrumbs')
     <li class="breadcrumb-item"><a href="{{ route('manage.user.index') }}">Users</a></li>
     <li class="breadcrumb-item">Settings </li>
 @endsection
 @section('content')
     <div class="container">
         <div class="card border border-primary">
             <div class="card-header bg-primary text-white">
                 <div class="row">
                     <div class="col-10">
                         <h3 class="card-title">
                             Users List
                         </h3>
                     </div>
                     <div class="col-2">
                         <ul class="navbar-nav float-right">
                             <li class="nav-item dropdown">
                                 <a id="my-dropdown" class="nav-link  dropdown-toggle" data-toggle="dropdown"
                                     aria-haspopup="true" aria-expanded="false">
                                     Options
                                 </a>
                                    @permission('users-create') 
                                     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="my-dropdown">
                                         <a class="dropdown-item" href="{{ route('manage.user.create') }}">Create User</a>
                                     </div>
                                     @endpermission                            
                             </li>
                         </ul>
                     </div>
                 </div>
             </div>
             <div class="card-body">
                 <table class="table table-sm table-hover table-striped">
                     <thead>
                         <tr>
                             <th>ID</th>
                             <th>Name</th>
                             <th>Username</th>
                             <th>Email</th>
                             <th>Status</th>
                             <th class="text-center" style="width: 150px">Action</th>
                         </tr>
                     </thead>

                     <tbody>

                         @foreach ($users as $user)
                             <tr>
                                 <td>{{ $user->id }}</td>
                                 <td>{{ $user->name }}</td>
                                 <td>{{ $user->username }}</td>
                                 <td>{{ $user->email }}</td>
                                 <td>
                                     @if ($user->status == '01')
                                         <span class="badge badge-success">Active</span>
                                     @else
                                         <span class="badge badge-warning">Inactive</span>
                                     @endif
                                 </td>
                                 <td class=" text-center">
                                     @permission('users-read') 
                                         <a class="btn btn-success btn-sm"
                                             href="{{ route('manage.user.show', $user->id) }}">
                                             <i class="fa fa-eye m-r-10"></i>
                                         </a>
                                   @endpermission                                     
                                     @permission('users-update') 
                                         @if ($user->status != '99')
                                             <a class="btn btn-primary btn-sm"
                                                 href="{{ route('manage.user.edit', $user->id) }}">
                                                 <i class="fa fa-edit m-r-10"></i>
                                             </a>
                                         @endif
                                     @endpermission
                                     @permission('users-delete') 
                                         <button v-on:click="deleteUser({{ $user->id }})" class="btn btn-danger btn-sm">
                                             <i class="fa fa-trash"></i>
                                         </button>
                                     @endpermission


                                 </td>
                             </tr>
                         @endforeach

                     </tbody>
                 </table>
             </div>
             <div class="card-footer bg-primary text-white">
                 &nbsp; {{ $users->links() }}
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
                             axios.post('/manage/users/' + id, {
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
                                                 "{{ route('manage.user.index') }}";
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
