<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ListPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all permissions and roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Permisos disponibles:');
        $this->info('====================');
        
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $this->line("- {$permission->name}");
        }
        
        $this->info('');
        $this->info('Roles y sus permisos:');
        $this->info('=====================');
        
        $roles = Role::with('permissions')->get();
        foreach ($roles as $role) {
            $this->line("Rol: {$role->name}");
            $rolePermissions = $role->permissions->pluck('name')->join(', ') ?: 'Sin permisos';
            $this->line("  Permisos: {$rolePermissions}");
            $this->line('');
        }
        
        return 0;
    }
}
