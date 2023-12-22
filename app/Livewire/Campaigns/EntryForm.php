<?php

namespace App\Livewire\Campaigns;

use App\Models\Campaign;
use App\Models\CampaignEntry;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class EntryForm extends ModalComponent
{
    use Actions;

    public CampaignEntry $entry;

    protected $rules = [
        'entry.campaign_id' => 'required|exists:campaigns,id',
        'entry.entry_id' => 'nullable|string',
        'entry.entry_name' => 'required|string',
        'entry.entry_phone_number' => 'required|digits:10',
        'entry.entry_source' => 'nullable|string',
        'entry.entry_destination' => 'nullable|string',
        'entry.entry_notes' => 'nullable|string',
        'entry.entry_created_at' => 'nullable|date',
    ];

    public function mount(Campaign $campaign, ?CampaignEntry $entry = null)
    {
        $this->entry = $entry ?? new CampaignEntry([
            'campaign_id' => $campaign->id,
        ]);
    }

    public function saveEntry()
    {
        $this->validate();

        try {
            $this->entry->save();

            $this->notification()->success(__('Entry saved successfully.'));

            $this->closeModalWithEvents(['reload']);
        } catch (\Exception $e) {
            report($e);

            $this->notification()->error(__('An error occured while saving the entry.'));
        }
    }

    public function render()
    {
        return view('livewire.campaigns.entry-form');
    }
}
