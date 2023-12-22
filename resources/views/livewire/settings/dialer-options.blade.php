<div>
    <x-form-section submit="save">
        <x-slot name="title">
            {{ __('Dialer Settings') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Configure the dialer behaviors.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-w-toggle
                    wire:model="options.dialer_enabled"
                    label="{{ __('Enable Dialer') }}"
                    hint="{{ __('Enable or disable the dialer.') }}"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-w-input
                    type="number"
                    step="1"
                    min="1"
                    max="3600"
                    wire:model="options.attempt_delay"
                    label="{{ __('Call Delay') }}"
                    hint="{{ __('The number of seconds to wait between new calls.') }}"
                    required
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-w-input
                    type="number"
                    step="1"
                    min="1"
                    max="10"
                    wire:model="options.max_call_attempts"
                    label="{{ __('Max Call Attempts') }}"
                    hint="{{ __('The maximum number of times to attempt to call an entry.') }}"
                    required
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-w-input
                    type="number"
                    step="1"
                    min="1"
                    wire:model="options.hours_before_retry"
                    label="{{ __('Hours Before Retry') }}"
                    hint="{{ __('The number of hours to wait before retrying a failed call attempt.') }}"
                    required
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-w-input
                    type="number"
                    step="1"
                    min="1"
                    max="99999"
                    wire:model="options.default_campaign_destination"
                    label="{{ __('Default Destination') }}"
                    hint="{{ __('The default destination for campaigns (3CX extension).') }}"
                    required
                />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {!! __('Saved.') !!}
            </x-action-message>

            <x-button wire:loading.attr="disabled">
                {!! __('Save') !!}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
