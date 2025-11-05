<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignAllPermissionsToSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:assign-all-permissions {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign all permissions to a role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roleName = $this->argument('role');
        $role = Role::where('name', $roleName)->first();
        
        if (!$role) {
            $this->error("Rol '{$roleName}' no encontrado.");
            return 1;
        }
        
        $permissions = Permission::all();
        $role->givePermissionTo($permissions);
        
        $this->info("Asignados {$permissions->count()} permisos al rol '{$roleName}':");
        foreach ($permissions as $permission) {
            $this->line("  - {$permission->name}");
        }
        
        return 0;
    }
}
