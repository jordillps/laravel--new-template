<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label(__('name')),
                // TextEntry::make('role'),
                TextEntry::make('phone')
                    ->label(__('phone')),
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
                ImageEntry::make('avatar')
                    ->label(__('avatar'))
                    ->disk('avatars')
                    ->circular()
                    ->visibility('public'),
                TextEntry::make('email')
                    ->label(__('email')),
                TextEntry::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label(__('updated_at'))
                    ->dateTime(),
            ]);
    }
}
