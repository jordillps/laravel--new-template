<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Fieldset;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //Crear Grid con 3 columnas
                Grid::make(3)
                    ->schema([
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
                    ])->columnSpanFull(),
                Grid::make(3)
                    ->schema([
                        TextInput::make('password')
                            ->label(__('Password'))
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->confirmed()
                            ->revealable()
                            ->helperText(__('password_help'))
                            ->visible(fn(string $operation): bool => $operation === 'create'),
                        TextInput::make('password_confirmation')
                            ->label(__('Confirm Password'))
                            ->password()
                            ->required()
                            ->revealable()
                            ->visible(fn(string $operation): bool => $operation === 'create'),
                        Select::make('roles')
                            ->preload()
                            ->multiple()
                            ->label(__('Roles'))
                            ->relationship('roles', 'name')
                            ->required(),
                    ])->columnSpanFull(),
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
            //Fieldset para datos adicionales
            Fieldset::make(__('additional_information'))
                ->schema([
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
            ])->columnSpanFull(),
        ]);
    }
}
