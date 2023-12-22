<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use WireUi\Traits\Actions;

class DialerOptions extends Component
{
    use Actions;

    public array $options = [];

    protected $rules = [
        'options.dialer_enabled' => ['required', 'boolean'],
        'options.default_campaign_destination' => ['required', 'string', 'max:5'],
        'options.max_call_attempts' => ['required', 'integer', 'min:1', 'max:10'],
        'options.hours_before_retry' => ['required', 'integer', 'min:1'],
        'options.attempt_delay' => ['required', 'integer', 'min:1', 'max:3600'],
    ];

    public function mount()
    {
        $this->options = app(\App\Settings\DialerOptions::class)->toArray();
    }

    public function save()
    {
        $this->validate();

        $options = app(\App\Settings\DialerOptions::class);
        $options->fill($this->options);
        $options->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.settings.dialer-options');
    }
}
