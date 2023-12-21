<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallAttempt;
use App\Models\CampaignEntry;
use App\Settings\DialerOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DialerApiController extends Controller
{
    public function __construct(private readonly DialerOptions $options)
    {
    }

    public function nextCall(Request $request)
    {
        $this->updateLastRun();

        if (!$this->options->dialer_enabled) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dialer is disabled',
            ]);
        }

        $nextEntry = CampaignEntry::query()
            ->whereHas('campaign', function (Builder $query) {
                $query->current();
            })
            ->upcoming()
            ->first();

        if (!$nextEntry) {
            return response()->json([
                'status' => 'error',
                'message' => 'No next entries found',
            ]);
        }

        $attempt = $nextEntry->calls()->create([
            'call_attempt_start' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Next entry found',
            'entry' => $nextEntry,
            'attempt' => $attempt,
            'number' => $nextEntry->entry_phone_number,
            'destination' => $nextEntry->campaign->campaign_destination ?? $this->options->default_campaign_destination,
        ]);
    }

    public function updateCall(Request $request)
    {
        $id = $request->input('id');

        $call = CallAttempt::find($id);

        if (!$call) {
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
        $this->options->dialer_last_run = now();
        $this->options->save();
    }
}
