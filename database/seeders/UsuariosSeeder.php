<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Crear el segundo usuario y asignarle un rol en una línea
        User::create([
            'name' => 'Daniel Castedo',
            'email' => 'daniel@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('ejecutivo'); // Asignar rol directamente después de la creación
        // Crear el segundo usuario y asignarle un rol en una línea
        User::create([
            'name' => 'Miguel Calvimontes',
            'email' => 'miguel@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('general'); // Asignar rol directamente después de la creación
        User::create([
            'name' => 'Natalia',
            'email' => 'natalia@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('secretario'); // Asignar rol directamente después de la creación
        User::create([
            'name' => 'Andres',
            'email' => 'andres@gmail.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('vocal'); // Asignar rol directamente después de la creación
    }
}
