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
        User::create([
            'nombre' => 'Administrador',
            'apellido_paterno' => 'Sistema',
            'apellido_materno' => 'General',
            'ci' => '1000001',
            'username' => 'admin',
            'password' => 'admin123*',
            'role' => 'admin',
        ]);
    }
}