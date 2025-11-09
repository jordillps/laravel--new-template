<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestAvatars extends Command
{
    protected $signature = 'avatar:test';
    protected $description = 'Test avatar functionality for users';

    public function handle()
    {
        $this->info('Testing avatar functionality...');
        $this->newLine();

        $users = User::whereNotNull('avatar')->take(5)->get();

        if ($users->isEmpty()) {
            $this->warn('No users with avatars found.');
            return;
        }

        $this->info('Users with avatars:');
        $this->newLine();

        foreach ($users as $user) {
            $this->info("User: {$user->name}");
            $this->info("Email: {$user->email}");
            $this->info("Avatar file: {$user->avatar}");
            $this->info("Avatar URL: " . ($user->getFilamentAvatarUrl() ?? 'N/A'));
            $this->newLine();
        }

        $this->info('✅ Avatar test completed successfully!');
    }
}