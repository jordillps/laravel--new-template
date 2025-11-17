<?php

namespace App\Console\Commands;

use App\Helpers\SettingsHelper;
use Illuminate\Console\Command;

class TestLogoSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:logo-system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test logo and favicon system functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Logo and Favicon System');
        $this->info('================================');

        // Test app name
        $appName = SettingsHelper::get('app_name');
        $this->info("App Name: " . ($appName ?: 'Not set'));

        // Test logo
        $appLogo = SettingsHelper::getAppLogo();
        $this->info("App Logo URL: " . ($appLogo ?: 'Not set'));

        // Test favicon
        $appFavicon = SettingsHelper::getAppFavicon();
        $this->info("App Favicon URL: " . ($appFavicon ?: 'Not set'));

        // Check if logos directory exists
        $logosPath = storage_path('app/public/media/logos');
        $this->info("Logos directory exists: " . (is_dir($logosPath) ? 'Yes' : 'No'));
        
        if (is_dir($logosPath)) {
            $files = scandir($logosPath);
            $files = array_diff($files, ['.', '..']);
            $this->info("Files in logos directory: " . count($files));
            foreach ($files as $file) {
                $this->line("  - $file");
            }
        }

        $this->info('Test completed!');
    }
}
