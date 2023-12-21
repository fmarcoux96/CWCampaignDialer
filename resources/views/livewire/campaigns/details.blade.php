<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4" wire:poll.visible>
        <div class="col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <dl class="divide-y divide-gray-200 dark:divide-gray-500">
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-200">
                        {{ __('Name') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-200">
                        {{ $campaign->campaign_name }}
                    </dd>
                </div>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-200">
                        {{ __('Description') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-200">
                        {{ $campaign->campaign_description }}
                    </dd>
                </div>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-200">
                        {{ __('Destination') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-200">
                        {{ $campaign->campaign_destination ?? __('Not Set') }}
                    </dd>
                </div>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-200">
                        {{ __('Status') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-200 flex items-center justify-start">
                        @if($campaign->campaign_file_processed)
                            <x-w-badge primary>{{ __('Processed') }}</x-w-badge>
                        @else
                            <x-w-badge danger>{{ __('Not Processed') }}</x-w-badge>
                        @endif

                        @if(auth()->user()->role == 'superadmin')
                            <x-w-button.circle xs icon="refresh" wire:click="reprocessFile()" class="ml-1" />
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
        <div class="col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <dl class="divide-y divide-gray-200 dark:divide-gray-500">
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-200">
                        {{ __('Starts On') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-200">
                        {{ $campaign->start_date->toFormattedDayDateString() }}
                    </dd>
                </div>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-200">
                        {{ __('Ends On') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-200">
                        {{ $campaign->end_date?->toFormattedDayDateString() ?? __('N/A') }}
                    </dd>
                </div>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-200">
                        {{ __('Active') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-200">
                        {{ $campaign->active ? __('Yes') : __('No') }}
                    </dd>
                </div>
            </dl>
        </div>
        <div class="col-span-1 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <dl class="divide-y divide-gray-200 dark:divide-gray-500">
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-200">
                        {{ __('Total Entries') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-200">
                        {{ $campaign->entries_count }}
                    </dd>
                </div>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-200">
                        {{ __('Remaining') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-200">
                        {{ $campaign->entries()->remaining()->count() }}
                    </dd>
                </div>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 dark:bg-gray-800">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-200">
                        {{ __('Total Calls') }}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-gray-200">
                        {{ $campaign->calls_count }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
