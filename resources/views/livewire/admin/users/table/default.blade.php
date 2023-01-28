<div>
    @if ($users->count())
    <div class="w-full border border-t-2 border-t-amber-200 rounded-t-xl">
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="border-b-4 border-b-gray-100 p-3">Name</th>
                    <th class="border-b-4 border-b-gray-100 p-3">Email</th>
                    <th class="border-b-4 border-b-gray-100 p-3">Tickets</th>
                    <th class="border-b-4 border-b-gray-100 p-3">Active</th>
                    <th class="border-b-4 border-b-gray-100 p-3"></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="@if($loop->odd) {{ 'bg-gray-50' }} @else {{ '' }} @endif hover:bg-gray-100">
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3"></td>
                    <td class="p-3"><span class='p-1 px-2 rounded-lg text-xs text-white {{ $user->active ? "bg-green-400" : "bg-gray-300" }}'>{{ $user->status_label }}</span></td>
                    <td class="p-3 text-right">
                        <a 
                            href=""
                            class="text-xl px-2 hover:text-amber-400 cursor-pointer"
                            >
                            <ion-icon name="eye" class="md:visible"></ion-icon>
                        </a>
                        <a
                            href="#"
                            class="text-xl px-2 hover:text-amber-400 cursor-pointer"
                            wire:click.prevent="$emitTo('edit-ticket-modal', 'editTicket', {{ $user->id }})"
                            >
                            <ion-icon name="create" class="md:visible"></ion-icon>
                        </a>    
                        <a
                            href="#"
                            class="text-xl px-2 @if ($user->active) {{ 'text-green-600 hover:text-gray-400 ' }} @else {{ 'text-gray-400 hover:text-green-400' }} @endif cursor-pointer"
                            wire:click.prevent="$emitTo('user-status-modal', 'loadUserStatus', {{ $user->id }})"
                            >
                            <ion-icon name="power" class="md:visible"></ion-icon>
                        </a>
                    </td>
                </tr>
            @endforeach 
            </tbody>
        </table>        
        
    </div>
    @else 
        <div class="text-center">
            <p class="p-12 text=sm text-gray-600 italic">There are no users.</p>
        </div>

    @endif
</div>
