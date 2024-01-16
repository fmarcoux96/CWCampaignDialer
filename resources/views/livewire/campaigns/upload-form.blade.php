<div>
    <form wire:submit.prevent="saveCampaign">
        <div class="shadow sm:rounded-md dark:bg-gray-900">
            <div class="px-4 py-3 text-lg sm:px-6 text-center dark:bg-gray-800 dark:text-white">
                {{ $campaign->exists ? __('Update Campaign') : __('Create Campaign') }}
            </div>

            <x-w-errors class="mx-4 my-2 sm:mx-6" />

            <div class="px-4 py-2 sm:px-6">
                <x-w-input
                    label="{!! __('Campaign Name') !!}"
                    placeholder="{!! __('Enter a name') !!}"
                    wire:model="campaign.campaign_name"
                    required
                />
            </div>

            <div class="px-4 py-2 sm:px-6">
                <x-w-input
                    label="{!! __('Campaign Description') !!}"
                    placeholder="{!! __('Enter a small description') !!}"
                    wire:model="campaign.campaign_description"
                />
            </div>

            <div class="px-4 py-2 sm:px-6">
                <x-w-input
                    label="{!! __('Campaign Destination') !!}"
                    placeholder="{!! __('Enter the destination') !!}"
                    wire:model="campaign.campaign_destination"
                    hint="{{ __('Enter the 3CX extension number you want the calls to be connected to.') }}"
                />
            </div>

            <div class="px-4 py-2 sm:px-6">
                <x-w-datetime-picker
                    label="{!! __('Starts On') !!}"
                    placeholder="{!! __('Select a start date') !!}"
                    wire:model="campaign.start_date"
                    required
                    without-time
                    without-tips
                    hint="{!! __('Dates are inclusive.') !!}"
                />
            </div>

            <div class="px-4 py-2 sm:px-6">
                <x-w-datetime-picker
                    label="{!! __('Ends On') !!}"
                    placeholder="{!! __('Select an end date') !!}"
                    wire:model="campaign.end_date"
                    without-time
                    without-tips
                    hint="{!! __('Dates are inclusive. Leave empty to run until all calls are made.') !!}"
                />
            </div>

            <div class="px-4 py-2 sm:px-6">
                <x-w-toggle
                    label="{!! __('Active') !!}"
                    wire:model="campaign.active"
                />
            </div>

            @if(!$campaign->exists)
                <div class="px-4 py-2 sm:px-6">
                    <x-w-input
                        wire:model="uploadFile"
                        label="{{ __('Upload Numbers File') }}"
                        hint="{{ __('Only CSV, XLS, and XLSX files are supported.') }}"
                        type="file"
                        required
                    />
                </div>
            @endif

            <div class="flex flex-row items-center justify-between mt-2 px-4 py-4 sm:px-6 bg-gray-100 text-right rounded-b-lg dark:bg-gray-800">
                <div class="flex items-center justify-start">
                    <a class="mt-1 text-sm text-gray-600 dark:text-gray-400 hover:text-primary-500" href="{{ route('campaigns.download-sample') }}" target="_blank">{{ __('Download sample file') }}</a>
                </div>
                <div class="flex items-center justify-end">
                    <x-secondary-button type="button" class="mr-3" wire:click="$dispatch('closeModal')" wire:loading.attr="disabled">{!! __('Cancel') !!}</x-secondary-button>
                    <x-button type="submit" wire:loading.attr="disabled">{!! $campaign->exists ? __('Update') : __('Create') !!}</x-button>
                </div>
            </div>
        </div>
    </form>
</div>
