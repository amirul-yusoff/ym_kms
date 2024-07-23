<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $title = 'Roles Management';
        $url = 'admin/roles';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
        ];
        $roles = Role::all();

        return view('admin.role.index', compact('title', 'breadcrumb', 'url', 'roles'));
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $title = 'Role';
        $action = 'Create';
        $url = 'admin/roles';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
            [
                'name'=>$action. ' ' .$title,
                'url'=>$url
            ],
        ];
        $permissionLists = Permission::get()->pluck('name', 'name');

        return view('admin.role.create', compact('title', 'breadcrumb', 'url', 'permissionLists'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolesRequest $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $role = Role::create($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->givePermissionTo($permissions);

        return redirect()->route('admin.roles.index');
    }


    /**
     * Show the form for editing Role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $title = 'Role';
        $action = 'Edit';
        $url = 'admin/roles';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
            [
                'name'=>$action. ' ' .$title,
                'url'=>$url
            ],
        ];
        $permissionLists = Permission::get()->pluck('name', 'name');

        return view('admin.role.edit', compact('title', 'breadcrumb', 'url', 'role', 'permissionLists'));
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolesRequest $request, Role $role)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $role->update($request->except('permission'));
        $permissions = $request->input('permission') ? $request->input('permission') : [];
        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index');
    }

    public function show(Role $role)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $title = 'Role';
        $action = 'View';
        $url = 'admin/roles';
        $breadcrumb = [
            [
                'name'=>$title,
                'url'=>$url
            ],
            [
                'name'=>$action. ' ' .$title,
                'url'=>$url
            ],
        ];
        $role->load('permissions');

        return view('admin.role.show', compact('title', 'breadcrumb', 'url', 'role'));
    }


    /**
     * Remove Role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $role->delete();

        return redirect()->route('admin.roles.index');
    }

    /**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        Role::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

}