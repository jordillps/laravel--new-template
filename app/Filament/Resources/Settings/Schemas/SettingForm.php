<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Fieldset;

class SettingForm
{
    /**
     * Tipos MIME aceptados para imágenes de logo
     */
    public static function getAcceptedImageTypes(): array
    {
        return [
            'image/jpeg',
            'image/jpg', 
            'image/png',
            'image/gif',
            'image/webp',
            'image/svg+xml',
            'image/bmp',
            'image/tiff',
            'image/x-icon',
            'image/vnd.microsoft.icon'
        ];
    }

    /**
     * Validar que el archivo es una imagen válida
     */
    public static function validateImage($file): bool
    {
        if (!$file) return false;
        
        $mimeType = $file->getMimeType();
        return in_array($mimeType, static::getAcceptedImageTypes());
    }
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // === INFORMACIÓN GENERAL ===
                Fieldset::make(__('filament.fieldsets.general_information'))
                ->schema([
                    TextInput::make('app_name')
                        ->label(__('filament.settings.app_name'))
                        ->required()
                        ->default('Laravel Template')
                        ->columnSpanFull(),

                    Textarea::make('app_description')
                        ->label(__('filament.settings.app_description'))
                        ->rows(3)
                        ->columnSpanFull(),

                    FileUpload::make('app_logo')
                        ->label(__('filament.settings.app_logo'))
                        ->disk('logos')
                        ->visibility('public')
                        ->maxSize(2048)
                        ->image() // Usa validación básica de imagen
                        ->helperText(__('filament.settings.helpers.app_logo'))
                        ->imageResizeMode('contain')
                        ->imageResizeTargetWidth('400')
                        ->imageResizeTargetHeight('200'),

                    FileUpload::make('app_favicon')
                        ->label(__('filament.settings.app_favicon'))
                        ->disk('logos')
                        ->visibility('public')
                        ->maxSize(512)
                        ->image() // Usa validación básica de imagen
                        ->helperText(__('filament.settings.helpers.app_favicon'))
                        ->imageResizeMode('contain')
                        ->imageResizeTargetWidth('32')
                        ->imageResizeTargetHeight('32'),
                ])->columnSpanFull(),

                // === INFORMACIÓN DE CONTACTO ===
                
                Fieldset::make(__('filament.fieldsets.contact_information'))
                ->schema([
                    TextInput::make('contact_email')
                        ->label(__('filament.settings.contact_email'))
                        ->email()
                        ->columnSpanFull(),

                    TextInput::make('contact_phone')
                        ->label(__('filament.settings.contact_phone'))
                        ->tel(),

                    Textarea::make('contact_address')
                        ->label(__('filament.settings.contact_address'))
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columnSpanFull(),

                // === CONFIGURACIÓN DEL PANEL ADMINISTRATIVO ===
                Fieldset::make(__('filament.fieldsets.admin_configuration'))
                ->schema([
                    Select::make('admin_language')
                        ->label(__('filament.settings.admin_language'))
                        ->options(__('filament.settings.language_options'))
                        ->default('es')
                        ->required()
                        ->helperText(__('filament.settings.helpers.admin_language'))
                        ->columnSpanFull(),
                ])->columnSpanFull(),

                // === CONFIGURACIÓN DE CONTENIDO MULTIIDIOMA ===
                Fieldset::make(__('filament.fieldsets.content_configuration'))
                ->schema([
                TagsInput::make('available_languages')
                    ->label(__('filament.settings.available_languages'))
                    ->default(['es', 'en'])
                    ->helperText(__('filament.settings.helpers.available_languages'))
                    ->columnSpanFull(),

                Select::make('default_timezone')
                    ->label(__('filament.settings.default_timezone'))
                    ->options(__('filament.settings.timezone_options'))
                    ->default('Europe/Madrid')
                    ->required(),

                Select::make('date_format')
                    ->label(__('filament.settings.date_format'))
                    ->options(__('filament.settings.date_format_options'))
                    ->default('d/m/Y')
                    ->required(),
                ])->columnSpanFull(),

                // === CONFIGURACIÓN DE EMAIL ===
                Fieldset::make(__('filament.fieldsets.email_configuration'))
                ->schema([
                    TextInput::make('mail_from_address')
                        ->label(__('filament.settings.mail_from_address'))
                        ->email()
                        ->helperText(__('filament.settings.helpers.mail_from_address')),

                    TextInput::make('mail_from_name')
                        ->label(__('filament.settings.mail_from_name'))
                        ->helperText(__('filament.settings.helpers.mail_from_name')),

                    Toggle::make('email_notifications_enabled')
                        ->label(__('filament.settings.email_notifications_enabled'))
                        ->default(true)
                        ->columnSpanFull(),
                ])->columnSpanFull(),
                

                // === CONFIGURACIÓN DE SEGURIDAD ===
                Fieldset::make(__('filament.fieldsets.security_configuration'))
                ->schema([
                    Toggle::make('user_registration_enabled')
                    ->label(__('filament.settings.user_registration_enabled'))
                    ->default(true)
                    ->helperText(__('filament.settings.helpers.user_registration_enabled'))
                    ->columnSpanFull(),
                    
                Toggle::make('email_verification_required')
                    ->label(__('filament.settings.email_verification_required'))
                    ->default(false)
                    ->helperText(__('filament.settings.helpers.email_verification_required'))
                    ->columnSpanFull(),
                ])->columnSpanFull(),

                // === CONFIGURACIÓN DEL SISTEMA ===
                Fieldset::make(__('filament.fieldsets.system_configuration'))
                ->schema([
                    Toggle::make('maintenance_mode')
                        ->label(__('filament.settings.maintenance_mode'))
                        ->default(false)
                        ->helperText(__('filament.settings.helpers.maintenance_mode')),

                    Toggle::make('detailed_logging')
                        ->label(__('filament.settings.detailed_logging'))
                        ->default(false)
                        ->helperText(__('filament.settings.helpers.detailed_logging')),
                ])->columnSpanFull(),       

            ]);
    }
}
