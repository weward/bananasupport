<div class="px-1 py-3 md:py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="p-6 py-12 sm:px-20 bg-white border-b border-gray-200 text-center border-t-4 border-t-amber-200 rounded-xl">
                <div>
                    <x-jet-application-logo class="block h-24 max-h-full mx-auto w-full" />
                </div>

                <div class="mt-8 text-2xl">
                    Welcome back, {{ explode(" ", auth()->user()->name)[0] }}!
                </div>

                <div class="mt-6 text-gray-500">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. At dolores facilis, debitis culpa est odit voluptate sint corporis voluptas perferendis hic molestiae nostrum voluptatem recusandae, quis ipsa repellendus a qui.
                </div>
            </div>

            <div class="bg-amber-100 bg-opacity-25 grid grid-cols-1 md:grid-cols-3 mx-auto border-t border-gray-200 md:border-t-0 md:border-l ">

                <div class="py-12 md:p-6 md:border-r text-center">
                    <div class="">
                        <div class="text-lg text-gray-600 leading-7 font-semibold"><a href="{{ route('admin.livewire.tickets') }}">All Tickets</a></div>
                    </div>

                    <div class="">
                        <div class="mt-2 text-6xl text-gray-500">
                            {{ number_format($totalTickets) }}
                        </div>

                        <div>
                            <a href="{{ route('admin.livewire.tickets') }}">
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700 flex justify-center">
                                    <div>View Tickets</div>

                                    <div class="ml-1 text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="py-12 md:p-6  md:border-r text-center">
                    <div class="">
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="{{ route('admin.livewire.tickets') }}?status=open">Active Tickets</a></div>
                    </div>

                    <div class="grid grid-flow-row auto-rows-max text-center">
                        <div class="mt-2 text-6xl text-gray-500">
                            {{ number_format($activeTickets) }}
                        </div>

                        <div class="text-center">
                            <a href="{{ route('admin.livewire.tickets') }}?status=open">
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700 flex justify-center">
                                    <div>View Tickets</div>

                                    <div class="ml-1 text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="py-12 md:p-6  md:border-r text-center">
                    <div class="">
                        <div class="text-lg text-gray-600 leading-7 font-semibold"><a href="{{ route('admin.livewire.users') }}">Total Users</a></div>
                    </div>

                    <div class="grid grid-flow-row auto-rows-max text-center">
                        <div class="mt-2 text-6xl text-gray-500">
                            {{ number_format($totalUsers) }}
                        </div>

                        <div class="text-center">
                            <a href="{{ route('admin.livewire.users') }}">
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700 flex justify-center">
                                    <div>View Users</div>

                                    <div class="ml-1 text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>