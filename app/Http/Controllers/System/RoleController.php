<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['permission:edit roles|create roles']);
    }

    public function index()
    {
        $roles = Role::all();
        return view('system.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('system.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['name'] = $request->name;
        $data['guard_name'] = Auth::getDefaultDriver();
        $role = Role::create($data);
        foreach ($request->permissions as $permission) {
            $role->givePermissionTo($permission);
        }
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('system.role.edit', compact('permissions', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $data['name'] = $request->name;
        $data['guard_name'] = Auth::getDefaultDriver();
        $role->update($data);

        $old_permissions = $role->permissions->pluck('name');

        foreach ($old_permissions as $old_permission) {
            $role->revokePermissionTo($old_permission);
        }

        foreach ($request->permissions as $permission) {
            $role->givePermissionTo($permission);
        }
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $permissions[] = $role->permissions->pluck('name');
        foreach ($permissions as $permission) {
            $role->revokePermissionTo($permission);
        }
        $checkUsers = User::role($role->name)->get();
        if (!$checkUsers) {
            $role->delete();
            return redirect()->route('roles.index');
        } else {
            return redirect()->route('roles.index')->with('message', 'Role Cannot Be Deleted Because It Contains Related User(s).');
        }
    }
}
