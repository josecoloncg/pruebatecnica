<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios de la Tabla 1 del documento
        $usuarios = [
            ['name' => 'Luis', 'email' => 'luis@example.com', 'password' => '0000'],
            ['name' => 'Gabriel', 'email' => 'gabriel@example.com', 'password' => '1111'],
            ['name' => 'Sergio', 'email' => 'sergio@example.com', 'password' => '2222'],
        ];

        foreach ($usuarios as $usuarioData) {
            User::create([
                'name' => $usuarioData['name'],
                'email' => $usuarioData['email'],
                'password' => Hash::make($usuarioData['password']),
            ]);
        }

        // Ejecutar seeders en orden
        $this->call([
            ProyectoSeeder::class,
            BloqueSeeder::class,
            PiezaSeeder::class,
        ]);
    }
}
