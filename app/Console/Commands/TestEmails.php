<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\CustomResetPassword;
use App\Notifications\CustomTwoFactorAuth;

class TestEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {type} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test custom email notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Usuario con email {$email} no encontrado.");
            return 1;
        }

        switch ($type) {
            case 'verify':
                $user->notify(new CustomVerifyEmail());
                $this->info("✅ Email de verificación enviado a {$email}");
                break;

            case 'reset':
                $token = 'test-token-123';
                $user->notify(new CustomResetPassword($token));
                $this->info("✅ Email de reset de contraseña enviado a {$email}");
                break;

            case '2fa':
                $code = sprintf('%06d', mt_rand(1, 999999));
                $user->notify(new CustomTwoFactorAuth($code));
                $this->info("✅ Email de doble factor enviado a {$email} con código: {$code}");
                break;

            default:
                $this->error("Tipo de email no válido. Usa: verify, reset, o 2fa");
                return 1;
        }

        return 0;
    }
}
