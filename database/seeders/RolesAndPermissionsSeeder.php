<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seeds the database with roles and permissions
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'process tickets']);
        Permission::create(['name' => 'generate tickets']);

        Role::create(['name' => 'user']);

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['process tickets', 'generate tickets']);
    }
}
