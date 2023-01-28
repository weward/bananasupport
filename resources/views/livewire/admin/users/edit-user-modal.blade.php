<div>
    <x-jet-dialog-modal wire:model="showEditUserModal">

        <x-slot name="content">
            
            <x-jet-form-section submit="updateUser" class="m-auto" >
                <x-slot name="title">
                    {{ __('Edit User')}}
                </x-slot>

                <x-slot name="description">
                    <div class="text-sm italic"></div>
                </x-slot>

                <x-slot name="form">
                    
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="edit-name" class="text-left" value="{{ __('Name') }}" />
                        <x-jet-input 
                            id="edit-name" 
                            type="text" 
                            class="mt-1 block w-full" 
                            wire:model.defer="formData.name" 
                            wire:key="{{ time() }}-edit-user-name" 
                            autofocus
                        />
                        <x-jet-input-error for="formData.name" class="mt-2 text-left" />
                    </div>
                    
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="edit-email" class="text-left"  value="{{ __('Email') }}"/>
                        <x-jet-input 
                            id="edit-email" 
                            type="text" 
                            class="mt-1 block w-full" 
                            wire:model.defer="formData.email" 
                            wire:key="{{ time() }}-edit-user-email" 
                        />
                        <x-jet-input-error for="formData.email" class="mt-2 text-left" />
                    </div>

                    <div class="col-span-6 sm:col-span-4 body-content" wire:ignore>
                        <x-jet-label for="edit-user-status" class="text-left" value="{{ __('Status') }}"/>
                        <select 
                                id="edit-user-status"
                                wire:model.defer="formData.active"
                                wire:loading.attr="disabled"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>

                        <x-jet-input-error for="formData.active" class="mt-2 text-left" />
                    </div>

                    <div class="">
                        <div class="text-xs italic text-gray-600">Created: {{$user->formatted_created_at ?? ''}}</div>
                    </div>

                </x-slot>
            </x-jet-form-section>

        </x-slot>

        <x-slot name="footer" >
                
            <x-jet-secondary-button 
                id="edit-user-cancel"
                wire:click="$emitTo('edit-user-modal', 'toggleModal', 'EditUser', false)" 
                wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button  
                id="edit-user-submit"
                class="ml-3 bg-amber-400 hover:bg-amber-200"
                wire:click="updateUser" 
                wire:ignoer.self
                wire:loading.attr="disabled">
                {{ __('Update') }}
            </x-jet-button>
                
        </x-slot>
        
    </x-jet-dialog-modal>
      
</div>
