<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('name'))
                    ->required(),
                TextInput::make('phone')
                    ->label(__('phone'))
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label(__('email'))
                    ->email()
                    ->required(),
                Select::make('roles')
                    ->preload()
                    ->multiple()
                    ->label('Rols')                   
                    ->relationship('roles', 'name')
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
                    ->imageEditor()
                    ->circleCropper()
                    ->image()
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg'])
                    ->directory('')
                    ->visibility('public'),
                DateTimePicker::make('email_verified_at')
                    ->label(__('email verified at'))
                    ->disabled(),
            ]);
    }
}
