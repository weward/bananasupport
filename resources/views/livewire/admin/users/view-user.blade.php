<div>
    <div class="w-full">
        <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8">
            <div class="p-1 md:px-12 mt-3 m-b-3 bg-gray-50 rounded-lg border border-t-4 border-t-amber-200">
                <div class="p-6">
                    <div class="">
                        <div class="flex justify-between font-extrabold text-xs text-gray-600">
                            Name
                            <div class='p-1 px-2 rounded-lg text-xs text-white uppercase {{ $user->active ? "bg-green-400" : "bg-gray-300" }}'>{{ $user->status_label }}</div> 
                        </div>
                        <div class="text-md text-gray-600 italic">{{ $user->name }}</div>

                        <div class="mt-2 font-extrabold text-xs text-gray-600">Email</div>
                        <div class="text-md text-gray-600 italic">{{ $user->email }}</div>

                        <div class="mt-2 font-extrabold text-xs text-gray-600">Registered</div>
                        <div class="text-sm text-gray-600 italic">{{ $user->formatted_created_at }}</div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-1 my-6">
                <div class="flex justify-center p-3 mt-3 m-b-3">
                    
                    <x-jet-secondary-button 
                        id="user-page-update-status-toggle"
                        class="ml-3 font-bold"
                        wire:click.prevent="$emitTo('user-status-modal', 'loadUserStatus', {{ $user->id }})"
                        wire:ignoer.self
                        wire:loading.attr="disabled">
                        @if ($user->active) {{ "Deactivate" }} @else {{ "Activate" }} @endif
                    </x-jet-secondary-button>

                    <x-jet-secondary-button 
                        id="user-page-edit-modal-toggle"
                        class="ml-3 font-bold"
                        wire:click.prevent="$emitTo('edit-user-modal', 'editUser', {{ $user->id }})"
                        wire:ignoer.self
                        wire:loading.attr="disabled">
                            {{ __('Edit User')}} 
                    </x-jet-secondary-button>

                </div>
            </div>

            <div class="">
            @if ($user->tickets->count())
                @php ($tickets = $user->tickets)
                <div class="pt-3">
                    <div class="max-w-7xl mx-auto">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border border-t-4 border-t-amber-200">

                            <div class="mb-6">
                                <h3 class="">Latest Tickets</h3>
                            </div>

                            <div class="invisible max-h-0 md:visible md:max-h-max">

                                @include('livewire.public.tickets.table.default')
                                
                            </div>
                            
                            <div class="visible max-h-max md:invisible md:max-h-0">

                                @include('livewire.public.tickets.table.mobile')

                            </div>

                        </div>
                    </div>
                </div>
            @endif
            </div>

        </div>

        @livewire('user-status-modal')
        @livewire('edit-user-modal')

    </div>

</div>
