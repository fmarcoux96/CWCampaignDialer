<?php

namespace App\Settings;

use Carbon\Carbon;
use Spatie\LaravelSettings\Settings;

class DialerOptions extends Settings
{
    public bool $dialer_enabled;

    public ?string $default_campaign_destination;

    public int $attempt_delay;

    public int $max_call_attempts;

    public int $hours_before_retry;

    public ?Carbon $dialer_last_run;

    public function lastRunAgo(): int|null
    {
        if ($this->dialer_last_run === null) {
            return null;
        }

        return $this->dialer_last_run?->diffInMinutes(now()) ?? 0;
    }

    public function hasNotRanInAWhile(): bool
    {
        if ($this->lastRunAgo() === null) {
            return true;
        }

        return $this->lastRunAgo() > 2;
    }

    public static function group(): string
    {
        return 'dialer';
    }
}
