<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['user_id', 'type', 'file', 'description'];

    public const TYPES = [
        'birth_certificate'  => 'شهادة الميلاد',
        'social_status'      => 'إثبات الحالة الإجتماعية',
        'study_status'       => 'الحالة الدراسية',
        'health_status'      => 'الحالة الصحية',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
