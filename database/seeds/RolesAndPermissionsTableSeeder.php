<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // permissions for Admin

        $prsArray = [
            'role-list',            'user-role-list',           'role-create',          'user-role-update',
            'permission-list',      'role-permission-list',     'user-permission-list', 'permission-create',
            'user-list-all',        'user-list',                'user-edit',            'role-permission-update',
            'user-delete',          'setting-list',             'setting-edit',
        ];

        foreach ($prsArray as $p) {
            $prs[] = Permission::findOrCreate($p);
        }

        $role = Role::create(['name' => env('SUPER_ADMIN_ROLE_NAME', "Admin")]);

        $role->syncPermissions($prs);
    }
}
