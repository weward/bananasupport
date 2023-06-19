<div class="w-full">
    @if ($tickets->count())
        @foreach ($tickets as $ticket)
        <div class="flex justify-between p-6 mt-3 m-b-3 rounded-lg border hover:bg-gray-100
            @if ($ticket->status) {{ 'border-l-4 border-l-green-200' }} @else {{ 'border-l-4 border-l-red-200' }} @endif
            ">
            <div class="lg:w-5/6 w-4/5">
                <div class="text-xs text-gray-600">{{ $ticket->id_label }}</div>
                <div class="font-extrabold text-md text-gray-900 truncate">{{ $ticket->subject }}</div>
                <div class="text-xs text-gray-600">By {{ $ticket->reporter->name ?? '' }}</div>
                <div class="mt-3 text-bold text-sm text-gray-900 truncate break-normal">{{ $ticket->content }}</div>
                
                <div class="pt-1 text-bold text-md text-gray-900 truncate">
                    <span class="text-xs text-gray-600">Created: {{ $ticket->formatted_created_at }}</span>
                </div>
            </div>
            <div class="grid content-between min-w-fit">
                <div class="p-1 text-sm text-gray-600 text-right hover:bg-gray-50 h-fit rounded-lg ">
                    <a 
                        href="@if(auth()->guard('admin')->check()) 
                            {{ route('admin.livewire.tickets.show', $ticket->id) }}
                            @else 
                            {{ route('livewire.tickets.show', $ticket->id) }} 
                            @endif" 
                        class="text-xl px-2 hover:text-amber-400 "
                        >
                        <ion-icon name="eye" class="md:visible"></ion-icon>
                    </a>
                    @if ($ticket->status && ! auth()->guard('admin')->check())
                    <a
                        href="#"
                        class="text-xl px-2 hover:text-amber-400 "
                        wire:click.prevent="$emitTo('edit-ticket-modal', 'editTicket', {{ $ticket->id }})"
                        >
                        <ion-icon name="create" class="md:visible"></ion-icon>
                    </a>
                        
                    <a
                        href="#"
                        class="text-xl px-2 hover:text-amber-400 "
                        wire:click.prevent="$emitTo('delete-ticket-modal', 'deleteTicket', {{ $ticket->id }})"
                        >
                        <ion-icon name="trash" class="md:visible"></ion-icon>
                    </a>
                    @endif
                </div>
                <div class="text-bold text-md text-gray-900 truncate text-right">
                    <span class='p-1 px-2 rounded-lg text-xs text-white {{ $ticket->status ? "bg-green-400" : "bg-red-400" }}'>{{ $ticket->status_label }}</span>
                </div>
                @if ($ticket->has_been_updated)
                <div class=" text-bold text-md text-gray-900 truncate text-right">
                    <span class="text-xs text-gray-600 italic">Last Updated: {{ $ticket->readable_updated_at }}</span>
                </div>
                @endif
            </div>
        </div>
        
        @endforeach 
    @endif 
    
    @if (!$tickets->count() && $isReady)
        <div class="text-center" wire:loading.remove>
            <p class="p-12 text=sm text-gray-600 italic">There are no tickets.</p>
        </div>
    @endif

</div>
