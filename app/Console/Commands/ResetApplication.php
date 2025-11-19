<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the entire application (migrate:fresh + seed + shield setup)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('¿Estás seguro de que quieres resetear completamente la aplicación? Esto eliminará todos los datos.')) {
                $this->info('Operación cancelada.');
                return 0;
            }
        }

        $this->info('🚀 Iniciando reset completo de la aplicación...');
        $this->newLine();

        // 1. Resetear migraciones y seeders
        $this->info('1️⃣ Ejecutando migrate:fresh --seed...');
        $this->call('migrate:fresh', ['--seed' => true]);
        
        // Crear configuración por defecto
        $this->info('📝 Creando configuración por defecto...');
        $this->call('db:seed', ['--class' => 'SettingSeeder']);
        
        // 2. Generar permisos de Shield
        $this->info('2️⃣ Generando permisos de Shield...');
        $this->info('   Ejecutando shield:generate --all automáticamente...');
        
        // Ejecutar el comando con respuestas automáticas
        $exitCode = $this->call('shield:generate', [], $this->getOutput());
        if ($exitCode === 0) {
            $this->info('   ✅ Permisos generados exitosamente');
            
            // Asignar permisos de Post al rol Escritor
            $this->info('   📝 Asignando permisos de publicaciones al rol Escritor...');
            $this->assignPostPermissionsToEscritor();
        }
        
        // 3. Asignar todos los permisos al super_admin
        $this->info('3️⃣ Asignando permisos al super_admin...');
        $this->call('role:assign-all-permissions', ['role' => 'super_admin']);
        
        // 4. Limpiar caches
        $this->info('4️⃣ Limpiando caches...');
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        
        $this->newLine();
        $this->info('✅ Reset completo finalizado exitosamente!');
        $this->newLine();
        
        // Mostrar información de acceso
        $this->info('🌐 Información de acceso:');
        $this->line('Panel Admin: http://127.0.0.1:8001/admin');
        $this->line('Super Admin: super_admin@example.com / Password123!');
        $this->line('Usuario Normal: user@example.com / Password123!');
        $this->line('Viewer: viewer@example.com / Password123!');
        $this->line('Editor: editor@example.com / Password123!');
        $this->newLine();
        $this->info('📝 Nota: Los usuarios con rol "Escritor" pueden gestionar publicaciones.');
        
        return 0;
    }
    
    /**
     * Asigna permisos de publicaciones al rol Escritor
     */
    private function assignPostPermissionsToEscritor(): void
    {
        $escritorRole = \Spatie\Permission\Models\Role::where('name', 'Escritor')->first();
        
        if ($escritorRole) {
            // Permisos que el Escritor debe tener
            $permissions = [
                'ViewAny:Post',
                'View:Post', 
                'Create:Post',
                'Update:Post',
                'Update:User'
            ];
            
            // Verificar que cada permiso existe antes de asignarlo
            $validPermissions = [];
            foreach ($permissions as $permission) {
                if (\Spatie\Permission\Models\Permission::where('name', $permission)->exists()) {
                    $validPermissions[] = $permission;
                }
            }
            
            // Asignar los permisos válidos
            if (!empty($validPermissions)) {
                $escritorRole->syncPermissions($validPermissions);
                $this->info('   ✅ Permisos de publicaciones asignados al Escritor: ' . implode(', ', $validPermissions));
            }
        }
    }
}
