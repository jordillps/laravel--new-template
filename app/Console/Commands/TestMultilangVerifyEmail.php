<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestMultilangVerifyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:multilang-verify-email {email} {--locale=es}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba el envío de email de verificación en diferentes idiomas';

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
            
            $user->sendEmailVerificationNotification();
            $this->info("✅ Email enviado a: {$email}");
            $this->info("🌍 Idioma usado: {$locale}");
            
            // Mostrar algunas traducciones de ejemplo
            $this->info("📧 Subject: " . __('Verify your email address'));
            $this->info("👋 Greeting: " . __('Hello :name!', ['name' => $user->name]));
            
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