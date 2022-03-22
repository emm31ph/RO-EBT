<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Model\Role;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if (!Auth::user()->hasPermission(['users-read'])) {
            return redirect()->back()->withToastWarning("unable to access");
        }
        $users = User::where('id', '!=', Auth::user()->id)->paginate(15);

        return view('manage.user.index')->withusers($users);

        
        return User::get();

    }

    public function create()
    {
        if (!Auth::user()->hasPermission(['users-create'])) {
            return redirect()->back()->withToastWarning("unable to access");
        }

        $roles = Role::all();

        return view('manage.user.create')->withRoles($roles);

    }

    public function store(UserRequest $request)
    {

        if (!Auth::user()->hasPermission(['users-create'])) {
            return redirect()->back()->withToastWarning("unable to access");
        }

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            if ($request->roles) {
                $user->syncRoles($request->roles);
            }
            return redirect()->route('manage.user.index')->withToastSuccess('successfully insert new user');
        }
    }

    public function edit($id)
    {

        if (!Auth::user()->hasPermission(['users-update', 'profile-update'])) {
            return redirect()->back()->withToastWarning("unable to access");
        }

        if (($id == Auth::user()->id) && Auth::user()->hasPermission(['profile-update'])) {
            $user = User::where('id', Auth::user()->id)->with('roles')->first();

            $user = User::where('id', $id)->with('roles')->first();
            $roles = Role::all();
            return view('manage.user.edit')->withuser($user)->withRoles($roles);

        } elseif (($id != Auth::user()->id) && Auth::user()->hasPermission(['profile-update']) && !Auth::user()->hasPermission(['users-update'])) {
            return redirect()->back()->withToastWarning("unable to access");

        } else {

            $user = User::where('id', $id)->with('roles')->first();
            $roles = Role::all();
            return view('manage.user.edit')->withuser($user)->withRoles($roles);
        }
    }
    public function show($id)
    {
        if (!Auth::user()->hasPermission(['users-read'])) {
            return redirect()->back()->withToastWarning("unable to access");
        }
            $user = User::findOrFail($id);
        return view('manage.user.show')->withuser($user);

    }

    public function update(UserRequest $request, $id)
    {
        if (!Auth::user()->hasPermission(['users-update'])) {
            return redirect()->back()->withToastWarning("unable to access");
        }
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->chngpass) {
            $user->password = bcrypt($request->password);
        }
        if ($user->save()) {
            if ($id != Auth::user()->id) {
                if ($request->roles) {
                    $user->syncRoles($request->roles);
                }
            }

        }
        return redirect()->route('manage.user.index')->withToastSuccess('Successfully update user.');
    }

    public function destroy($id)
    {
        if (!Auth::user()->hasPermission(['users-delete'])) {
            return redirect()->back()->withToastWarning("unable to access");
        }

        $user = User::findOrFail($id);

        $user->status = '99';
        $user->save();
        return back()->with('success', 'Post deleted successfully');
        //  return redirect()->route('manage.user.index')->withToastWarning('Successfully delete user.');

    }

}
