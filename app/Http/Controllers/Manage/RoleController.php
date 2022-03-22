<?php

namespace App\Http\Controllers\Manage;

use App\Model\Role;
use App\Model\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function __construct()
    {
            $this->middleware('auth');
    }
    
    public function index()
    {
        $roles = Role::paginate(10);
        return view('manage.role.index')->withroles($roles);
    }


    public function create()
    {
        $permissions = Permission::all();

        return view('manage.role.create')->withPermissions($permissions);
    }

    public function store(RoleRequest $request)
    {
         
  
        $role = new Role();
        $role->display_name = $request->display_name;
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        if ($request->permission) {
            $role->syncPermissions($request->permission);
        }

        return redirect()->route('manage.role.index')->with('success', 'successfully insert new role');;
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        // $role->permissions->pluck('id')
        $permissions = Permission::all();

        return view('manage.role.edit')->withrole($role)->withPermissions($permissions);
    }
    public function show($id)
    {
        $role = Role::findOrFail($id);

        return view('manage.role.show')->withrole($role);
    }

    public function update(RoleRequest $request, $id)
    {  

        $role = Role::findOrFail($id); 
        $role->display_name = $request->display_name; 
        $role->description = $request->description;
        $role->save();

        if ($request->permission) {
            $role->syncPermissions( $request->permission);
        }

 

        return redirect()->route('manage.role.index')->withToastSuccess('Successfully update role.');
    }

    public function destroy($id)
    {
        Role::destroy($id);

        return redirect()->route('manage.role.index')->withToastWarning('Successfully delete role.');
    }
}
