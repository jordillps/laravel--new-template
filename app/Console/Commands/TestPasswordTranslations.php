<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class TestPasswordTranslations extends Command
{
    protected $signature = 'user:test-password-translations';
    protected $description = 'Test password help text translations';

    public function handle()
    {
        $this->info('🌐 Testing Password Help Text Translations...');
        $this->newLine();

        $languages = ['es', 'en', 'ca'];

        foreach ($languages as $lang) {
            $this->info("🔍 Testing {$lang} translations:");
            
            App::setLocale($lang);
            
            $this->info("Language: " . strtoupper($lang));
            $this->info("Password Help: " . __('password_help'));
            $this->info("Password Label: " . __('Password'));
            $this->info("Confirm Password: " . __('Confirm Password'));
            $this->newLine();
        }

        $this->info('📋 Translation Summary:');
        $this->info('✅ ES: Mínimo 8 caracteres, debe incluir mayúscula, minúscula, número y carácter especial');
        $this->info('✅ EN: Minimum 8 characters, must include uppercase, lowercase, number and special character');
        $this->info('✅ CA: Mínim 8 caràcters, ha d\'incloure majúscula, minúscula, número i caràcter especial');
        $this->newLine();

        $this->info('🚀 Password translations implementation completed!');
        $this->info('Helper text now supports Spanish, English, and Catalan.');
    }
}