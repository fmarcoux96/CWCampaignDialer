<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallAttempt extends Model
{
    use HasTimestamps, SoftDeletes;

    protected $fillable = [
        'campaign_entry_id',
        'call_id',
        'call_attempt_start',
        'call_attempt_end',
        'successful',
        'error_message',
    ];

    protected $casts = [
        'call_attempt_start' => 'datetime',
        'call_attempt_end' => 'datetime',
        'successful' => 'boolean',
    ];

    protected $touches = [
        'entry',
    ];

    public function entry()
    {
        return $this->belongsTo(CampaignEntry::class, 'campaign_entry_id');
    }

    public function campaign()
    {
        return $this->hasOneThrough(Campaign::class, CampaignEntry::class);
    }

    public function scopeAttempted($query)
    {
        return $query->whereNotNull('call_attempt_start');
    }

    public function scopeSuccessful($query)
    {
        return $query->where('successful', true);
    }

    public function scopeFailed($query)
    {
        return $query->where('successful', false);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('call_attempt_start', today());
    }

    public function scopeActive($query)
    {
        return $query->whereNull('call_attempt_end');
    }
}
