<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallAttempt;
use App\Models\CampaignEntry;
use App\Settings\DialerOptions;
use App\Settings\HoursOptions;
use App\Settings\TcxOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DialerApiController extends Controller
{
    public function __construct(
        private readonly DialerOptions $dialerOptions,
        private readonly TcxOptions $tcxOptions,
        private readonly HoursOptions $hoursOptions,
    ) {
    }

    public function nextCall(Request $request)
    {
        $this->updateLastRun();

        if (! $this->dialerOptions->dialer_enabled) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dialer is disabled',
            ]);
        }

        if (! $this->hoursOptions->inHours()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dialer is not in hours',
                'now' => now($this->hoursOptions->timezone),
                'next_run_time' => $this->hoursOptions->nextRunTime()->format('H:i'),
                'hours' => $this->hoursOptions->getHoursForDay(),
            ]);
        }

        if (! $this->dialerOptions->dialer_last_run->addSeconds($this->dialerOptions->attempt_delay)->isBefore(now())) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dialer is not ready to run',
                'last_run' => $this->dialerOptions->dialer_last_run,
                'next_run' => $this->dialerOptions->dialer_last_run->addSeconds($this->dialerOptions->attempt_delay),
                'delay' => $this->dialerOptions->attempt_delay,
            ]);
        }

        $nextEntry = CampaignEntry::query()
            ->whereHas('campaign', function (Builder $query) {
                $query->current();
            })
            ->upcoming()
            ->first();

        if (! $nextEntry) {
            return response()->json([
                'status' => 'error',
                'message' => 'No next entries found',
            ]);
        }

        $callAttempt = $nextEntry->calls()->create([
            'call_attempt_start' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Next entry found',
            'entry' => $nextEntry->withoutRelations(),
            'attempt' => $callAttempt->withoutRelations(),
            'number' => $this->formatDialingNumber($nextEntry->entry_phone_number),
            'destination' => $nextEntry->entry_destination ?? $nextEntry->campaign->campaign_destination ?? $this->dialerOptions->default_campaign_destination,
        ]);
    }

    public function updateCall(Request $request)
    {
        $id = $request->input('id');

        $call = CallAttempt::find($id);

        if (! $call) {
            return response()->json([
                'status' => 'error',
                'message' => 'Call not found',
            ]);
        }

        $call->update([
            'successful' => $request->input('successful'),
            'call_attempt_end' => now(),
            'error_message' => $request->input('error_message'),
        ]);

        if ($call->campaign->entries()->remaining()->count() === 0) {
            $call->campaign->update([
                'completed' => true,
                'active' => false,
                'end_date' => now(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Call updated',
        ]);
    }

    private function updateLastRun()
    {
        $this->dialerOptions->dialer_last_run = now();
        $this->dialerOptions->save();
    }

    private function formatDialingNumber(mixed $entry_phone_number)
    {
        $number = preg_replace('/[^0-9]/', '', $entry_phone_number);

        if (!empty($this->tcxOptions->tcx_prefix)) {
            return $this->tcxOptions->tcx_prefix . $number;
        }

        return $number;
    }
}
