<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos para usuarios
        $userPermissions = [
            'ViewAny:User',
            'View:User',
            'Create:User',
            'Update:User',
            'Delete:User',
            'Restore:User',
            'ForceDelete:User',
            'ForceDeleteAny:User',
            'RestoreAny:User',
            'Replicate:User',
            'Reorder:User',
        ];

        // Crear permisos para roles
        $rolePermissions = [
            'ViewAny:Role',
            'View:Role',
            'Create:Role',
            'Update:Role',
            'Delete:Role',
            'Restore:Role',
            'ForceDelete:Role',
            'ForceDeleteAny:Role',
            'RestoreAny:Role',
            'Replicate:Role',
            'Reorder:Role',
        ];

        // Combinar todos los permisos
        $allPermissions = array_merge($userPermissions, $rolePermissions);

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $usuarioRole = Role::firstOrCreate(['name' => 'Usuario']);
        $escritorRole = Role::firstOrCreate(['name' => 'Escritor']);
        $viewerRole = Role::firstOrCreate(['name' => 'Visor']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor']);

        // Asignar permisos a roles
        $superAdminRole->givePermissionTo($allPermissions); // Super admin tiene todos los permisos
        
        // El rol "Usuario" no tiene permisos especiales (solo puede gestionar su perfil)
        
        // El rol "Escritor" puede editar su propio perfil
        $escritorRole->givePermissionTo(['Update:User']);
        
        // El rol "Viewer" solo puede ver todos los usuarios
        $viewerRole->givePermissionTo(['ViewAny:User', 'View:User']);
        
        // El rol "Editor" puede ver y editar usuarios
        $editorRole->givePermissionTo(['ViewAny:User', 'View:User', 'Update:User']);

        // NOTA: Los permisos del rol "Escritor" se asignarán después de generar los permisos de Shield

        // Crear usuarios de prueba
       $superAdmin = User::firstOrCreate([
            'email' => 'jordillps@gmail.com',
        ], [
            'name' => 'Jordi Llobet',
            'phone' => '666666666',
            'address' => 'Carrer de la Marina, 123',
            'city' => 'Barcelona',
            'province' => 'Barcelona',
            'country' => 'España',
            'postal_code' => '08005',
            'avatar' => 'https://i.pravatar.cc/300',
            'password' => bcrypt('Password123!'), // password actualizada con nueva política
        ]);
        $superAdmin->assignRole('super_admin');


        $usuario = User::firstOrCreate([
            'email' => 'user@example.com'
        ], [
            'name' => 'Usuario Normal',
            'password' => Hash::make('Password123!')
        ]);
        $usuario->assignRole('Escritor'); // Cambiado de 'Usuario' a 'Escritor'

        $viewer = User::firstOrCreate([
            'email' => 'viewer@example.com'
        ], [
            'name' => 'Usuario Viewer',
            'password' => Hash::make('Password123!')
        ]);
        $viewer->assignRole('Visor');

        $editor = User::firstOrCreate([
            'email' => 'editor@example.com'
        ], [
            'name' => 'Usuario Editor',
            'password' => Hash::make('Password123!')
        ]);
        $editor->assignRole('Editor');

        // Generar automáticamente todos los permisos de Shield si no existen
        $this->generateShieldPermissions();

        $this->command->info('Roles, permisos y usuarios de prueba creados exitosamente.');
    }

    /**
     * Genera automáticamente los permisos de Shield si no existen
     */
    private function generateShieldPermissions(): void
    {
        // Verificar si los permisos de Shield ya existen
        $existingShieldPermissions = Permission::where('name', 'like', '%:Role')->count();
        
        if ($existingShieldPermissions === 0) {
            $this->command->info('⚠️ Los permisos de Shield no existen.');
            $this->command->info('💡 Ejecuta: php artisan app:reset --force');
            $this->command->info('   O manualmente: php artisan shield:generate --all');
        } else {
            $this->command->info('✅ Los permisos de Shield ya existen.');
        }
    }
}
