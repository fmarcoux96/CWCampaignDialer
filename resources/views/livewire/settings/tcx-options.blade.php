<div>
    <x-form-section submit="save">
        <x-slot name="title">
            {{ __('3CX Dialer') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Configure the 3CX outbound dialing options.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-w-input
                    type="number"
                    step="1"
                    min="1"
                    max="99999"
                    wire:model="options.dialer_extension"
                    label="{{ __('Dialer Extension') }}"
                    hint="{{ __('Enter the 3CX extension assigned to the dialer.') }}"
                    required
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-w-input
                    type="number"
                    step="1"
                    wire:model="options.dialing_prefix"
                    label="{{ __('Dialing Prefix') }}"
                    hint="{{ __('Enter the prefix required for dialing outbound numbers. Leave empty if not required.') }}"
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-w-input
                    type="number"
                    step="1"
                    min="1"
                    max="30"
                    wire:model="options.dialing_timeout"
                    label="{{ __('Dialing Timeout') }}"
                    hint="{{ __('Enter the number of seconds to wait for the dialer to connect the call before giving up.') }}"
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
