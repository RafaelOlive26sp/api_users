<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Rafael',
            'email' => 'Rafael@admin.com',
            'password' => bcrypt('password'),
            'privilege_id' => '1'

        ]);
    //    DB::table('access_privileges')->insert([
    //        ['privileges' => 'Admin'],
    //        ['privileges' => 'Attendant'],
    //        ['privileges' => 'Client'],
    //    ]);
    }
}
