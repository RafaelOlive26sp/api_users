<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'privilege_id' => '1'
        ]);
        User::factory()->create([
            'name' => 'atendente',
            'email' => 'attend@admin.com',
            'password' => Hash::make('password'),
            'privilege_id' => '2'
        ]);
        for ($i = 1; $i <= 10; $i++) {
            User::factory()->create([
                'name' => 'user' . $i, // Nome único para cada usuário
                'email' => 'user' . $i . '@example.com', // Email único para cada usuário
                'password' => Hash::make('password'), // Senha padronizada, mas pode ser personalizada
                'privilege_id' => 3, // Usuário comum
            ]);
        }
    //    DB::table('access_privileges')->insert([
    //        ['privileges' => 'Admin'],
    //        ['privileges' => 'Attendant'],
    //        ['privileges' => 'Client'],
    //    ]);
    }
}
