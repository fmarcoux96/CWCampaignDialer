<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasTimestamps, SoftDeletes;

    protected $fillable = [
        'campaign_type',
        'campaign_name',
        'campaign_description',
        'campaign_destination',
        'start_date',
        'end_date',
        'campaign_file',
        'campaign_file_processed',
        'active',
        'completed',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'active' => 'boolean',
        'completed' => 'boolean',
    ];

    protected $attributes = [
        'active' => true,
        'completed' => false,
    ];

    protected $withCount = [
        'entries',
        'calls',
    ];

    public function entries()
    {
        return $this->hasMany(CampaignEntry::class, 'campaign_id')
            ->orderBy('created_at');
    }

    public function calls()
    {
        return $this->hasManyThrough(CallAttempt::class, CampaignEntry::class)
            ->orderBy('created_at', 'desc');
    }

    public function scopeCurrent($query)
    {
        return $query
            ->active()
            ->whereDate('start_date', '<=', now())
            ->where(function ($query) {
                $query->whereDate('end_date', '>=', now())
                    ->orWhereNull('end_date');
            });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('campaign_name', 'like', "%{$search}%")
            ->orWhere('campaign_description', 'like', "%{$search}%");
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('active', false);
    }

    public function scopeType($query, $type)
    {
        return $query->where('campaign_type', $type);
    }

    public function scopeDateRange($query, $start, $end)
    {
        return $query->whereBetween('start_date', [$start, $end])
            ->orWhereBetween('end_date', [$start, $end]);
    }

    public function scopeProcessed($query)
    {
        return $query->where('campaign_file_processed', true);
    }

    public function scopeUnprocessed($query)
    {
        return $query->where('campaign_file_processed', false);
    }

    public function isProcessed()
    {
        return $this->campaign_file_processed;
    }
}
