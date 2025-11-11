<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserRegistration extends Command
{
    protected $signature = 'user:simulate-registration {--email=test@example.com} {--name=Test User}';
    protected $description = 'Simulate user registration to test automatic role assignment';

    public function handle()
    {
        $email = $this->option('email');
        $name = $this->option('name');

        $this->info('🧪 Simulating User Registration...');
        $this->newLine();

        // Verificar si el usuario ya existe
        if (User::where('email', $email)->exists()) {
            $this->warn("User with email {$email} already exists. Using different email...");
            $email = 'test_' . time() . '@example.com';
        }

        $this->info("Creating user: {$name} ({$email})");

        // Crear el usuario (esto debería disparar el evento created)
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password123'),
            'phone' => '+34 123 456 789',
        ]);

        $this->newLine();
        $this->info('✅ User created successfully!');
        $this->info("User ID: {$user->id}");
        $this->info("Name: {$user->name}");
        $this->info("Email: {$user->email}");

        // Verificar roles asignados
        $roles = $user->roles()->pluck('name')->toArray();
        
        $this->newLine();
        $this->info('🎭 Roles assigned:');
        if (empty($roles)) {
            $this->error('❌ No roles assigned - something went wrong!');
        } else {
            foreach ($roles as $role) {
                $this->info("✅ {$role}");
            }
        }

        $this->newLine();
        
        if (in_array('Usuario', $roles)) {
            $this->info('🚀 SUCCESS: Automatic role assignment is working correctly!');
        } else {
            $this->error('❌ FAILED: "Usuario" role was not assigned automatically.');
        }

        // Limpiar usuario de prueba
        $this->newLine();
        if ($this->confirm('Delete test user?', true)) {
            $user->delete();
            $this->info('🗑️ Test user deleted.');
        }
    }
}