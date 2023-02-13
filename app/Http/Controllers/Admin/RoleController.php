<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::orderBy('id', 'ASC')->paginate(10);
        return view('backend.role.index', compact('roles'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permissions = Permission::select('name', 'module')->groupBy('name');
        $permissions = $permissions->get();
        $permissions = $this->arrange_data($permissions);
        return view('backend.role.create', compact('permissions'));
    }

    public function arrange_data($data)
    {
        $result = [];
        foreach ($data as $permission) {
            if (!array_key_exists($permission->module, $result)) {

                $result[$permission->module] = [
                    'list' => '',
                    'create' => '',
                    'edit' => '',
                    'delete' => '',
                    'export' => '',
                ];

                // check list or not
                if (str_contains($permission->name, '-list')) {
                    $result[$permission->module]['list'] = $permission->name;
                }
                // check create or not
                if (str_contains($permission->name, '-create')) {
                    $result[$permission->module]['create'] = $permission->name;
                }
                // check edit or not
                if (str_contains($permission->name, '-edit')) {
                    $result[$permission->module]['edit'] = $permission->name;
                }
                // check delete or not
                if (str_contains($permission->name, '-delete')) {
                    $result[$permission->module]['delete'] = $permission->name;
                }
                // check export or not
                if (str_contains($permission->name, '-export')) {
                    $result[$permission->module]['export'] = $permission->name;
                }
            } else {
                // check list or not
                if (str_contains($permission->name, '-list')) {
                    $result[$permission->module]['list'] = $permission->name;
                }
                // check create or not
                if (str_contains($permission->name, '-create')) {
                    $result[$permission->module]['create'] = $permission->name;
                }
                // check edit or not
                if (str_contains($permission->name, '-edit')) {
                    $result[$permission->module]['edit'] = $permission->name;
                }
                // check delete or not
                if (str_contains($permission->name, '-delete')) {
                    $result[$permission->module]['delete'] = $permission->name;
                }
                // check export or not
                if (str_contains($permission->name, '-export')) {
                    $result[$permission->module]['export'] = $permission->name;
                }
            }
        }

        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        //
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('role.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role = Role::findorfail($id);

        $permissions = Permission::select('name', 'module')->groupBy('name');
        $permissions = $permissions->get();
        $permissions = $this->arrange_data($permissions);

        return view('backend.role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        //
        $role = Role::findorfail($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('role.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('role.index')->with('success', 'Deleted successfully');
    }
}