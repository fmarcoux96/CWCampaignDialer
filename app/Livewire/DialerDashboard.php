<?php

namespace App\Livewire;

use App\Models\CallAttempt;
use App\Models\Campaign;
use App\Models\CampaignEntry;
use App\Settings\DialerOptions;
use App\Settings\HoursOptions;
use Livewire\Component;
use WireUi\Traits\Actions;

class DialerDashboard extends Component
{
    use Actions;

    public function render()
    {
        return view('livewire.dialer-dashboard', [
            'activeCampaigns' => $this->getActiveCampaigns(),
            'totalEntries' => $this->getTotalEntries(),
            'remainingEntries' => $this->getRemainingEntries(),
            'totalDials' => $this->getTotalDials(),
            'successfulCalls' => $this->getSuccessfulCalls(),
            'failedCalls' => $this->getFailedCalls(),
            'dialerStatus' => $this->getDialerStatus(),
            'nextRunTime' => $this->nextRunTime(),
        ]);
    }

    private function getActiveCampaigns()
    {
        return Campaign::current()->count();
    }

    private function getTotalEntries()
    {
        return CampaignEntry::count();
    }

    private function getRemainingEntries()
    {
        return CampaignEntry::remaining()->count();
    }

    private function getTotalDials()
    {
        return CallAttempt::count();
    }

    private function getSuccessfulCalls()
    {
        return CallAttempt::successful()->count();
    }

    private function getFailedCalls()
    {
        return CallAttempt::failed()->count();
    }

    private function getDialerStatus()
    {
        $isEnabled = app(DialerOptions::class)->dialer_enabled;
        $isInHours = app(HoursOptions::class)->inHours();
        $hasEntries = CampaignEntry::remaining()->count() > 0;

        if ($isEnabled && $isInHours && $hasEntries) {
            return 'active';
        }

        if (! $isEnabled) {
            return 'disabled';
        }

        if (! $isInHours) {
            return 'after-hours';
        }

        if (! $hasEntries) {
            return 'no-entries';
        }

        return 'unknown';
    }

    private function nextRunTime()
    {
        $lastRunTime = app(DialerOptions::class)->dialer_last_run;
        $isInHours = app(HoursOptions::class)->inHours();

        if (! $isInHours) {
            return app(HoursOptions::class)
                ->nextRunTime()
                ?->format('H:i') ?? __('N/A');
        }

        return $lastRunTime
            ?->addSeconds(app(DialerOptions::class)->attempt_delay)
            ->format('H:i') ?? __('N/A');
    }
}
