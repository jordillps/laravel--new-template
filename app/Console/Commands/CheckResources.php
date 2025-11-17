<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckResources extends Command
{
    protected $signature = 'check:resources';
    protected $description = 'Check what Filament resources exist';

    public function handle()
    {
        $this->info('Checking Filament Resources');
        $this->info('==========================');
        
        // Check app resources
        $appResourcesPath = app_path('Filament/Resources');
        if (File::exists($appResourcesPath)) {
            $this->info("\nApp Resources (app/Filament/Resources):");
            $directories = File::directories($appResourcesPath);
            foreach ($directories as $dir) {
                $name = basename($dir);
                $this->line("  📁 $name");
                
                // Check for main resource file
                $resourceFile = $dir . '/' . $name . 'Resource.php';
                if (File::exists($resourceFile)) {
                    $this->line("    ✅ {$name}Resource.php");
                } else {
                    $this->line("    ❌ No {$name}Resource.php");
                }
            }
        }
        
        // Check Shield configuration
        $this->info("\nShield Configuration:");
        $config = config('filament-shield');
        $this->line("  🛡️ Shield enabled: " . ($config ? 'Yes' : 'No'));
        $this->line("  🌍 Localization: " . ($config['localization']['enabled'] ? 'Enabled' : 'Disabled'));
        $this->line("  📍 Shield resource slug: " . $config['shield_resource']['slug']);
        
        // Check for duplicate role management
        $this->info("\nRole Management Check:");
        if (File::exists(app_path('Filament/Resources/Roles'))) {
            $this->warn("  ⚠️ Custom Roles resource found - SHOULD BE REMOVED");
        } else {
            $this->line("  ✅ No duplicate Roles resource");
        }
        
        if (File::exists(app_path('Filament/Resources/Permissions'))) {
            $this->warn("  ⚠️ Custom Permissions resource found - SHOULD BE REMOVED");
        } else {
            $this->line("  ✅ No duplicate Permissions resource");
        }
        
        $this->info("\nShield should handle Roles & Permissions automatically! 🛡️");
    }
}