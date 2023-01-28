<div >
    
    <x-slot name="header">
        <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
            <span class="self-center">
                {{ __($title) }}
            </span>
        </h2>
    </x-slot>

    <div class="pt-3" >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @include('livewire.admin.users.filter')
                
                <div class="invisible max-h-0 md:visible md:max-h-max">

                    @include('livewire.admin.users.table.default')
                    
                </div>
                
                <div class="visible max-h-max md:invisible md:max-h-0">

                    @include('livewire.admin.users.table.mobile')

                </div>
                
                <div class="mt-6">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>

    

    {{-- @livewire('edit-user-modal') --}}
    {{-- @livewire('update-user-modal') --}}
    @livewire('user-status-modal')
    
    
</div>
