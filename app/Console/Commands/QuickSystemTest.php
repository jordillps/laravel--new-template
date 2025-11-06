<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class QuickSystemTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quick system functionality test';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Ejecutando pruebas rápidas del sistema...');
        $this->newLine();

        $allPassed = true;

        // Test 1: Verificar usuarios
        $this->info('1️⃣ Verificando usuarios...');
        $userCount = User::count();
        if ($userCount >= 4) {
            $this->line("   ✅ {$userCount} usuarios encontrados");
        } else {
            $this->error("   ❌ Solo {$userCount} usuarios encontrados (esperados: 4+)");
            $allPassed = false;
        }

        // Test 2: Verificar roles
        $this->info('2️⃣ Verificando roles...');
        $requiredRoles = ['super_admin', 'Usuario', 'Viewer', 'Editor'];
        foreach ($requiredRoles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $this->line("   ✅ Rol '{$roleName}' existe");
            } else {
                $this->error("   ❌ Rol '{$roleName}' no encontrado");
                $allPassed = false;
            }
        }

        // Test 3: Verificar permisos
        $this->info('3️⃣ Verificando permisos...');
        $userPermissions = Permission::where('name', 'like', '%:User')->count();
        $rolePermissions = Permission::where('name', 'like', '%:Role')->count();
        
        if ($userPermissions >= 11) {
            $this->line("   ✅ {$userPermissions} permisos de usuario encontrados");
        } else {
            $this->error("   ❌ Solo {$userPermissions} permisos de usuario (esperados: 11)");
            $allPassed = false;
        }

        if ($rolePermissions >= 11) {
            $this->line("   ✅ {$rolePermissions} permisos de rol encontrados");
        } else {
            $this->error("   ❌ Solo {$rolePermissions} permisos de rol (esperados: 11)");
            $allPassed = false;
        }

        // Test 4: Verificar super_admin
        $this->info('4️⃣ Verificando super_admin...');
        $superAdmin = User::role('super_admin')->first();
        if ($superAdmin) {
            $permissionCount = $superAdmin->getAllPermissions()->count();
            if ($permissionCount >= 20) {
                $this->line("   ✅ Super admin tiene {$permissionCount} permisos");
            } else {
                $this->error("   ❌ Super admin solo tiene {$permissionCount} permisos");
                $allPassed = false;
            }
        } else {
            $this->error("   ❌ No se encontró usuario super_admin");
            $allPassed = false;
        }

        // Test 5: Verificar permisos específicos
        $this->info('5️⃣ Verificando permisos específicos...');
        $viewer = User::role('Viewer')->first();
        if ($viewer && $viewer->can('ViewAny:User') && !$viewer->can('Update:User')) {
            $this->line("   ✅ Viewer tiene permisos correctos");
        } else {
            $this->error("   ❌ Viewer no tiene permisos correctos");
            $allPassed = false;
        }

        $this->newLine();
        if ($allPassed) {
            $this->info('🎉 ¡Todas las pruebas pasaron exitosamente!');
            $this->info('🌐 Sistema listo para usar en: http://127.0.0.1:8001/admin');
        } else {
            $this->error('❌ Algunas pruebas fallaron. Ejecuta: php artisan app:reset --force');
        }

        return $allPassed ? 0 : 1;
    }
}
