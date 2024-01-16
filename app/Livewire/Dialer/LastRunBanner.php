<?php

namespace App\Livewire\Dialer;

use App\Settings\DialerOptions;
use App\Settings\TcxOptions;
use Carbon\Carbon;
use Livewire\Component;

class LastRunBanner extends Component
{
    public ?Carbon $lastRun = null;

    public bool $shouldShow = false;

    public function mount()
    {
        $config = app(DialerOptions::class);

        $this->lastRun = $config->dialer_health_check;
        $this->shouldShow = $config->hasNotRanInAWhile();
    }

    public function render()
    {
        return view('livewire.dialer.last-run-banner', [
            'dialerExtension' => app(TcxOptions::class)->dialer_extension,
            'minutes' => app(DialerOptions::class)->lastHealthCheck(),
        ]);
    }
}
