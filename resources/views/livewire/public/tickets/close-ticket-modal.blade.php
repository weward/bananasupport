<div>
    <x-jet-dialog-modal wire:model="showCloseModal">

        <x-slot name="content" >

            <div class="w-full">
                <div class="mt-3 text-lg font-extrabold">Are you sure you want to close this ticket?</div>
                <div class="mb-3 text-sm text-gray-600 ">Please review the details below:</div>
                <hr>
                <div class="mt-3 text-xs">Ticket ID</div>
                <div class="text-sm font-bold text-gray-600">#{{ $ticket->id_label ?? '' }}</div>
                <div class="text-xs mt-3">Subject:</div>
                <div class="text-sm font-bold text-gray-600 break-normal">{!! $ticket->subject ?? '' !!}</div>
            </div>

        </x-slot>

        <x-slot name="footer" >

            <x-jet-secondary-button 
                id="close-ticket-cancel"
                wire:click="$emitTo('close-ticket-modal', 'toggleTicketModal', 'Close', false)" 
                wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button  
                id="close-ticket-submit"
                class="ml-3 bg-amber-600 hover:bg-amber-200"
                wire:click="$emitTo('close-ticket-modal', 'disableTicket', {{ $ticket->id ?? '' }})" 
                wire:ignoer.self
                wire:loading.attr="disabled">
                {{ __('Close Ticket') }}
            </x-jet-danger-button>
                
        </x-slot>
        
    </x-jet-dialog-modal>
      
</div>