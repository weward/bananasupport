<div>
    <div class="w-full">
        <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8">
            <div class="md:p-12 mt-3 m-b-3 border bg-amber-50 hover:bg-amber-100">
                <div class="p-6">
                    <div class="">
                        <div class="flex justify-between font-extrabold text-md text-gray-600">
                            Ticket #

                            <div class='p-2 px-4 rounded-lg text-sm text-white uppercase {{ $ticket->status ? "bg-green-400" : "bg-red-400" }}'>{{ $ticket->status_label }}</div>
                            
                        </div>
                        <div class="text-sm text-gray-600 italic">{{ $ticket->id_label }}</div>

                        <div class="mt-2 font-extrabold text-md text-gray-600">Author</div>
                        <div class="text-sm text-gray-600 italic">{{ $ticket->reporter?->name }}</div>

                        <div class="mt-2 font-extrabold text-md text-gray-600">Subject</div>
                        <div class="text-sm text-gray-600 italic">{{ $ticket->subject }}</div>

                        <div class="mt-2 font-extrabold text-md text-gray-600">Content</div>
                        <div class="text-sm text-gray-600 italic">{!! nl2br($ticket->content) !!}</div>

                        <div class="mt-2 font-extrabold text-sm text-gray-600">Created</div>
                        <div class="text-xs text-gray-600 italic">{{ $ticket->formatted_created_at }}</div>
                        
                        @if ($ticket->has_been_updated)
                            <div class="mt-2 font-extrabold text-sm text-gray-600">Last Updated</div>
                            <div class="text-xs text-gray-600 italic">{{ $ticket->readable_updated_at }}</div>                   
                        @endif
                    </div>
                </div>
            </div>

            <div class="">
            @if ($ticket->comments->count())
                @foreach ($ticket->comments as $comment)

                <div class="md:p-12 p-6 pt-6 pb-6 mt-3 m-b-3 rounded-lg border bg-gray-50 hover:bg-amber-50
                    @if ($comment->is_admin) {{ 'border-l-8 border-l-gray-200' }} @else {{ 'border-l-8 border-l-amber-100' }} @endif">
                    <div class="md:px-6">
                        <div class="flex justify-between">
                            <div class="font-extrabold text-md text-gray-900">
                                {{ $comment->is_admin ? 'Admin' : $comment->commentable->name }}
                            </div>
                            <div class="text-xs align-right text-gray-600">{{ $comment->readable_created_at }}</div>
                        </div>
                        <div class="pt-1 text-bold text-md text-gray-900">
                            <span class="text-xs text-gray-600">{{ $comment->formatted_created_at }}</span>
                        </div>
                        <div class="pt-6 text-md bolder text-gray-600">{{ $comment->subject }}</div>
                        <div class="text-md text-gray-600">{{ $comment->content }}</div>
                        
                    </div>
                </div>
                
                @endforeach 
            @endif
            </div>

            @if ($ticket->status)
            <div class="my-6">
                <div class="md:p-12 p-6 pt-6 pb-6 mt-3 m-b-3 rounded-lg border border-t-8 border-t-amber-300 bg-gray-50">
                    <h3 class="text-lg">Reply</h3>
                    <div>
                        <x-jet-form-section submit="viewTicket"  class="text-center">
                            <x-slot name="form">
                                <div class="col-span-6 sm:col-span-4">
                                    <x-jet-label for="view-ticket-content" class="text-left" value="{{ __('') }}"/>
                                    <textarea 
                                        id="view-ticket-content" 
                                        rows="5"
                                        class="mt-6 block w-full rounded-md shadow-sm"
                                        autofocus
                                        wire:model.defer="formData.content">
                                    </textarea>
                                    <x-jet-input-error for="formData.content" class="mt-2 text-left text-red-500" />
                                </div>
                            </x-slot>
                        </x-jet-form-section>

                        <div class="mt-6 col-span-6 sm:col-span-4 body-content text-center">
                            <x-jet-secondary-button 
                                id="view-ticket-close"
                                wire:click="goToRoute('livewire.tickets')" 
                                wire:loading.attr="disabled">
                                {{ __('Close') }}
                            </x-jet-secondary-button>

                            <x-jet-button  
                                id="view-ticket-submit"
                                class="text-md bg-amber-400 hover:bg-amber-200"
                                wire:click="createNewComment" 
                                wire:ignoer.self
                                wire:loading.attr="disabled">
                                {{ __('Submit') }}
                            </x-jet-button>
                        </div>
                        
                    </div>
                </div>
            </div>
            @endif

        </div>
   
    </div>
 
    @push('commands')
    <div 
        x-data
        x-init="window.scrollTo({top: 10000000, behavior: 'smooth'})"
        class="">
    </div>
    @endpush

</div>