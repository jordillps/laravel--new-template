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
        /** @var User $user */
        $user = Auth::user();
        
        // Verificar si tiene permiso ViewAny:User mediante Gate
        if ($user && app('auth')->guard()->hasUser() && $user->hasPermissionTo('ViewAny:User')) {
            return true;
        }
        
        // O si tiene rol Usuario o Escritor (para ver su propio perfil)
        return $user && ($user->hasRole('Usuario') || $user->hasRole('Escritor'));
    }

    // Cambiar el label de navegación según el tipo de usuario
    public static function getNavigationLabel(): string
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Si es Usuario o Escritor y no puede ver todos los usuarios, mostrar "Mi Perfil"
        if ($user && ($user->hasRole('Usuario') || $user->hasRole('Escritor'))) {
            // Verificar si NO tiene permiso para ver todos los usuarios
            if (!$user->hasPermissionTo('ViewAny:User')) {
                return 'Mi Perfil';
            }
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
        
        /** @var User $user */
        $user = Auth::user();
        
        // Si el usuario tiene rol "Usuario" o "Escritor" pero no puede ver todos los usuarios, solo mostrar su propio registro
        if ($user && ($user->hasRole('Usuario') || $user->hasRole('Escritor'))) {
            if (!$user->hasPermissionTo('ViewAny:User')) {
                $query->where('id', $user->id);
            }
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
        /** @var User $user */
        $user = Auth::user();
        
        if (!$user) return false;
        
        // Puede ver la lista si tiene permiso ViewAny:User O si solo quiere ver su propio perfil
        return $user->hasPermissionTo('ViewAny:User') || $user->hasRole('Usuario') || $user->hasRole('Escritor');
    }

    public static function canView(Model $record): bool
    {
        /** @var User $user */
        $user = Auth::user();
        
        if (!$user) return false;
        
        // Puede ver si tiene permisos O si es su propio usuario
        return $user->hasPermissionTo('ViewAny:User') || 
               $user->hasPermissionTo('View:User') || 
               $user->id === $record->id;
    }

    public static function canCreate(): bool
    {
        /** @var User $user */
        $user = Auth::user();
        
        return $user && $user->hasPermissionTo('Create:User');
    }

    public static function canEdit(Model $record): bool
    {
        /** @var User $user */
        $user = Auth::user();
        
        if (!$user) return false;
        
        // Si el registro es un super_admin, solo otros super_admin pueden editarlo
        if ($record->hasRole('super_admin')) {
            return $user->hasRole('super_admin');
        }

        // Para usuarios normales: pueden editar si tienen permiso Update:User O si es su propio usuario
        return $user->hasPermissionTo('Update:User') || $user->id === $record->id;
    }

    public static function canDelete(Model $record): bool
    {
        /** @var User $user */
        $user = Auth::user();
        
        if (!$user) return false;
        
        // Los usuarios super_admin no pueden ser eliminados por nadie (ni siquiera por otros super_admin)
        if ($record->hasRole('super_admin')) {
            return false;
        }

        // Para usuarios normales: solo puede borrar si tiene permiso (no puede borrarse a sí mismo)
        return $user->hasPermissionTo('Delete:User') && $user->id !== $record->id;
    }

    public static function canDeleteAny(): bool
    {
        /** @var User $user */
        $user = Auth::user();
        
        return $user && $user->hasPermissionTo('Delete:User');
    }
}
