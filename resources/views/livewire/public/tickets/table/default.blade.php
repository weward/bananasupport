{{-- <table class="table-auto w-full">
    <thead>
        <tr>
            <th class="p-2 text-sm text-gray-600">#</th>
            <th class="p-2 text-sm text-gray-600 md:w-1/3">Subject</th>
            <th class="p-2 text-sm text-gray-600">Status</th>
            <th class="p-2 text-sm text-gray-600">Last Actioned</th>
            <th class="p-2 text-sm text-gray-600"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tickets as $ticket)
        <tr class="hover:bg-amber-100 {{ $loop->odd ? 'bg-amber-50' : '' }}">
            <td class="p-2 text-sm text-gray-600">{{ $ticket->id_label }}</td>
            <td class="p-2 text-sm text-gray-600 md:w-1/3">{{ $ticket->subject }}</td>
            <td class="p-2 text-sm text-gray-600"><span class='p-1 px-2 rounded-lg text-xs text-white {{ $ticket->status ? "bg-green-400" : "bg-red-400" }}'>{{ $ticket->status_label }}</span></td>
            <td class="p-2 text-sm text-gray-600"><span class="text-xs ">{{ $ticket->readable_updated_at }}</span></td>
            <td class="p-2 text-sm text-gray-600 text-right">
                <span class="text-xl px-2 hover:text-amber-400 cursor-pointer"><ion-icon name="eye" class="md:visible"></ion-icon></span>
                <span class="text-xl px-2 hover:text-amber-400 cursor-pointer"><ion-icon name="create" class="md:visible"></ion-icon></span>
                <span class="text-xl px-2 hover:text-amber-400 cursor-pointer"><ion-icon name="trash" class="md:visible"></ion-icon></span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table> --}}

<div class="w-full">
    @if ($tickets->count())
        @foreach ($tickets as $ticket)
        <div class="flex justify-between p-3 mt-3 m-b-3 rounded-lg border bg-gray-50 hover:bg-amber-50 hover:cursor-pointer">
            <div class="lg:w-5/6 w-4/5">
                <div class="text-xs text-gray-600">{{ $ticket->id_label }}</div>
                <div class="font-extrabold text-md text-gray-900 truncate">{{ $ticket->subject }}</div>
                <div class="text-bold text-sm text-gray-900 truncate break-normal">{{ $ticket->content }}</div>
                
                <div class="pt-1 text-bold text-md text-gray-900 truncate">
                    <span class="text-xs text-gray-600">Last Updated: {{ $ticket->readable_updated_at }}</span>
                </div>
            </div>
            <div class="grid content-between min-w-fit">
                <div class="p-1 text-sm text-gray-600 text-right hover:bg-gray-100 h-fit rounded-lg ">
                    <span class="text-xl px-2 hover:text-amber-400 cursor-pointer"><ion-icon name="eye" class="md:visible"></ion-icon></span>
                    <span class="text-xl px-2 hover:text-amber-400 cursor-pointer"><ion-icon name="create" class="md:visible"></ion-icon></span>
                    <span class="text-xl px-2 hover:text-amber-400 cursor-pointer"><ion-icon name="trash" class="md:visible"></ion-icon></span>
                </div>
                <div class=" text-bold text-md text-gray-900 truncate text-right">
                    <span class='p-1 px-2 rounded-lg text-xs text-white {{ $ticket->status ? "bg-green-400" : "bg-red-400" }}'>{{ $ticket->status_label }}</span>
                </div>
            </div>
        </div>
        @endforeach 
    @endif
</div>
