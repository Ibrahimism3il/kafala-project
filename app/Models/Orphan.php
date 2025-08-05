<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orphan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'area',
        'gender',
        'social_status',
        'health_status',
        'photo',
        'document',
        'user_id',
    ];

    // علاقة اليتيم بالكفالات

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function isSponsored()
    {
        return $this->sponsorships()->where('status', 'نشطة')->exists();
    }
}
