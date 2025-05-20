<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'nombre' => 'Administrador',
            'correo' => 'admin@servicecenter.com',
            'contraseña' => Hash::make('admin123'),
            'rol' => 'admin',
        ]);
    }
}