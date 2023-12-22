<div>
    <x-form-section submit="save">
        <x-slot name="title">
            {{ __('Hours & Timezone') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Configure the hours and timezone for the dialer operations.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-w-select
                    wire:model="options.timezone"
                    label="{{ __('Dialer Timezone') }}"
                    :options="$timezones"
                    option-key-value
                    :clearable="false"
                    :searchable="true"
                    :placeholder="__('Select a timezone')"
                    hint="{{ __('The timezone to use for the 3CX Call Flow Dialer.') }}"
                    required
                />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">{{ __('Dialer Hours') }}</h3>

                @foreach($days as $day)
                    <div class="grid grid-cols-3 gap-1" wire:key="hours_day_{{ $day }}">
                        <div class="col-span-1">
                            <x-w-select
                                wire:model.live="options.{{ $day }}.state"
                                label="{{ ucfirst($day) }}"
                                :options="['open' => __('Open'), 'closed' => __('Closed')]"
                                option-key-value
                                :clearable="false"
                                :searchable="false"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <x-w-select
                                wire:model="options.{{ $day }}.start"
                                label="{{ __('Start') }}"
                                :options="$hours"
                                option-key-value
                                :clearable="false"
                                :searchable="false"
                                :disabled="$options[$day]['state'] === 'closed'"
                                required
                            />
                        </div>
                        <div class="col-span-1">
                            <x-w-select
                                wire:model="options.{{ $day }}.start"
                                label="{{ __('Start') }}"
                                :options="$hours"
                                option-key-value
                                :clearable="false"
                                :searchable="false"
                                :disabled="$options[$day]['state'] === 'closed'"
                                required
                            />
                        </div>
                    </div>
                @endforeach
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
