<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use WireUi\Traits\Actions;

class HoursOptions extends Component
{
    use Actions;

    public array $options;

    protected $rules = [
        'options.timezone' => 'required|string|timezone',
        'options.monday.state' => 'required|in:open,closed',
        'options.monday.start' => 'required_if:options.monday.state,open|date_format:H:i',
        'options.monday.end' => 'required_if:options.monday.state,open|date_format:H:i|after:options.monday.start',
        'options.tuesday.state' => 'required|in:open,closed',
        'options.tuesday.start' => 'required_if:options.tuesday.state,open|date_format:H:i',
        'options.tuesday.end' => 'required_if:options.tuesday.state,open|date_format:H:i|after:options.tuesday.start',
        'options.wednesday.state' => 'required|in:open,closed',
        'options.wednesday.start' => 'required_if:options.wednesday.state,open|date_format:H:i',
        'options.wednesday.end' => 'required_if:options.wednesday.state,open|date_format:H:i|after:options.wednesday.start',
        'options.thursday.state' => 'required|in:open,closed',
        'options.thursday.start' => 'required_if:options.thursday.state,open|date_format:H:i',
        'options.thursday.end' => 'required_if:options.thursday.state,open|date_format:H:i|after:options.thursday.start',
        'options.friday.state' => 'required|in:open,closed',
        'options.friday.start' => 'required_if:options.friday.state,open|date_format:H:i',
        'options.friday.end' => 'required_if:options.friday.state,open|date_format:H:i|after:options.friday.start',
        'options.saturday.state' => 'required|in:open,closed',
        'options.saturday.start' => 'required_if:options.saturday.state,open|date_format:H:i',
        'options.saturday.end' => 'required_if:options.saturday.state,open|date_format:H:i|after:options.saturday.start',
        'options.sunday.state' => 'required|in:open,closed',
        'options.sunday.start' => 'required_if:options.sunday.state,open|date_format:H:i',
        'options.sunday.end' => 'required_if:options.sunday.state,open|date_format:H:i|after:options.sunday.start',
    ];

    public function mount()
    {
        $this->options = app(\App\Settings\HoursOptions::class)->toArray();
    }

    public function save()
    {
        $this->validate();

        $options = app(\App\Settings\HoursOptions::class);
        $options->fill($this->options);
        $options->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.settings.hours-options', [
            'timezones' => \App\Settings\HoursOptions::getTimezones(),
            'days' => \App\Settings\HoursOptions::getDays(),
            'hours' => \App\Settings\HoursOptions::getHours(),
        ]);
    }
}
