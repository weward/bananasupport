@if ($users->count())
	<div class="container">
    @foreach ($users as $user)
		<table class="w-full flex flex-row flex-no-wrap border border-t-2 border-t-amber-200 sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
			<thead class="text-gray-500">
                <tr class="bg-gray-100 flex flex-col flex-no wrap rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
					<th class="p-3 text-sm text-left font-normal border-b border-gray-50">Name</th>
					<th class="p-3 text-sm text-left font-normal border-b border-gray-50">Email</th>
					<th class="p-3 text-sm text-left font-normal border-b border-gray-50">Tickets</th>
					<th class="p-3 text-sm text-left font-normal border-b border-gray-50">Active</th>
					<th class="p-3 text-sm text-left font-normal border-b border-gray-50">Created</th>
					<th class="p-3 text-sm text-left font-normal border-b border-gray-50" width="10px">Actions</th>
				</tr>
			</thead>
			<tbody class="flex-auto sm:flex-none w-full">
				<tr class="flex flex-col flex-nowrap mb-2 sm:mb-0">
					<td class="text-sm border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $user->name }}</td>
					<td class="text-sm border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $user->email }}</td>
					<td class="text-sm border-grey-light border hover:bg-gray-100 p-3 truncate">{{ $user->ticket_count ?? '0' }}</td>
					<td class="text-sm border-grey-light border hover:bg-gray-100 p-3">
                        <span class='p-1 px-2 rounded-lg text-xs text-white {{ $user->active ? "bg-green-400" : "bg-red-400" }}'>{{ $user->status_label }}</span>
                    </td>
					<td class="text-sm border-grey-light border hover:bg-gray-100 p-3">
						<span class="text-xs ">{{ $user->formatted_created_at }}</span>
                    </td>
					<td class="flex text-sm border-grey-light border hover:bg-gray-100 pt-2 text-gray-600 hover:font-medium cursor-pointer justify-start">
                        <a 
							href="{{ route('admin.livewire.tickets.show', $user->id) }}" 	
							class="text-lg px-6 pr-6 hover:text-amber-400">
							<ion-icon name="eye" class="visible"></ion-icon>
						</a>
                        <a 
							href="#" 
							class="text-lg px-3 hover:text-amber-400" 
							wire:click.prevent="$emitTo('edit-user-modal', 'editUser', {{ $user->id }})" 
							>
							<ion-icon name="create" class="visible"></ion-icon>
						</a>
                        <a 
							href="#"
							class="text-lg pl-6 @if ($user->active) {{ 'text-green-600 hover:text-gray-400 font-extrabold' }} @else {{ 'text-gray-400 hover:text-green-400' }} @endif"
							wire:click.prevent="$emitTo('user-status-modal', 'loadUserStatus', {{ $user->id }})"
							>
							<ion-icon name="power" class="visible"></ion-icon>
						</a>
                    </td>
				</tr>
			</tbody>
		</table>
    @endforeach
	</div>
@endif