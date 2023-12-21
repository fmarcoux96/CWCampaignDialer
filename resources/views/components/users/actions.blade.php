<div class="flex items-center justify-end">
    @if(auth()->user()->role != 'superadmin' && $attributes['user']->role == 'superadmin')
        <span class="text-red-500 font-bold">{{ __('System User') }}</span>
    @else
        @can('edit')
            <x-w-button.circle warning wire:click="editUser({{ $attributes['user']->id }})" icon="pencil" class="ml-1" />

            <x-w-button.circle negative wire:click="deleteUser({{ $attributes['user']->id }})" icon="x" class="ml-1" />
        @endcan
    @endif
</div>
