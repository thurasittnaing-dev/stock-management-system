<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    protected $fillable = ['name', 'module', 'guard_name'];

    public static function store_data($request)
    {
        // check crud mode off
        if (!$request->crud_mode) {
            Permission::create([
                'name' => $request->name,
                'module' => $request->module,
                'guard_name' => 'web',
            ]);

            return redirect()->route('permission.index')->with('success', 'Created successfully');
        }

        $operations = ['-list', '-edit', '-create', '-delete'];
        // Check string contains ","
        if (str_contains($request->name, ',')) {
            $nameArray = explode(",", $request->name);

            foreach ($nameArray as $name) {
                $name = trim($name);


                foreach ($operations as $operation) {
                    $permission = Permission::where('name', $name . $operation)->first();
                    Permission::create([
                        'name' => $name . $operation,
                        'module' => $name,
                        'guard_name' => 'web',
                    ]);
                }
            }

            return redirect()->route('permission.index')->with('success', 'Created successfully');
        } else {
            // Condition without ","
            foreach ($operations as $operation) {
                Permission::create([
                    'name' => $request->name . $operation,
                    'module' => $request->module,
                    'guard_name' => 'web',
                ]);
            }
            return redirect()->route('permission.index')->with('success', 'Created successfully');
        }
    }
}