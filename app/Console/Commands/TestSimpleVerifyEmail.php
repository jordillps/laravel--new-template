<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;

class TestSimpleVerifyEmail extends Command
{
    protected $signature = 'test:simple-verify {email}';
    protected $description = 'Probar email de verificación sin rutas adicionales';

    public function handle()
    {
        $user = User::where('email', $this->argument('email'))->first();
        
        if (!$user) {
            $this->error('Usuario no encontrado');
            return 1;
        }

        try {
            // Usar directamente la notificación de Laravel (que ahora usa nuestras traducciones)
            $user->notify(new VerifyEmail);
            $this->info('✅ Email enviado usando configuración automática de Laravel');
            $this->info('🌍 Idioma: ' . app()->getLocale());
            $this->info('📧 Sin rutas adicionales - usando sistema interno de Filament/Laravel');
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
