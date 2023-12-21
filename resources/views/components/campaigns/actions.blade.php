<div class="flex items-center justify-end">
    <x-w-button.circle primary href="{{ route('campaigns.show', $attributes['campaign']) }}" icon="eye" />

    @can('edit')
        <x-w-button.circle warning wire:click="editCampaign({{ $attributes['campaign']->id }})" icon="pencil" class="ml-1" />

        <x-w-button.circle negative wire:click="deleteCampaign({{ $attributes['campaign']->id }})" icon="x" class="ml-1" />
    @endcan
</div>
