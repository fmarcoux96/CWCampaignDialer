<?php

namespace App\Livewire\Campaigns;

use App\Jobs\ProcessImportFile;
use App\Models\Campaign;
use App\Settings\DialerOptions;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class UploadForm extends ModalComponent
{
    use Actions;
    use WithFileUploads;

    public Campaign $campaign;

    /** @var TemporaryUploadedFile|null */
    public $uploadFile = null;

    protected $rules = [
        'campaign.campaign_name' => 'required|string|max:255',
        'campaign.campaign_description' => 'nullable|string|max:255',
        'campaign.campaign_destination' => 'required|string|max:5',
        'campaign.start_date' => 'required|date',
        'campaign.end_date' => 'nullable|date',
        'campaign.active' => 'nullable|boolean',
        'uploadFile' => 'nullable|file', // 'nullable|file|extensions:xls,xlsx,csv|mimes:xls,xlsx,csv,txt',
    ];

    public function mount(Campaign $campaign = null)
    {
        $this->campaign = $campaign ?? new Campaign();

        if (!$this->campaign->exists) {
            $this->campaign->start_date = now();
            $this->campaign->campaign_destination = app(DialerOptions::class)->default_campaign_destination;
        }
    }

    public function saveCampaign()
    {
        $this->validate();

        try {
            if ($this->uploadFile && !$this->campaign->exists) {
                $this->processFile();
            }

            $this->campaign->save();

            $this->notification()->success(__('Campaign saved successfully.'));

            ProcessImportFile::dispatch($this->campaign);

            $this->closeModalWithEvents(['reload']);
        } catch (\Exception $e) {
            report($e);

            $this->notification()->error(__('There was an error saving the campaign.'));
        }
    }

    public function render()
    {
        return view('livewire.campaigns.upload-form');
    }

    private function processFile()
    {
        $storeName = sprintf(
            '%s-%s.%s',
            \Str::slug($this->campaign->campaign_name),
            now()->timestamp,
            $this->uploadFile->getClientOriginalExtension()
        );

        $file = $this->uploadFile->storeAs('campaigns', $storeName);

        $this->campaign->campaign_file = $file;
    }
}
