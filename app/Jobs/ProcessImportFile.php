<?php

namespace App\Jobs;

use App\Imports\ImportCampaignFile;
use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ProcessImportFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly Campaign $campaign)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->campaign->campaign_file_processed) {
            return;
        }

        \Log::debug('IMPORT: Preparing', [
            'campaign' => $this->campaign,
        ]);

        $file = storage_path('app/'.$this->campaign->campaign_file);
        if (!file_exists($file)) {
            \Log::error('IMPORT: Failed', [
                'campaign' => $this->campaign,
                'message' => 'File not found',
                'file' => $file,
            ]);

            return;
        }

        try {
            $this->campaign->entries()->delete();

            Excel::import(new ImportCampaignFile($this->campaign), $file);

            \Log::debug('IMPORT: Finished', [
                'campaign' => $this->campaign,
                'file' => $file,
                'entries' => $this->campaign->entries()->count(),
            ]);

            $this->campaign->update([
                'campaign_file_processed' => true,
            ]);
        } catch (\Exception $e) {
            report($e);

            \Log::error('IMPORT: Failed', [
                'campaign' => $this->campaign,
                'message' => $e->getMessage(),
                'file' => $file,
            ]);
        }
    }
}
