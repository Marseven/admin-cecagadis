<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function SecurityRole()
    {
        return $this->belongsTo(SecurityRole::class, 'security_role_id');
    }

    /**
     * Get all of the candidatures for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'user_id');
    }


    public function contracts()
    {
        return $this->hasMany(Contract::class, 'intern_id');
    }

    public function entreprise()
    {
        return $this->hasMany(Entreprise::class, 'manager_id');
    }

    public function employe()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }

    public function school()
    {
        return $this->hasMany(School::class, 'manager_id');
    }

    public function create_school()
    {
        return $this->hasMany(School::class, 'user_id');
    }

    public function create_entreprise()
    {
        return $this->hasMany(Entreprise::class, 'user_id');
    }
}
