<div>
    <div wire:key="last-run-banner" wire:poll.visible>
        @if($shouldShow)
            <div class="bg-red-700">
                <div class="max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between flex-wrap">
                        <div class="w-0 flex-1 flex items-center min-w-0">
                        <span class="flex p-2 rounded-lg bg-red-600">
                            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </span>

                            <p class="ms-3 font-medium text-sm text-white truncate">
                                {{ __("The 3CX Dialer has not run in :m minutes. Please dial :e to start it again.", ['m' => $minutes, 'e' => $dialerExtension]) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
