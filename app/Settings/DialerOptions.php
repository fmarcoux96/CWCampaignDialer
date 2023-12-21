<?php

namespace App\Settings;

use Carbon\Carbon;
use Spatie\LaravelSettings\Settings;

class DialerOptions extends Settings
{
    public bool $dialer_enabled;

    public ?Carbon $dialer_last_run;

    public ?string $default_campaign_destination;

    public int $max_call_attempts;

    public int $hours_before_retry;

    public function hasNotRanInAWhile(): bool
    {
        return $this->dialer_last_run->diffInMinutes(now()) > 5;
    }

    public static function group(): string
    {
        return 'dialer';
    }
}
