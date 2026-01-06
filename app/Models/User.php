<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
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
        'foto_profil',
        'role',
        'avatar',
        'last_login',
        'last_login_at',
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
            'last_login' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Safely get user role, return default if column doesn't exist
     */
    public function getRoleAttribute($value)
    {
        try {
            return $value ?? 'User';
        } catch (\Exception $e) {
            return 'User';
        }
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        try {
            return $this->role === $role;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }
}
