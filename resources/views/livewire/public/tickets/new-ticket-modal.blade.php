<div>
    <div>
        <x-jet-secondary-button 
            id="new-ticket-btn"
            wire:loading.attr="disabled"
            class="px-4 py-2 rounded-md bg-amber-400 hover:bg-amber-200 click:text-black text-white"
            wire:click="$emit('toggleTicketModal', 'New', true)">
                {{ _('Support') }}
        </x-jet-secondary-button>
    </div>

    <x-jet-dialog-modal wire:model="showNewModal">

        <x-slot name="content">
            
            <x-jet-form-section submit="newTicket"  class="text-center">
                <x-slot name="title">
                    {{ __('Create New Support Ticket') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum perspiciatis fugit facere expedita exercitationem aspernatur temporibus neque.') }}
                </x-slot>

                <x-slot name="form">
                    <!-- Token Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="subject" class="text-left" value="{{ __('Subject') }}"/>
                        <x-jet-input 
                            id="subject" 
                            type="text" 
                            class="mt-1 block w-full"
                            wire:model.defer="formData.subject" 
                            autofocus />
                        <x-jet-input-error for="formData.subject" class="mt-2 text-left" />
                    </div>

                    <div class="col-span-6 sm:col-span-4 body-content" wire:ignore>
                        <x-jet-label for="content" class="text-left" value="{{ __('Content') }}"/>
                        <textarea 
                            id="content" 
                            rows="5"
                            class="mt-1 block w-full rounded-md shadow-sm"
                            autofocus
                            wire:model.defer="formData.content">
                        </textarea>

                        <x-jet-input-error for="formData.content" class="mt-2 text-left" />
                    </div>

                </x-slot>
            </x-jet-form-section>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button 
                id="new-ticket-cancel"
                wire:click="$emit('toggleTicketModal', 'New', false)" 
                wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button  
                id="new-ticket-submit"
                class="ml-3 bg-amber-400 hover:bg-amber-200"
                wire:click="createNewTicket" 
                wire:ignoer.self
                wire:loading.attr="disabled">
                {{ __('Submit') }}
            </x-jet-button>
        </x-slot>
        
    </x-jet-dialog-modal>
            
</div>