<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
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
        $query = Permission::query();
        if ($request->has('q') && $request->q) {
            $query->where('name', 'like', "%$request->q%");
        }
        $permissions = $query->paginate(15);

        return view('permission.index', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = new Permission();

        return view('permission.create', [
            'permission' => $permission,
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
        $permission = Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.show', $permission->id)->with(
            ['success' => 'Permission Saved Successfully']
         );
    }

    /**
     * Display the specified resource.
     *
     * @param int        $id
     * @param Permission $permission
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return view('permission.show', [
            'permission' => $permission,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int        $id
     * @param Permission $permission
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('permission.edit', [
            'permission' => $permission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @param Permission               $permission
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $permission->fill($request->all());
        $permission->save();
        $permission->fresh();

        return redirect()->route('permissions.show', $permission->id)->with(
           ['success' => 'Permission Updated Successfully']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int        $id
     * @param Permission $permission
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index', $permission->id)->with(
            ['success' => 'Permission Deleted Successfully']
         );
    }
}
