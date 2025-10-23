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
use App\Notifications\VerifyEmail as VerifyEmailNotification;
use App\Notifications\ResetPassword as ResetPasswordNotification;


class User extends Authenticatable implements FilamentUser, MustVerifyEmail
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
        ];
    }

    //Poden acceder al panell complet de Filament  todos los usuarios  
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Send the email verification notification.
     * (Opcional - la configuración global en AppServiceProvider también funciona)
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
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
}
