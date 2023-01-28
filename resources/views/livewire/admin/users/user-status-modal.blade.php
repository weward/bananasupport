<div>
    <x-jet-dialog-modal wire:model="showUserStatusModal">

        <x-slot name="content" >

            <div class="w-full">
                <div class="mt-3 text-lg font-extrabold">Are you sure you want {{ $user->active ?? false ? "deactivate" : "activate" }} this user?</div>
                <div class="mb-3 text-sm text-gray-600 ">Please review the details below:</div>
                <hr>
                <div class="mt-3 text-xs">Email</div>
                <div class="text-sm font-bold text-gray-600">{{ $user->email ?? '' }}</div>
                <div class="text-xs mt-3">Name</div>
                <div class="text-sm font-bold text-gray-600 break-normal">{!! $user->name ?? '' !!}</div>
                <div class="text-xs mt-3">Date Registered</div>
                <div class="text-sm font-bold text-gray-600 break-normal">{{ $user->formatted_created_at ?? '' }} <span class="text-xs text-gray-400 font-normal">({{ $user->readable_created_at ?? '' }})</span></div>
            </div>

        </x-slot>

        <x-slot name="footer" >

            <x-jet-secondary-button 
                id="delete-ticket-cancel"
                wire:click="$emitTo('user-status-modal', 'toggleModal', 'UserStatus', false)" 
                wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button  
                id="delete-ticket-submit"
                class="ml-3 bg-amber-600 hover:bg-amber-200"
                wire:click="$emitTo('user-status-modal', 'updateStatus', {{ $user->id ?? '' }})" 
                wire:ignoer.self
                wire:loading.attr="disabled">
                @if($user->active ?? ''){{ __('Deactivate') }} @else {{ __('Activate') }}@endif
            </x-jet-danger-button>
                
        </x-slot>
        
    </x-jet-dialog-modal>
      
</div>