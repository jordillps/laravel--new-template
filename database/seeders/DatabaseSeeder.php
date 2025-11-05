<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // $superAdmin = User::firstOrCreate([
        //     'email' => 'jordillps@gmail.com',
        // ], [
        //     'name' => 'Jordi Llobet',
        //     'phone' => '666666666',
        //     'address' => 'Carrer de la Marina, 123',
        //     'city' => 'Barcelona',
        //     'province' => 'Barcelona',
        //     'country' => 'España',
        //     'postal_code' => '08005',
        //     'avatar' => 'https://i.pravatar.cc/300',
        //     'password' => bcrypt('Password123!'), // password actualizada con nueva política
        // ]);
        // $superAdmin->assignRole('super_admin');


        // Ejecutar el seeder de roles y permisos
        $this->call(RolesAndPermissionsSeeder::class);
    }
}
