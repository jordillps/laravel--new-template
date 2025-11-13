<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label(__('Imagen'))
                    ->disk('public')
                    ->size(50)
                    ->circular()
                    ->defaultImageUrl('/images/post-placeholder.jpg'),

                TextColumn::make('title')
                    ->label(__('Título'))
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->limit(50),

                TextColumn::make('status')
                    ->label(__('Estado'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'archived' => 'gray',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'published' => __('Publicado'),
                        'draft' => __('Borrador'),
                        'archived' => __('Archivado'),
                        default => $state,
                    })
                    ->sortable(),

                IconColumn::make('is_featured')
                    ->label(__('Destacado'))
                    ->boolean()
                    ->trueIcon('heroicon-s-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                TextColumn::make('user.name')
                    ->label(__('Autor'))
                    ->sortable()
                    ->searchable(['users.name', 'users.email'])
                    ->toggleable(),

                TextColumn::make('published_at')
                    ->label(__('Fecha de Publicación'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('Creado'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('Actualizado'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('Estado'))
                    ->options([
                        'published' => __('Publicado'),
                        'draft' => __('Borrador'),
                        'archived' => __('Archivado'),
                    ]),

                TernaryFilter::make('is_featured')
                    ->label(__('Post Destacado'))
                    ->boolean()
                    ->trueLabel(__('Solo destacados'))
                    ->falseLabel(__('Solo no destacados'))
                    ->native(false),

                SelectFilter::make('user')
                    ->label(__('Autor'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn($record) => \App\Filament\Resources\Posts\PostResource::canEdit($record)),
                DeleteAction::make()
                    ->visible(fn($record) => \App\Filament\Resources\Posts\PostResource::canDelete($record)),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s'); // Actualización automática cada 60 segundos
    }
}
