<div>
    <form wire:submit.prevent="saveEntry">
        <div class="shadow sm:rounded-md dark:bg-gray-900">
            <div class="px-4 py-3 text-lg sm:px-6 text-center dark:bg-gray-800 dark:text-white">
                {{ $entry->exists ? __('Update Entry') : __('Create Entry') }}
            </div>

            <x-w-errors class="mx-4 my-2 sm:mx-6" />

            <div class="px-4 py-2 sm:px-6">
                <x-w-input
                    label="{!! __('ID') !!}"
                    placeholder="{!! __('Enter an ID') !!}"
                    wire:model="entry.entry_id"
                />
            </div>

            <div class="px-4 py-2 sm:px-6">
                <x-w-input
                    label="{!! __('Name') !!}"
                    placeholder="{!! __('Enter a name') !!}"
                    wire:model="entry.entry_name"
                    required
                />
            </div>

            <div class="px-4 py-2 sm:px-6">
                <x-w-input
                    label="{!! __('Phone Number') !!}"
                    placeholder="{!! __('Enter a phone number') !!}"
                    wire:model="entry.entry_phone_number"
                    required
                />
            </div>

            <div class="px-4 py-2 sm:px-6">
                <x-w-input
                    label="{!! __('Source') !!}"
                    placeholder="{!! __('Enter a source') !!}"
                    wire:model="entry.entry_source"
                />
            </div>

            <div class="px-4 py-2 sm:px-6">
                <x-w-textarea
                    label="{!! __('Notes') !!}"
                    placeholder="{!! __('Enter some notes') !!}"
                    wire:model="entry.entry_notes"
                />
            </div>

            <div class="px-4 py-2 sm:px-6">
                <x-w-datetime-picker
                    label="{!! __('Created At') !!}"
                    placeholder="{!! __('Enter a creation date') !!}"
                    wire:model="entry.entry_created_at"
                    without-time
                    without-tips
                />
            </div>

            <div class="flex flex-row items-center justify-end mt-2 px-4 py-4 sm:px-6 bg-gray-100 text-right rounded-b-lg dark:bg-gray-800">
                <div class="flex items-center justify-end">
                    <x-secondary-button type="button" class="mr-3" wire:click="$dispatch('closeModal')" wire:loading.attr="disabled">{!! __('Cancel') !!}</x-secondary-button>
                    <x-button type="submit" wire:loading.attr="disabled">{!! $entry->exists ? __('Update') : __('Create') !!}</x-button>
                </div>
            </div>
        </div>
    </form>
</div>
