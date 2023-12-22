<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use WireUi\Traits\Actions;

class TcxOptions extends Component
{
    use Actions;

    public array $options;

    protected $rules = [
        'options.dialer_extension' => 'required|string',
        'options.dialing_prefix' => 'nullable|string',
        'options.dialing_timeout' => 'required|integer|min:1|max:30',
    ];

    public function mount()
    {
        $this->options = app(\App\Settings\TcxOptions::class)->toArray();
    }

    public function save()
    {
        $this->validate();

        $options = app(\App\Settings\TcxOptions::class);
        $options->fill($this->options);
        $options->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.settings.tcx-options');
    }
}
