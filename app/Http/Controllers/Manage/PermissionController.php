<?php

namespace App\Http\Controllers\Manage;

use App\Http\Requests\PermissionRequest;
use App\Http\Controllers\Controller;
use App\Model\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('manage.permission.index')->withpermissions($permissions);
        
    }


    public function create()
    {
        return view('manage.permission.create');
    
    }

    public function store(PermissionRequest $request)
    {
        // $permission = Permission::create($request->all());
        if($request->permissionvalue=='basic'){
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->display_name = $request->display_name;
            $permission->description = $request->description;
            $permission->save();
        }
        
        if($request->permissionvalue=='crud'){
         $crud = explode(',', $request->crud_selected);
            if (count($crud) > 0) {
                foreach ($crud as $x) {
                    $slug = strtolower($x) . '-' . strtolower($request->resource);
                    $display_name = ucwords($x . " " . $request->resource);
                    $description = "Allows a user to " . strtoupper($x) . ' a ' . ucwords($request->resource);

                    $permission = new Permission();
                    $permission->name = $slug;
                    $permission->display_name = $display_name;
                    $permission->description = $description;
                    $permission->save();
                }
                
            }
        }

           return redirect()->route('manage.permission.index')->with('success', 'successfully inser new permission');;
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('manage.permission.edit')->withpermission($permission);
        
    }
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

          return view('manage.permission.show')->withpermission($permission);
        
    
    }

    public function update(PermissionRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($request->all());
        
        return redirect()->route('manage.permission.index')->withToastSuccess('Successfully update permission.');
       
    }

    public function destroy($id)
    {
        Permission::destroy($id); 
       //return back()->with('success','Post deleted successfully');
         return back()->withToastWarning('Successfully delete permission.');
       
    }
}