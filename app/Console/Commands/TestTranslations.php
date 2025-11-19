<?php

namespace App\Console\Commands;

use App\Helpers\SettingsHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class TestTranslations extends Command
{
    protected $signature = 'test:translations {locale?}';
    protected $description = 'Test translation functionality';

    public function handle()
    {
        $locale = $this->argument('locale') ?: SettingsHelper::getAdminLanguage() ?: 'es';
        
        $this->info("Testing translations for locale: $locale");
        $this->info("================================");
        
        // Cambiar idioma
        App::setLocale($locale);
        
        $this->info("Current app locale: " . App::getLocale());
        $this->info("Admin language setting: " . SettingsHelper::getAdminLanguage());
        
        // Probar traducciones
        $translations = [
            'filament.navigation.users' => __('filament.navigation.users'),
            'filament.navigation.user_management' => __('filament.navigation.user_management'),
            'filament.navigation.settings' => __('filament.navigation.settings'),
            'filament.settings.app_name' => __('filament.settings.app_name'),
            'filament.settings.admin_language' => __('filament.settings.admin_language'),
            'filament.settings.contact_email' => __('filament.settings.contact_email'),
            'filament.settings.maintenance_mode' => __('filament.settings.maintenance_mode'),
        ];
        
        $this->info("\nTranslations:");
        foreach ($translations as $key => $value) {
            $status = $key === $value ? '❌' : '✅';
            $this->line("  $status $key => $value");
        }
        
        $this->info("\nTest completed!");
    }
}