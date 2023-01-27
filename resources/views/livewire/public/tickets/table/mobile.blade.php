@if ($tickets->count())
	<div class="container">
    @foreach ($tickets as $ticket)
		<table class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
			<thead class="text-gray-500">
                <tr class="bg-gray-100 flex flex-col flex-no wrap rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
					<th class="p-3 text-sm text-left border-b border-gray-50">Subject</th>
					<th class="p-3 text-sm text-left border-b border-gray-50">status</th>
					<th class="p-3 text-sm text-left border-b border-gray-50">Created</th>
					<th class="p-3 text-sm text-left border-b border-gray-50">Updated</th>
					<th class="p-3 text-sm text-left border-b border-gray-50" width="110px">Actions</th>
				</tr>
			</thead>
			<tbody class="flex-auto sm:flex-none w-full">
				<tr class="flex flex-col flex-nowrap mb-2 sm:mb-0">
					<td class="text-sm border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $ticket->subject }}</td>
					<td class="text-sm border-grey-light border hover:bg-gray-100 p-3">
                        <span class='p-1 px-2 rounded-lg text-xs text-white {{ $ticket->status ? "bg-green-400" : "bg-red-400" }}'>{{ $ticket->status_label }}</span>
                    </td>
					<td class="text-sm border-grey-light border hover:bg-gray-100 p-3">
						<span class="text-xs ">{{ $ticket->readable_created_at }}</span>
                    </td>
					<td class="text-sm border-grey-light border hover:bg-gray-100 p-3">
						<span class="text-xs ">{{ $ticket->readable_updated_at }}</span>
                    </td>
					<td class="flex text-sm border-grey-light border hover:bg-gray-100 pt-2 text-gray-600 hover:font-medium cursor-pointer justify-start">
                        <a 
							href="{{ route('livewire.tickets.show', $ticket->id) }}" 	
							class="text-lg px-6 pr-6 hover:text-amber-400 cursor-pointer">
							<ion-icon name="eye" class="visible"></ion-icon>
						</a>
						@if ($ticket->status)
                        <a 
							href="#" 
							class="text-lg px-3 hover:text-amber-400 cursor-pointer" 
							wire:click.prevent="$emitTo('edit-ticket-modal', 'editTicket', {{ $ticket->id }})" 
							>
							<ion-icon name="create" class="visible"></ion-icon>
						</a>
                        <a 
							href="#"
							class="text-lg pl-6 hover:text-amber-400 cursor-pointer"
							wire:click.prevent="$emitTo('delete-ticket-modal', 'deleteTicket', {{ $ticket->id }})"
							>
							<ion-icon name="trash" class="visible"></ion-icon>
						</a>
						@endif
                    </td>
				</tr>
			</tbody>
		</table>
    @endforeach
	</div>
@endif