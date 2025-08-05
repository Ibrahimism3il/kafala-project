<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;

    protected $fillable = [
        'kafel_id',    // ✅ الاسم المطابق للجدول
        'orphan_id',
        'start_date',
        'end_date',
        'type',
        'amount',
        'status',
    ];

    /** علاقة مع الكافل */
    public function donor()
    {
        return $this->belongsTo(User::class, 'kafel_id');
    }

    public function orphan()
    {
        return $this->belongsTo(Orphan::class, 'orphan_id');
    }

    public function orphanUser()
    {
        return $this->belongsTo(User::class, 'orphan_id');
    }


    public function orphanInfo()
    {
        return $this->belongsTo(Orphan::class, 'orphan_id');
    }

    /** جميع الدفعات */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /** آخر دفعة مسجلة */
    public function lastPayment()
    {
        return $this->hasOne(Payment::class)
            ->where('status', 'مكتمل')
            ->latestOfMany('payment_date');
    }


    /** تواريخ تُعالج كـ Carbon تلقائياً */
    protected $dates = ['start_date', 'end_date'];


    public static function updateOrphanSponsorshipStatus($orphanUserId)
    {
        // معرفة orphan_id المرتبط بالـ user_id
        $orphanId = \App\Models\Orphan::where('user_id', $orphanUserId)->value('id');

        if (!$orphanId) {
            return;
        }

        $hasActiveSponsorship = self::where('orphan_id', $orphanId)
            ->where('status', 'نشطة')
            ->exists();

        $status = $hasActiveSponsorship ? 'مكفول' : 'غير مكفول';

        // تحديث جدول users
        \App\Models\User::where('id', $orphanUserId)->update([
            'sponsorship_status' => $status,
        ]);

        // تحديث جدول orphans
        \App\Models\Orphan::where('id', $orphanId)->update([
            'sponsorship_status' => $status,
        ]);
    }
}
