<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::truncate();
        
        Setting::create([
            'app_name' => 'Laravel Template',
            'app_description' => 'Sistema de gestión empresarial con Laravel y Filament',
            'contact_email' => 'info@laravel-template.com',
            'contact_phone' => '+34 600 000 000',
            'contact_address' => 'Calle Principal, 123, Madrid, España',
            'admin_language' => 'es',
            'available_languages' => ['es', 'en'],
            'default_timezone' => 'Europe/Madrid',
            'date_format' => 'd/m/Y',
            'mail_from_address' => 'noreply@laravel-template.com',
            'mail_from_name' => 'Laravel Template',
            'email_notifications_enabled' => true,
            'user_registration_enabled' => true,
            'email_verification_required' => false,
            'default_theme' => 'light',
            'custom_colors' => null,
            'maintenance_mode' => false,
            'detailed_logging' => false,
            'posts_per_page' => 10,
        ]);
        
        $this->command->info('✅ Configuración por defecto creada exitosamente.');
    }
}
