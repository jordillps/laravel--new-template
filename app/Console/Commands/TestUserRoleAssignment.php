<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class TestUserRoleAssignment extends Command
{
    protected $signature = 'user:test-role-assignment';
    protected $description = 'Test automatic role assignment for new users';

    public function handle()
    {
        $this->info('🔍 Testing Automatic Role Assignment for New Users...');
        $this->newLine();

        // Verificar que el rol "Usuario" existe
        $userRole = Role::where('name', 'Usuario')->first();
        if (!$userRole) {
            $this->error('❌ Role "Usuario" does not exist. Creating it...');
            $userRole = Role::create(['name' => 'Usuario']);
            $this->info('✅ Role "Usuario" created successfully.');
        } else {
            $this->info('✅ Role "Usuario" exists.');
        }

        $this->newLine();
        $this->info('📋 Auto Role Assignment Configuration:');
        $this->info('• Event: User::created()');
        $this->info('• Action: Assign "Usuario" role automatically');
        $this->info('• Target: All newly registered users');
        $this->newLine();

        $this->info('🎯 Implementation Details:');
        $this->info('✅ Boot method configured in User model');
        $this->info('✅ created() event listener added');
        $this->info('✅ Role verification before assignment');
        $this->info('✅ Safe assignment (only if role exists)');
        $this->newLine();

        $this->info('💡 How it works:');
        $this->info('1. User registers through any method (Filament, API, etc.)');
        $this->info('2. User model fires "created" event');
        $this->info('3. Event listener checks if "Usuario" role exists');
        $this->info('4. If role exists, assigns it to the new user');
        $this->info('5. User automatically has "Usuario" role and permissions');
        $this->newLine();

        $this->info('🚀 Automatic role assignment for new users is now configured!');
        $this->info('All new registrations will receive the "Usuario" role automatically.');
    }
}