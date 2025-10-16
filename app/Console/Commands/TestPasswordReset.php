<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Password;

class TestPasswordReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:password-reset {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba el envío de email de restablecimiento de contraseña en español';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("Usuario no encontrado: {$email}");
            return 1;
        }
        
        // Enviar enlace de restablecimiento
        $status = Password::sendResetLink(['email' => $email]);
        
        if ($status === Password::RESET_LINK_SENT) {
            $this->info("✅ Email enviado a: {$email}");
        } else {
            $this->error("❌ Error: " . __($status));
            return 1;
        }
        
        return 0;
    }
}
