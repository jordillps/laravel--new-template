<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Auth\MultiFactor\Email\Contracts\HasEmailAuthentication;


class User extends Authenticatable implements FilamentUser, MustVerifyEmail, HasEmailAuthentication
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'city',
        'province',
        'country',
        'postal_code',
        'avatar',
        'has_email_authentication',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'has_email_authentication' => 'boolean',
        ];
    }

    //Poden acceder al panell complet de Filament  todos los usuarios  
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Boot del modelo para eventos
     */
    protected static function boot()
    {
        parent::boot();

        // Cuando se actualiza un usuario
        static::updating(function ($user) {
            // Si el avatar ha cambiado y había un avatar anterior
            if ($user->isDirty('avatar') && $user->getOriginal('avatar')) {
                $oldAvatar = $user->getOriginal('avatar');
                if (Storage::disk('avatars')->exists($oldAvatar)) {
                    Storage::disk('avatars')->delete($oldAvatar);
                }
            }
        });

        // Cuando se elimina un usuario
        static::deleting(function ($user) {
            if ($user->avatar && Storage::disk('avatars')->exists($user->avatar)) {
                Storage::disk('avatars')->delete($user->avatar);
            }
        });
    }

    //Email Authentication Methods
    public function hasEmailAuthentication(): bool
    {
        // This method should return true if the user has enabled email authentication.
        
        return $this->has_email_authentication;
    }

    public function toggleEmailAuthentication(bool $condition): void
    {
        // This method should save whether or not the user has enabled email authentication.
        $this->has_email_authentication = $condition;
        $this->save();
    }
}
