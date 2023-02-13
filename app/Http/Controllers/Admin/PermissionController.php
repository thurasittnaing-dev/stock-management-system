<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionStoreRequest;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $permissions = Permission::select('name', 'module')->groupBy('name');
        $count = $permissions->count();
        $permissions = $permissions->get();
        $permissions = $this->arrange_data($permissions);

        return view('backend.permission.index', compact('permissions', 'count'));
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.permission./create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionStoreRequest $request)
    {
        //
        // dd($request->all());
        Permission::store_data($request);
        return redirect()->route('permission.index')->with('success', 'Created success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    public function permission_update(Request $request)
    {
        $permission = Permission::where('name', $request->old_name)->first();

        if (is_null($permission)) {
            // empty permission
            return redirect()->back()->with('error', 'Something went wrong!');
        }

        $permission->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'Permission Updated');
    }

    public function permission_delete(Request $request)
    {
        $permission = Permission::where('name', $request->name)->first();

        if (is_null($permission)) {
            // empty permission
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong!'
            ]);
        }

        $permission->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Deleted Success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }
}