<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CandidateSponsorship extends Model
{
    protected $fillable = ['orphan_id', 'donor_id', 'status'];

    public function orphan()
    {
        return $this->belongsTo(Orphan::class);
    }

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }
    public function payment()
    {
        return $this->hasOne(\App\Models\Payment::class, 'candidate_id');
    }
}
