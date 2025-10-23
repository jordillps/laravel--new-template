<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('name'))
                    ->required(),
                TextInput::make('role')
                    ->label(__('role'))
                    ->required()
                    ->default('usuario'),
                TextInput::make('phone')
                    ->label(__('phone'))
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label(__('email'))
                    ->email()
                    ->required(),
                TextInput::make('address')
                    ->label(__('address')),
                TextInput::make('city')
                    ->label(__('city')),
                TextInput::make('province')
                    ->label(__('province')),
                TextInput::make('country')
                    ->label(__('country')),
                TextInput::make('postal_code')
                    ->label(__('postal code')),
                FileUpload::make('avatar')
                    ->label(__('avatar'))
                    ->disk('avatars')
                    ->avatar()
                    ->image(),
                DateTimePicker::make('email_verified_at')
                    ->label(__('email verified at')),
            ]);
    }
}
