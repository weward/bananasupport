
<div class="w-full text-right">
    
    <x-jet-secondary-button 
        id="show-ticket-filter-btn"
        wire:loading.attr="disabled"
        class="px-4 py-2 rounded-md text-xl hover:bg-gray-200 hover:text-white click:text-black"
        wire:click="goToRoute('livewire.users')">
            <ion-icon name="refresh" class="visible"></ion-icon>
    </x-jet-secondary-button>
        
    <x-jet-secondary-button 
        id="show-ticket-filter-btn"
        wire:loading.attr="disabled"
        class="px-4 py-2 rounded-md text-xl bg-amber-200 hover:bg-amber-100 hover:text-gray-900 click:text-black"
        wire:click="$toggle('showUsersFilter')">
            @if (! $showUsersFilter) <ion-icon name="funnel" class="visible"></ion-icon> @else  <ion-icon name="close" class="visible"></ion-icon>  @endif 
    </x-jet-secondary-button>
    

    @if ($showUsersFilter)
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        
        <div>

            <x-jet-form-section submit="filter"  class="text-center">

                <x-slot name="description">
                    {{ __('Filter Tickets') }}
                </x-slot>

                <x-slot name="form">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-3 md:pr-2">
                            <x-jet-label for="filter-users-search" class="text-left" value="{{ __('Search') }}"/>
                            <x-jet-input 
                                id="filter-users-search" 
                                type="text" 
                                class="mt-1 block w-full"
                                placeholder="Name or email"
                                wire:model.defer="search" 
                                autofocus />
                            <x-jet-input-error for="search" class="mt-2 text-left" />
                        </div>

                        <div class="col-span-12 md:col-span-3 md:pr-2">
                            <x-jet-label for="filter-users-status" class="text-left" value="{{ __('Status') }}"/>
                            <select 
                                id="filter-users-status"
                                wire:model.defer="active"
                                wire:loading.attr="disabled"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <x-jet-input-error for="active" class="mt-2 text-left" />
                        </div>

                        <div class="col-span-12 md:col-span-3 md:pl-2 md:pr-2">
                            <x-jet-label for="filter-users-sort" class="text-left" value="{{ __('Order By') }}"/>
                            <select 
                                id="filter-users-sort"
                                wire:model.defer="orderBy"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">Any</option>
                                <option value="created_at">Date Created</option>
                                <option value="updated_at">Date Updated</option>
                            </select>
                            <x-jet-input-error for="orderBy" class="mt-2 text-left" />
                        </div>

                        <div class="col-span-12 md:col-span-3 md:pl-2">
                            <x-jet-label for="filter-users-sort-order" class="text-left" value="{{ __('Sort By') }}"/>
                            <select 
                                id="filter-users-sort-order"
                                wire:model.defer="sortBy"
                                wire:loading.attr="disabled"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full">
                                <option value="">Any</option>
                                <option value="DESC" selected>Latest First</option>
                                <option value="ASC">Oldest First</option>
                            </select>
                            <x-jet-input-error for="sortBy" class="mt-2 text-left" />
                        </div>

                    </div>
                </x-slot>
            </x-jet-form-section>

        </div>

        <div class="flex justify-center mt-12">
            <x-jet-secondary-button 
                id="hide-user-filter-btn"
                wire:click="filterUsers"
                wire:loading.attr="disabled"
                class="ml-2 px-4 py-2 rounded-md bg-amber-200 hover:bg-amber-100 hover:text-gray-900 click:text-black">
                    {{ _('Filter') }}
            </x-jet-secondary-button>
        </div>


    </div>
    @endif
</div>