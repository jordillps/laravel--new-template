<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // === INFORMACIÓN GENERAL ===
                TextInput::make('app_name')
                    ->label('Nombre de la aplicación')
                    ->required()
                    ->default('Laravel Template')
                    ->columnSpanFull(),
                    
                Textarea::make('app_description')
                    ->label('Descripción de la aplicación')
                    ->rows(3)
                    ->columnSpanFull(),
                    
                FileUpload::make('app_logo')
                    ->label('Logo de la aplicación')
                    ->image()
                    ->disk('public')
                    ->directory('settings')
                    ->maxSize(1024),
                    
                FileUpload::make('app_favicon')
                    ->label('Favicon')
                    ->image()
                    ->disk('public')
                    ->directory('settings')
                    ->maxSize(512)
                    ->acceptedFileTypes(['image/x-icon', 'image/png']),

                // === INFORMACIÓN DE CONTACTO ===
                TextInput::make('contact_email')
                    ->label('Email de contacto')
                    ->email()
                    ->columnSpanFull(),
                    
                TextInput::make('contact_phone')
                    ->label('Teléfono de contacto')
                    ->tel(),
                    
                Textarea::make('contact_address')
                    ->label('Dirección física')
                    ->rows(3)
                    ->columnSpanFull(),

                // === CONFIGURACIÓN DEL PANEL ADMINISTRATIVO ===
                Select::make('admin_language')
                    ->label('Idioma del Admin')
                    ->options([
                        'es' => 'Español',
                        'ca' => 'Català',
                        'en' => 'English',
                    ])
                    ->default('es')
                    ->required()
                    ->helperText('Idioma de toda la interfaz administrativa')
                    ->columnSpanFull(),

                // === CONFIGURACIÓN DE CONTENIDO MULTIIDIOMA ===
                TagsInput::make('available_languages')
                    ->label('Idiomas disponibles')
                    ->default(['es', 'en'])
                    ->helperText('Códigos de idioma (ej: es, en, ca)')
                    ->columnSpanFull(),
                    
                Select::make('default_timezone')
                    ->label('Zona horaria')
                    ->options([
                        'Europe/Madrid' => 'Madrid (UTC+1)',
                        'Europe/London' => 'Londres (UTC+0)',
                        'America/New_York' => 'Nueva York (UTC-5)',
                        'America/Los_Angeles' => 'Los Ángeles (UTC-8)',
                        'America/Mexico_City' => 'Ciudad de México (UTC-6)',
                    ])
                    ->default('Europe/Madrid')
                    ->required(),
                    
                Select::make('date_format')
                    ->label('Formato de fecha')
                    ->options([
                        'd/m/Y' => 'dd/mm/aaaa',
                        'm/d/Y' => 'mm/dd/aaaa',
                        'Y-m-d' => 'aaaa-mm-dd',
                        'd-m-Y' => 'dd-mm-aaaa',
                    ])
                    ->default('d/m/Y')
                    ->required(),

                // === CONFIGURACIÓN DE EMAIL ===
                TextInput::make('mail_from_address')
                    ->label('Email remitente')
                    ->email()
                    ->helperText('Email usado para enviar notificaciones'),
                    
                TextInput::make('mail_from_name')
                    ->label('Nombre remitente')
                    ->helperText('Nombre que aparece como remitente'),
                    
                Toggle::make('email_notifications_enabled')
                    ->label('Activar notificaciones por email')
                    ->default(true)
                    ->columnSpanFull(),

                // === CONFIGURACIÓN DE SEGURIDAD ===
                Toggle::make('user_registration_enabled')
                    ->label('Permitir registro de usuarios')
                    ->default(true)
                    ->helperText('Los usuarios pueden registrarse automáticamente')
                    ->columnSpanFull(),
                    
                Toggle::make('email_verification_required')
                    ->label('Verificación de email obligatoria')
                    ->default(false)
                    ->helperText('Los usuarios deben verificar su email')
                    ->columnSpanFull(),

                // === CONFIGURACIÓN DE APARIENCIA ===
                Select::make('default_theme')
                    ->label('Tema por defecto')
                    ->options([
                        'light' => 'Claro',
                        'dark' => 'Oscuro',
                        'auto' => 'Automático',
                    ])
                    ->default('light')
                    ->required(),

                // === CONFIGURACIÓN DEL SISTEMA ===
                Toggle::make('maintenance_mode')
                    ->label('Modo mantenimiento')
                    ->default(false)
                    ->helperText('Activar para mostrar página de mantenimiento'),
                    
                Toggle::make('detailed_logging')
                    ->label('Logs detallados')
                    ->default(false)
                    ->helperText('Registrar información detallada en logs'),
                    

            ]);
    }
}
