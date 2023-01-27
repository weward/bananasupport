<div >
    
    <x-slot name="header">
        <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
            <span class="self-center">
                {{ __($title) }}
            </span>
            @if (! auth()->guard('admin')->check())
            <div class="visible sm:invisible">
                @livewire('new-ticket-modal')
            </div>
            @endif
        </h2>
    </x-slot>

    <div class="pt-3" >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @include('livewire.public.tickets.filter')
                
                <div class="invisible max-h-0 md:visible md:max-h-max">

                    @include('livewire.public.tickets.table.default')
                    
                </div>
                
                <div class="visible max-h-max md:invisible md:max-h-0">

                    @include('livewire.public.tickets.table.mobile')

                </div>
                
                <div class="mt-6">
                    {{ $tickets->links() }}
                </div>

            </div>
        </div>
    </div>

    @livewire('edit-ticket-modal')
    @livewire('delete-ticket-modal')
    @livewire('close-ticket-modal')
    
    
</div>
