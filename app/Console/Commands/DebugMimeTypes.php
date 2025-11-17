<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DebugMimeTypes extends Command
{
    protected $signature = 'debug:mime-types {file}';
    protected $description = 'Debug MIME types for a file';

    public function handle()
    {
        $filePath = $this->argument('file');
        
        if (!file_exists($filePath)) {
            $this->error("El archivo no existe: $filePath");
            return;
        }
        
        $this->info("Analizando archivo: $filePath");
        $this->info("========================");
        
        // MIME type detectado por PHP
        $mimeType = mime_content_type($filePath);
        $this->info("MIME type detectado: " . ($mimeType ?: 'No detectado'));
        
        // Información del archivo
        $fileInfo = pathinfo($filePath);
        $this->info("Extensión: " . ($fileInfo['extension'] ?? 'Sin extensión'));
        $this->info("Nombre base: " . $fileInfo['basename']);
        $this->info("Tamaño: " . number_format(filesize($filePath) / 1024, 2) . " KB");
        
        // Tipos MIME aceptados actualmente
        $acceptedTypes = [
            'image/jpeg', 
            'image/jpg', 
            'image/png', 
            'image/gif', 
            'image/webp', 
            'image/svg+xml'
        ];
        
        $this->info("Tipos MIME aceptados:");
        foreach ($acceptedTypes as $type) {
            $status = $mimeType === $type ? '✅' : '❌';
            $this->line("  $status $type");
        }
        
        // Sugerencias
        if (!in_array($mimeType, $acceptedTypes)) {
            $this->warn("El archivo no es un tipo MIME aceptado.");
            $this->info("Considera agregar '$mimeType' a la lista de tipos aceptados.");
        } else {
            $this->info("✅ El archivo tiene un tipo MIME válido.");
        }
    }
}