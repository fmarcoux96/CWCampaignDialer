<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <x-w-button.circle lg primary href="{{ route('campaigns.index') }}" icon="arrow-left" />

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ml-3">
                    {{ __('Campaign | :name', ['name' => $campaign->campaign_name]) }}
                </h2>
            </div>

            <div class="flex items-center justify-end">
                @can('edit')
                    <x-w-button.circle warning onclick="Livewire.dispatch('openModal', { component: 'campaigns.upload-form', arguments: { campaign: {{ $campaign->id }} }})" icon="pencil" class="ml-1" />
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <livewire:campaigns.details :campaign="$campaign" />

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 mb-4">
            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                {{ __('Entries') }}
            </h3>
            <livewire:campaign-entries-table :campaign="$campaign" />
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 mb-4">
            <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                {{ __('Calls') }}
            </h3>
            <livewire:call-attempts-table :campaign="$campaign" />
        </div>
    </div>
</x-app-layout>
