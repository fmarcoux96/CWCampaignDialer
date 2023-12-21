<x-button wire:click="$dispatch('openModal', { component: 'campaigns.entry-form', arguments: { campaign: {{ $this->campaign->id }} } })">
    {{ __('New Entry') }}
</x-button>
