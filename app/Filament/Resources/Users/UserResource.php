<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'User';

    protected static ?string $navigationLabel = 'Usuarios';

    protected static ?string $modelLabel = 'Usuario';

    protected static ?string $pluralModelLabel = 'Usuarios';

    // Ordre als items de la barra de navegación
    protected static ?int $navigationSort = 1;

    // agrupar els items del la barra de navegació
    protected static UnitEnum|string|null $navigationGroup = 'Gestión de Usuarios';

    // Mostrar navegación si tiene permisos O si es usuario para ver su perfil
    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->can('ViewAny:User') || Auth::user()->hasRole('Usuario');
    }

    // Cambiar el label de navegación según el tipo de usuario
    public static function getNavigationLabel(): string
    {
        if (Auth::user()->hasRole('Usuario')) {
            return 'Mi Perfil';
        }
        return 'Usuarios';
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    // Filtrar registros según el tipo de usuario
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // Si el usuario tiene rol "Usuario", solo mostrar su propio registro
        if (Auth::user()->hasRole('Usuario') && !Auth::user()->can('ViewAny:User')) {
            $query->where('id', Auth::user()->id);
        }
        
        return $query;
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    // Métodos de políticas para Shield
    public static function canViewAny(): bool
    {
        // Puede ver la lista si tiene permiso ViewAny:User O si solo quiere ver su propio perfil
        return Auth::user()->can('ViewAny:User') || Auth::user()->hasRole('Usuario');
    }

    public static function canView(Model $record): bool
    {
        // Puede ver si tiene permiso ViewAny:User O View:User O si es su propio usuario
        return Auth::user()->can('ViewAny:User') || Auth::user()->can('View:User') || Auth::user()->id === $record->id;
    }

    public static function canCreate(): bool
    {
        return Auth::user()->can('Create:User');
    }

    public static function canEdit(Model $record): bool
    {
        // Solo puede editar si tiene permiso Update:User O si es su propio usuario
        // ViewAny:User solo da permisos de visualización, no de edición
        return Auth::user()->can('Update:User') || Auth::user()->id === $record->id;
    }

    public static function canDelete(Model $record): bool
    {
        // Solo puede borrar si tiene permiso (no puede borrarse a sí mismo)
        return Auth::user()->can('Delete:User') && Auth::user()->id !== $record->id;
    }

    public static function canDeleteAny(): bool
    {
        return Auth::user()->can('Delete:User');
    }
}
