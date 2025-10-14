<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label(__('avatar'))
                    ->disk('avatars')
                    ->visibility('public'),
                TextColumn::make('name')
                    ->label(__('name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('email'))
                    ->searchable(),
                //phone
                TextColumn::make('phone')
                    ->label(__('phone'))
                    ->searchable(),
                // TextColumn::make('roles.name')
                //     ->label(__('Roles'))
                //     ->badge()
                //     ->separator(', ')
                //     ->searchable(),

                TextColumn::make('created_at')
                    ->label(__('created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
