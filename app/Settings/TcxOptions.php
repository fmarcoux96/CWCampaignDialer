<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class TcxOptions extends Settings
{
    public string $dialer_extension;

    public string $dialing_prefix;

    public int $dialing_timeout;

    public static function group(): string
    {
        return 'tcx';
    }
}
