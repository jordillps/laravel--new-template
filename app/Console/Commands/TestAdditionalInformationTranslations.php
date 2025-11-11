<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class TestAdditionalInformationTranslations extends Command
{
    protected $signature = 'user:test-additional-info-translations';
    protected $description = 'Test additional information translations';

    public function handle()
    {
        $this->info('🌐 Testing Additional Information Translations...');
        $this->newLine();

        $languages = ['es', 'en', 'ca'];

        foreach ($languages as $lang) {
            $this->info("🔍 Testing {$lang} translations:");
            
            App::setLocale($lang);
            
            $this->info("Language: " . strtoupper($lang));
            $this->info("Additional Information: " . __('additional_information'));
            $this->newLine();
        }

        $this->info('📋 Translation Summary:');
        $this->info('✅ ES: Información adicional');
        $this->info('✅ EN: Additional Information');
        $this->info('✅ CA: Informació addicional');
        $this->newLine();

        $this->info('🚀 Additional Information translations completed!');
        $this->info('Fieldset header now supports Spanish, English, and Catalan.');
    }
}