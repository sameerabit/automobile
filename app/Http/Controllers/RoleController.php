<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
        $query = Role::query();
        if ($request->has('q') && $request->q) {
            $query->where('name', 'like', "%$request->q%");
        }
        $roles = $query->paginate(15);

        return view('role.index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = new Role();

        return view('role.create', [
            'role'        => $role,
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions);

        return redirect()->route('roles.edit', $role->id)->with(
            ['success' => 'Role Saved Successfully']
         );
    }

    /**
     * Display the specified resource.
     *
     * @param int  $id
     * @param Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('role.show', [
            'role'        => $role,
            'permissions' => Permission::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int  $id
     * @param Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('role.edit', [
            'role'            => $role,
            'permissions'     => Permission::all(),
            'rolePermissions' => $role->permissions()->get()->pluck('name')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @param Role                     $role
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $role->fill($request->all());
        $role->save();
        $role->fresh();
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.edit', $role->id)->with(
           ['success' => 'Role Updated Successfully']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     * @param Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index', $role->id)->with(
            ['success' => 'Role Deleted Successfully']
         );
    }
}
