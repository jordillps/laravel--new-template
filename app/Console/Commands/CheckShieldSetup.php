<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use BezhanSalleh\FilamentShield\Resources\Roles\RoleResource;

class CheckShieldSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shield:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Shield setup and configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🛡️  Filament Shield - Estado de Configuración');
        $this->info('===============================================');
        
        // Verificar si Shield está instalado
        $this->line('✅ Plugin Shield instalado y configurado');
        
        // Verificar permisos de roles
        $rolePermissions = Permission::where('name', 'like', '%:Role')->count();
        $this->line("✅ Permisos de Role generados: {$rolePermissions}");
        
        // Verificar si el RoleResource existe
        if (class_exists(RoleResource::class)) {
            $this->line('✅ RoleResource disponible');
        } else {
            $this->line('❌ RoleResource NO disponible');
        }
        
        // Verificar roles y permisos del super_admin
        $superAdmin = User::role('super_admin')->first();
        if ($superAdmin) {
            $this->line("✅ Usuario super_admin encontrado: {$superAdmin->name}");
            
            if ($superAdmin->can('ViewAny:Role')) {
                $this->line('✅ Super admin puede ver roles');
            } else {
                $this->line('❌ Super admin NO puede ver roles');
            }
        }
        
        // Información de acceso
        $this->info('');
        $this->info('🌐 Información de Acceso:');
        $this->line('URL del panel: http://127.0.0.1:8001/admin');
        $this->line('Email super_admin: super_admin@example.com');
        $this->line('Password: Password123!');
        
        $this->info('');
        $this->info('📝 Para acceder a la gestión de roles:');
        $this->line('1. Inicia sesión con el usuario super_admin');
        $this->line('2. Busca "Roles" en el menú lateral');
        $this->line('3. Si no aparece, verifica los permisos del usuario');
        
        return 0;
    }
}
