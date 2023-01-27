<div>
    <x-jet-dialog-modal wire:model="showEditModal">

        <x-slot name="content" >
            
            <x-jet-form-section submit="updateTicket" class="m-auto" >
                <x-slot name="title">
                    {{ __('Edit Support Ticket')}}
                </x-slot>

                <x-slot name="description">
                    Ticket ID # <div class="text-sm italic">{{$ticket->id_label ?? ''}}</div>
                </x-slot>

                <x-slot name="form">
                    
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="edit-subject" class="text-left" value="{{ __('Subject') }}"/>
                        <x-jet-input id="edit-subject" type="text" class="mt-1 block w-full" wire:model.defer="formData.subject" wire:key="{{ time() }}-edit-ticket-suibject" autofocus />
                        <x-jet-input-error for="formData.subject" class="mt-2 text-left" />
                    </div>

                    <div class="col-span-6 sm:col-span-4 body-content" wire:ignore>
                        <x-jet-label for="edit-content" class="text-left" value="{{ __('Content') }}"/>
                        <textarea 
                            id="edit-content" 
                            rows="5"
                            class="mt-1 block w-full rounded-md shadow-sm"
                            autofocus
                            wire:model.defer="formData.content">
                        </textarea>

                        <x-jet-input-error for="formData.content" class="mt-2 text-left" />
                    </div>

                    <div class="">
                        <div class="text-xs italic text-gray-600">Created: {{$ticket->formatted_created_at ?? ''}}</div>
                        @if ($ticket->has_been_updated ?? false)
                        <div class="text-xs italic text-gray-600">Last Updated: {{$ticket->readable_updated_at ?? ''}}</div>
                        @endif
                    </div>

                </x-slot>
            </x-jet-form-section>

        </x-slot>

        <x-slot name="footer" >
                
            <x-jet-secondary-button 
                id="edit-ticket-cancel"
                wire:click="$emit('toggleTicketModal', 'Edit', false)" 
                wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button  
                id="edit-ticket-submit"
                class="ml-3 bg-amber-400 hover:bg-amber-200"
                wire:click="updateTicket" 
                wire:ignoer.self
                wire:loading.attr="disabled">
                {{ __('Update') }}
            </x-jet-button>
                
        </x-slot>
        
    </x-jet-dialog-modal>
      
</div>
