<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListUsersRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users with their roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::with('roles')->get();
        
        $this->info('Usuarios y sus roles:');
        $this->info('====================');
        
        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->join(', ') ?: 'Sin roles';
            $this->line("{$user->name} ({$user->email}) - Roles: {$roles}");
        }
        
        return 0;
    }
}
