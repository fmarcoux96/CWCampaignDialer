<div>
    <div wire:poll.visible>
        <div class="mb-6">
            @if($dialerStatus == 'active')
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">{{ __('Dialer is active') }}</strong>
                    <span class="block">{{ __('Dialer is currently active and making calls.') }}</span>
                </div>
            @elseif($dialerStatus == 'after-hours')
                <div class="bg-primary-100 text-primary-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">{{ __('Dialer is after hours') }}</strong>
                    <span class="block">{{ __('Dialer is currently paused for after-hours. Scheduled to restart at :next.', ['next' => $nextRunTime]) }}</span>
                </div>
            @elseif($dialerStatus == 'no-entries')
                <div class="bg-yellow-100 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">{{ __('Dialer is empty') }}</strong>
                    <span class="block">{{ __('Dialer is currently out of entries to dial.') }}</span>
                </div>
            @elseif($dialerStatus == 'disabled')
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">{{ __('Dialer is disabled') }}</strong>
                    <span class="block">{{ __('Dialer is currently disabled and not making calls') }}</span>
                </div>
            @endif
        </div>
        <div class="grid grid-cols-3 gap-3">
            <div class="col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <span class="block text-sm text-gray-900 dark:text-gray-200">
                    {{ __('Active Campaigns') }}
                </span>

                    <span class="text-xl text-gray-900 dark:text-gray-200">
                    {{ $activeCampaigns }}
                </span>
                </div>
            </div>
            <div class="col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <span class="block text-sm text-gray-900 dark:text-gray-200">
                    {{ __('Total Entries') }}
                </span>

                    <span class="text-xl text-gray-900 dark:text-gray-200">
                    {{ $totalEntries }}
                </span>
                </div>
            </div>
            <div class="col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <span class="block text-sm text-gray-900 dark:text-gray-200">
                    {{ __('Remaining Entries') }}
                </span>

                    <span class="text-xl text-gray-900 dark:text-gray-200">
                    {{ $remainingEntries }}
                </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-3 mt-3">
            <div class="col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <span class="block text-sm text-gray-900 dark:text-gray-200">
                    {{ __('Total Calls') }}
                </span>

                    <span class="text-xl text-gray-900 dark:text-gray-200">
                    {{ $totalDials }}
                </span>
                </div>
            </div>
            <div class="col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <span class="block text-sm text-gray-900 dark:text-gray-200">
                    {{ __('Successful Calls') }}
                </span>

                    <span class="text-xl text-gray-900 dark:text-gray-200">
                    {{ $successfulCalls }}
                </span>
                </div>
            </div>
            <div class="col-span-1">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <span class="block text-sm text-gray-900 dark:text-gray-200">
                    {{ __('Failed Calls') }}
                </span>

                <span class="text-xl text-gray-900 dark:text-gray-200">
                    {{ $failedCalls }}
                </span>
                </div>
            </div>
        </div>

        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200 mt-6">
            {{ __('Active Calls') }}
        </h3>
        <livewire:call-attempts-table scope="active" :slim="true" />

        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200 mt-6">
            {{ __('Latest Calls') }}
        </h3>
        <livewire:call-attempts-table scope="latest" :slim="true" />
    </div>
</div>
