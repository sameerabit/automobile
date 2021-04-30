<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if(!Auth::user()->can('manager user')) {
        //     return back()->with([
        //         'danger' => 'Permission Denied'
        //     ]);
        // }
        $query = User::query();
        if ($request->has('q') && $request->q) {
            $query->where('name', 'like', "%$request->q%");
        }
        $users = $query->paginate(15);

        return view('auth.index', [
            'users' => $users,
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('auth.edit', [
            'user' => $user,
            "roles" => $roles,
        ]);
    }

    public function update(User $user, Request $request)
    {
        $user->assignRole(Role::findById($request->role_id)->name);
        return back();
    }

}
