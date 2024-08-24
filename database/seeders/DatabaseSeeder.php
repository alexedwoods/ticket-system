<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $max = DB::table('users')->max('id') + 1;
        DB::statement("ALTER TABLE users AUTO_INCREMENT =  $max");

        \App\Models\User::factory(10)->create();
        //\App\Models\Ticket::factory(50)->create();
    }
}
