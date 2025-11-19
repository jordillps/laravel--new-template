<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class TestFieldsetTranslations extends Command
{
    protected $signature = 'test:fieldsets {locale?}';
    protected $description = 'Test fieldset translations';

    public function handle()
    {
        $locale = $this->argument('locale') ?: 'es';
        
        $this->info("Testing fieldset translations for locale: $locale");
        $this->info("==================================================");
        
        // Cambiar idioma
        App::setLocale($locale);
        $this->info("Current app locale: " . App::getLocale());
        
        // Probar traducciones de fieldsets
        $fieldsets = [
            'filament.fieldsets.general_information' => __('filament.fieldsets.general_information'),
            'filament.fieldsets.contact_information' => __('filament.fieldsets.contact_information'),
            'filament.fieldsets.admin_configuration' => __('filament.fieldsets.admin_configuration'),
            'filament.fieldsets.content_configuration' => __('filament.fieldsets.content_configuration'),
            'filament.fieldsets.email_configuration' => __('filament.fieldsets.email_configuration'),
            'filament.fieldsets.security_configuration' => __('filament.fieldsets.security_configuration'),
            'filament.fieldsets.appearance_configuration' => __('filament.fieldsets.appearance_configuration'),
            'filament.fieldsets.system_configuration' => __('filament.fieldsets.system_configuration'),
        ];
        
        $this->info("\nFieldset Translations:");
        foreach ($fieldsets as $key => $value) {
            $status = $key === $value ? '❌' : '✅';
            $this->line("  $status $key => $value");
        }
        
        $this->info("\nTest completed!");
    }
}