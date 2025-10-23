<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestMultilangResetPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:multilang-reset-password {email} {--locale=es}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba el envío de email de restablecimiento de contraseña en diferentes idiomas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $locale = $this->option('locale');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("❌ Error: No se encontró ningún usuario con el email: {$email}");
            return 1;
        }
        
        // Guardar locale actual
        $originalLocale = app()->getLocale();
        
        try {
            // Cambiar temporalmente el locale
            app()->setLocale($locale);
            
            // Generar un token de prueba
            $token = 'test-token-' . time();
            
            $user->sendPasswordResetNotification($token);
            $this->info("✅ Email de reset password enviado a: {$email}");
            $this->info("🌍 Idioma usado: {$locale}");
            
            // Mostrar algunas traducciones de ejemplo
            $this->info("📧 Subject: " . __('Reset Password'));
            $this->info("👋 Greeting: " . __('Hello :name!', ['name' => $user->name]));
            $this->info("🔗 Button: " . __('Reset Password Button'));
            
        } catch (\Exception $e) {
            $this->error("❌ Error al enviar el email: " . $e->getMessage());
            return 1;
        } finally {
            // Restaurar locale original
            app()->setLocale($originalLocale);
        }
        
        return 0;
    }
}