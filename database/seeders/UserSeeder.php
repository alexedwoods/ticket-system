<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset the user ID auto increment counter
        $max = DB::table('users')->max('id') + 1;
        DB::statement("ALTER TABLE users AUTO_INCREMENT =  $max");

        // Create 10 users with the user role
        foreach (range(1, 10) as $i) {
            $user = \App\Models\User::factory()->create([]);
            $user->assignRole('user');
        }

        $user = \App\Models\User::factory()->create([]);
        $user->assignRole('admin');

        $user = \App\Models\User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);
        $user->assignRole('admin');

        $user = \App\Models\User::factory()->create([
            'email' => 'user@user.com',
            'password' => bcrypt('user'),
        ]);
        $user->assignRole('user');
    }
}
