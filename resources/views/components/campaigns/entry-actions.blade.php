<div class="flex items-center justify-end">
    @can('edit')
        <x-w-button.circle warning wire:click="editEntry({{ $attributes['entry']->id }})" icon="pencil" class="ml-1" />

        <x-w-button.circle negative wire:click="deleteEntry({{ $attributes['entry']->id }})" icon="x" class="ml-1" />
    @endcan
</div>
