<div>
    <form wire:submit.prevent="saveUser">
        <div class="shadow sm:rounded-md dark:bg-gray-900">
            <div class="px-4 py-3 text-lg sm:px-6 text-center dark:bg-gray-800 dark:text-white">
                {{ $user->exists ? __('Update User') : __('Create User') }}
            </div>

            <x-w-errors class="mx-4 my-2 sm:mx-6" />

            <div class="px-4 py-2 sm:px-6">
                <x-w-input
                    label="{!! __('Name') !!}"
                    placeholder="{!! __('Enter a name') !!}"
                    wire:model="user.name"
                    required
                />
            </div>

            <div class="px-4 py-2 sm:px-6">
                <x-w-input
                    type="email"
                    label="{!! __('Email') !!}"
                    placeholder="{!! __('Enter an email address') !!}"
                    wire:model="user.email"
                    required
                />
            </div>

            @if($user->exists)
            <div class="px-4 py-2 sm:px-6">
                <x-w-input
                    type="password"
                    label="{!! __('Change Password') !!}"
                    placeholder="{!! __('Enter a new password') !!}"
                    wire:model="newPassword"
                    hint="{{ __('Leave empty to keep current password.') }}"
                />
            </div>
            @else
                <div class="px-4 py-2 sm:px-6">
                    <x-w-input
                        type="password"
                        label="{!! __('Password') !!}"
                        placeholder="{!! __('Enter a password') !!}"
                        wire:model="newPassword"
                        required
                    />
                </div>

                <div class="px-4 py-2 sm:px-6">
                    <x-w-input
                        type="password"
                        label="{!! __('Confirm Password') !!}"
                        placeholder="{!! __('Confirm password') !!}"
                        wire:model="newPasswordConfirmation"
                        required
                    />
                </div>
            @endif

            <div class="px-4 py-2 sm:px-6">
                <x-w-select
                    label="{!! __('Role') !!}"
                    wire:model="user.role"
                    :options="\App\Models\User::getRoles(auth()->user()->role)"
                    option-key-value
                    required
                />
            </div>

            <div class="flex flex-row items-center justify-end mt-2 px-4 py-4 sm:px-6 bg-gray-100 text-right rounded-b-lg dark:bg-gray-800">
                <div class="flex items-center justify-end">
                    <x-secondary-button type="button" class="mr-3" wire:click="$dispatch('closeModal')" wire:loading.attr="disabled">{!! __('Cancel') !!}</x-secondary-button>
                    <x-button type="submit" wire:loading.attr="disabled">{!! $user->exists ? __('Update') : __('Create') !!}</x-button>
                </div>
            </div>
        </div>
    </form>
</div>
