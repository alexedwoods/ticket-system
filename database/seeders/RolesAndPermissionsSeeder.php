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

        Permission::create(['name' => 'view ticket stats']);
        Permission::create(['name' => 'view any user tickets']);

        Role::create(['name' => 'user']);

        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['view ticket stats', 'view any user tickets']);
    }
}
