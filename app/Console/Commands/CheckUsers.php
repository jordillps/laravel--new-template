<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckUsers extends Command
{
    protected $signature = 'check:users';
    protected $description = 'Check all users in the database';

    public function handle()
    {
        $this->info('Usuarios en la base de datos:');
        $this->info('===========================');
        
        $users = User::with('roles')->get();
        
        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->join(', ');
            $this->line("📧 {$user->email} - {$user->name} [{$roles}]");
        }
        
        $this->info("\nTotal usuarios: " . $users->count());
        
        // Verificar específicamente el super_admin
        $superAdmin = User::where('email', 'super_admin@example.com')->first();
        if ($superAdmin) {
            $this->info("\n✅ Super Admin encontrado:");
            $this->line("   Email: {$superAdmin->email}");
            $this->line("   Nombre: {$superAdmin->name}");
            $this->line("   Roles: " . $superAdmin->roles->pluck('name')->join(', '));
        } else {
            $this->error("\n❌ Super Admin NO encontrado con email 'super_admin@example.com'");
        }
    }
}