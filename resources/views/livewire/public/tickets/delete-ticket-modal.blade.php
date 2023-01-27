<div>
    <x-jet-dialog-modal wire:model="showDeleteModal">

        <x-slot name="content" >

            <div class="w-full">
                <div class="mt-3 text-lg font-extrabold">Are you sure you want to delete this ticket?</div>
                <div class="mt-3 text-sm text-gray-600 ">Deleted tickets are no longer recoverable.</div>
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
                id="delete-ticket-cancel"
                wire:click="$emitTo('delete-ticket-modal', 'toggleTicketModal', 'Delete', false)" 
                wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button  
                id="delete-ticket-submit"
                class="ml-3 bg-amber-600 hover:bg-amber-200"
                wire:click="$emitTo('delete-ticket-modal', 'destroyTicket', {{ $ticket->id ?? '' }})" 
                wire:ignoer.self
                wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
                
        </x-slot>
        
    </x-jet-dialog-modal>
      
</div>