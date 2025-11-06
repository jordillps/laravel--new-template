<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\CustomResetPassword;
use App\Notifications\CustomTwoFactorAuth;
use Illuminate\Support\Facades\Storage;

class PreviewEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:preview {type} {--console : Show HTML in console instead of file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preview email templates in HTML format';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        $user = User::first();

        if (!$user) {
            $this->error('No hay usuarios en la base de datos.');
            return 1;
        }

        switch ($type) {
            case 'verify':
                $notification = new CustomVerifyEmail();
                $filename = 'email_verify_preview.html';
                break;

            case 'reset':
                $notification = new CustomResetPassword('test-token-123');
                $filename = 'email_reset_preview.html';
                break;

            case '2fa':
                $notification = new CustomTwoFactorAuth('123456');
                $filename = 'email_2fa_preview.html';
                break;

            default:
                $this->error("Tipo de email no válido. Usa: verify, reset, o 2fa");
                return 1;
        }

        // Generar el HTML del email
        $mailMessage = $notification->toMail($user);
        $html = $mailMessage->render();

        if ($this->option('console')) {
            // Mostrar HTML en consola
            $this->info("✅ HTML del email generado:");
            $this->line("📧 Tipo: " . ucfirst($type));
            $this->newLine();
            $this->line("HTML Content:");
            $this->line("=" . str_repeat("=", 50));
            $this->line($html);
            $this->line("=" . str_repeat("=", 50));
        } else {
            // Guardar en carpeta temporal del sistema
            $tempDir = sys_get_temp_dir();
            $previewPath = $tempDir . DIRECTORY_SEPARATOR . $filename;
            file_put_contents($previewPath, $html);

            $this->info("✅ Email preview generado temporalmente:");
            $this->line("📧 Tipo: " . ucfirst($type));
            $this->line("📁 Archivo temporal: {$previewPath}");
            $this->line("⏰ Este archivo se eliminará automáticamente al reiniciar el sistema");
            
            $this->newLine();
            $this->info("💡 Para ver el email:");
            $this->line("   1. Abre el archivo en tu navegador: file://{$previewPath}");
            $this->line("   2. O copia el contenido y pégalo en un archivo .html");
            $this->line("   3. Los archivos temporales no afectan tu aplicación");
        }

        return 0;
    }
}
