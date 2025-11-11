<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Auth;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label(__('avatar'))
                    ->disk('avatars')
                    ->circular()
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
                TextColumn::make('roles.name')
                    ->label(__('Roles'))
                    ->badge()
                    ->color(function ($state) {
                        return $state === 'super_admin' ? 'green' : 'primary';
                    })
                    ->separator(', ')
                    ->searchable(),
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
                EditAction::make()
                    ->visible(fn($record) => \App\Filament\Resources\Users\UserResource::canEdit($record)),
                DeleteAction::make()
                    ->visible(fn($record) => \App\Filament\Resources\Users\UserResource::canDelete($record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
