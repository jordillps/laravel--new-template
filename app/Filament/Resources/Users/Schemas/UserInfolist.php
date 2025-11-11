<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;



class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                         TextEntry::make('name')
                        ->label(__('name')),
                        TextEntry::make('phone')
                        ->label(__('phone')),
                        TextEntry::make('email')
                        ->label(__('email')),
                ])->columnSpanFull(),
                TextEntry::make('roles.name')
                    ->label(__('Roles'))
                    ->badge()
                    ->color(function ($state) {
                        return $state === 'super_admin' ? 'green' : 'primary';
                    })
                    ->separator(', '),
                
                ImageEntry::make('avatar')
                    ->label(__('avatar'))
                    ->disk('avatars')
                    ->circular()
                    ->visibility('public'),
                TextEntry::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label(__('updated_at'))
                    ->dateTime(),
                Fieldset::make(__('additional_information'))
                ->schema([
                    TextEntry::make('address')
                    ->label(__('address')),
                TextEntry::make('city')
                    ->label(__('city')),
                TextEntry::make('province')
                    ->label(__('province')),
                TextEntry::make('country')
                    ->label(__('country')),
                TextEntry::make('postal_code')
                    ->label(__('postal code')),
            ])->columnSpanFull(),               
        ]);
    }
}
