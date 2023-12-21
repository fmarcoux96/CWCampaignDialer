<?php

namespace App\Livewire\Campaigns;

use App\Jobs\ProcessImportFile;
use App\Models\Campaign;
use Livewire\Component;
use WireUi\Traits\Actions;

class Details extends Component
{
    use Actions;

    public Campaign $campaign;

    protected $listeners = [
        'reload' => '$refresh',
    ];

    public function reprocessFile()
    {
        $this->campaign->update([
            'campaign_file_processed' => false,
        ]);

        ProcessImportFile::dispatch($this->campaign);

        $this->notification()->success(__('Campaign file will be reprocessed.'));
    }

    public function render()
    {
        return view('livewire.campaigns.details');
    }
}
