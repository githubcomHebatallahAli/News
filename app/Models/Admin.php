<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
// use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable  implements JWTSubject
{

    use HasFactory , Notifiable, SoftDeletes ;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'email_verified_at'
    ];

    public function profile()
    {
        return $this->hasOne(AdminProfile::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
       // public function permissions()
    // {
    //     return $this->role->rolePermissions->pluck('name') ?? [];
    // }
    // public function hasPermission($permissionCheck)
    // {
    //     $uesrPermissions = $this->permissions();
    //     return in_array($permissionCheck, $uesrPermissions);
    // }

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $cast = [
        'password'=>'hashed'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

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
}
