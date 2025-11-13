<?php

namespace App\Filament\Resources\Posts;

use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Filament\Resources\Posts\Schemas\PostForm;
use App\Filament\Resources\Posts\Tables\PostsTable;
use App\Models\Post;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'Publicaciones';

    protected static ?string $modelLabel = 'Publicación';

    protected static ?string $pluralModelLabel = 'Publicaciones';

    protected static UnitEnum|string|null $navigationGroup = 'Contenido';

    protected static ?int $navigationSort = 10;

    public static function getNavigationLabel(): string
    {
        return __('Publicaciones');
    }

    public static function getModelLabel(): string
    {
        return __('Publicación');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Publicaciones');
    }

    public static function form(Schema $schema): Schema
    {
        return PostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PostsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }

    // Métodos de autorización
    public static function canCreate(): bool
    {
        return Auth::user()->can('Create:Post') || Auth::user()->hasRole(['super_admin', 'Escritor']);
    }

    public static function canEdit(Model $record): bool
    {
        // Super admin puede editar todo
        if (Auth::user()->hasRole('super_admin')) {
            return true;
        }

        // Los escritores pueden editar sus propias publicaciones si tienen permiso
        if (Auth::user()->hasRole('Escritor') && Auth::user()->can('Update:Post') && $record->user_id === Auth::user()->id) {
            return true;
        }

        // Editores pueden editar posts de otros usuarios (si tienen permisos)
        return Auth::user()->can('Update:Post') && Auth::user()->hasRole(['Editor']);
    }

    public static function canDelete(Model $record): bool
    {
        // Super admin puede eliminar todo
        if (Auth::user()->hasRole('super_admin')) {
            return true;
        }

        // Los escritores pueden eliminar sus propias publicaciones si tienen permiso
        if (Auth::user()->hasRole('Escritor') && Auth::user()->can('Delete:Post') && $record->user_id === Auth::user()->id) {
            return true;
        }

        // Editores pueden eliminar posts de otros usuarios (si tienen permisos)
        return Auth::user()->can('Delete:Post') && Auth::user()->hasRole(['Editor']);
    }

    public static function canDeleteAny(): bool
    {
        return Auth::user()->can('Delete:Post') || Auth::user()->hasRole('super_admin');
    }
}
