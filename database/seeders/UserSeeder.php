<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@email.com')->first();

        // Cria o primeiro admin
        if (!$user) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'password' => bcrypt('123456'),
                'is_admin' => true
            ]);
        }
    }
}
