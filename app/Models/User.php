<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Sponsorship;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'gender',
        'area',
        'health_status',
        'social_status',
        'document',
        'role',
        'photo',
        'kafel_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //  علاقة المستخدم بالكفالات
    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class, 'kafel_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }


    public function orphan()
    {
        return $this->hasOne(Orphan::class);
    }

    public function orphanSponsorships()
    {
        return $this->hasMany(Sponsorship::class, 'orphan_id');
    }
}
