<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetSuperAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset super admin password to Password123!';

    /**
     * Execute the console command.
     */
    public function handle()
    {
                // Buscar el usuario super_admin
        $superAdmin = User::where('email', 'super_admin@example.com')->first();
        
        if (!$superAdmin) {
            $this->error('Super admin user not found!');
            return 1;
        }
        
        $this->info('Super Admin found:');
        $this->info('- ID: ' . $superAdmin->id);
        $this->info('- Name: ' . $superAdmin->name);
        $this->info('- Email: ' . $superAdmin->email);
        $this->info('- Roles: ' . implode(', ', $superAdmin->roles->pluck('name')->toArray()));
        
        // Reset password
        $superAdmin->password = Hash::make('Password123!');
        $superAdmin->save();
        
        $this->info('Password reset to: Password123!');
        
        return 0;
    }
}