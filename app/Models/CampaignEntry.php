<?php

namespace App\Models;

use App\Settings\DialerOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignEntry extends Model
{
    use HasTimestamps, SoftDeletes;

    protected $fillable = [
        'campaign_id',
        'entry_id',
        'entry_name',
        'entry_phone_number',
        'entry_source',
        'entry_destination',
        'entry_notes',
        'entry_created_at',
    ];

    protected $casts = [
        'entry_created_at' => 'datetime',
    ];

    protected $withCount = [
        'calls',
    ];

    protected $touches = [
        'campaign',
    ];

    public static function booted()
    {
        parent::booted();

        static::deleting(function ($entry) {
            $entry->calls()->delete();
        });
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function calls()
    {
        return $this->belongsToMany(CallAttempt::class, 'campaign_entry_id')
            ->orderBy('created_at', 'desc');
    }

    public function scopeCurrent($query)
    {
        return $query
            ->whereHas('campaign', function ($query) {
                $query->current();
            });
    }

    public function scopeRemaining(Builder $query)
    {
        return $query
            ->whereHas('campaign', function ($query) {
                $query->current();
            })
            ->where(function (Builder $q) {
                $maxAttempts = app(DialerOptions::class)->max_call_attempts;

                $q
                    ->where(function (Builder $q2) {
                        $q2
                            ->whereDoesntHave('calls')
                            ->orWhereDoesntHave('calls', function (Builder $q3) {
                                $q3
                                    ->where('successful', true)
                                    ->orWhereNull('call_attempt_end');
                            });
                    })
                    ->whereRaw("(
                        SELECT COUNT(*)
                        FROM call_attempts
                        WHERE call_attempts.campaign_entry_id = campaign_entries.id
                    ) <= {$maxAttempts}");
            })
            ->orderBy('created_at', 'asc');
    }

    public function scopeUpcoming(Builder $query)
    {
        return $query
            ->whereHas('campaign', function ($query) {
                $query->current();
            })
            ->where(function (Builder $q) {
                $maxAttempts = app(DialerOptions::class)->max_call_attempts;

                $q
                    ->where(function (Builder $q2) {
                        $q2
                            ->whereDoesntHave('calls')
                            ->orWhereDoesntHave('calls', function (Builder $q3) {
                                $q3
                                    ->where('successful', true)
                                    ->orWhereDate('call_attempt_start', '>=', now()->subHours(app(DialerOptions::class)->hours_before_retry))
                                    ->orWhereNull('call_attempt_end');
                            });
                    })
                    ->whereRaw("(
                        SELECT COUNT(*)
                        FROM call_attempts
                        WHERE call_attempts.campaign_entry_id = campaign_entries.id
                    ) <= {$maxAttempts}");
            })
            ->orderBy('created_at', 'asc');
    }
}
