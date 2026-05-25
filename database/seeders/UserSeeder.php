<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['ci' => '1000001'],
            [
                'nombre' => 'Administrador',
                'apellido_paterno' => 'Sistema',
                'apellido_materno' => 'General',
                'username' => 'admin',
                'password' => Hash::make('admin123*'),
                'role' => 'admin',
            ]
        );
    }
}