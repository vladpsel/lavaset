<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public array $allowedRoles = [
      'admin' => 'Адміністратор',
      'user' => 'Користувач',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole(string $role): bool
    {
        if (self::getRole() === $role) {
            return true;
        }
        return false;
    }

    public function role(): HasOne
    {
        return $this->hasOne(UserRoles::class);
    }

    public function getRules(): array
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|unique:users,email,' . $this->id,
            'password' => 'required|min:6',
        ];
    }

    public function getRole(): ?string
    {
        $roles = self::role()->first();

        if (!$roles) {
            return null;
        }

        if (property_exists($roles, 'role')) {
            return null;
        }

        return $roles->role;
    }

}
