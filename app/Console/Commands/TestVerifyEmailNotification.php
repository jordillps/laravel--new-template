<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestVerifyEmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:verify-email-notification {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba el envío de email de verificación usando la clase personalizada VerifyEmail multiidioma';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("❌ Error: No se encontró ningún usuario con el email: {$email}");
            return 1;
        }
        
        try {
            $user->sendEmailVerificationNotification();
            $this->info("✅ Email de verificación enviado exitosamente a: {$email}");
            $this->info("📧 Usando la clase personalizada: VerifyEmail (multiidioma)");
        } catch (\Exception $e) {
            $this->error("❌ Error al enviar el email: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
