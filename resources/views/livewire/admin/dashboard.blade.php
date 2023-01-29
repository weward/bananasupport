<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <div class="p-6 sm:px-20 bg-white border-b border-gray-200 text-center border-t-4 border-t-amber-200 rounded-xl">
                <div>
                    <x-jet-application-logo class="block h-24 mx-auto w-auto" />
                </div>

                <div class="mt-8 text-2xl">
                    Welcome back, {{ explode(" ", auth()->user()->name)[0] }}!
                </div>

                <div class="mt-6 text-gray-500">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. At dolores facilis, debitis culpa est odit voluptate sint corporis voluptas perferendis hic molestiae nostrum voluptatem recusandae, quis ipsa repellendus a qui.
                </div>
            </div>

            <div class="bg-amber-100 bg-opacity-25 grid grid-cols-1 @if(auth()->guard('admin')->check()) {{ 'md:grid-cols-3' }}@else{{ 'md:grid-cols-2' }}@endif mx-auto border-t border-gray-200 md:border-t-0 md:border-l ">

                <div class="p-6 md:border-r">
                    <div class="flex items-center">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg> --}}
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://bitbucket.org/rolandedwardsantos">All Tickets</a></div>
                    </div>

                    <div class="ml-12 grid grid-flow-row auto-rows-max">
                        <div class="mt-2 text-6xl text-gray-500">
                            {{ "7,201" }}
                            {{-- <span class=""><span class="text-lg font-extrabold text-green-400">Active</span></span> --}}
                        </div>

                        <div>
                            <a href="@if(auth()->guard('admin')->check()){{ route('admin.livewire.tickets') }}@else{{ route('livewire.tickets') }}@endif">
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
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

                <div class="p-6 md:border-r">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://bitbucket.org/rolandedwardsantos">Active Tickets</a></div>
                    </div>

                    <div class="ml-12 grid grid-flow-row auto-rows-max">
                        <div class="mt-2 text-6xl text-gray-500">
                            {{ "7,201" }}
                            <span class=""><span class="text-lg font-extrabold text-green-400">Active</span></span>
                        </div>

                        <div>
                            <a href="@if (auth()->guard('admin')->check()) {{ route('admin.livewire.users') }} @endif">
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
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

                @if(auth()->guard('admin')->check())
                <div class="p-6 ">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://bitbucket.org/rolandedwardsantos">Users</a></div>
                    </div>

                    <div class="ml-12 grid grid-flow-row auto-rows-max">
                        <div class="mt-2 text-6xl text-gray-500">
                            {{ "7,201" }}
                            <span class=""><span class="text-lg font-extrabold text-green-400">Active</span></span>
                        </div>

                        <div>
                            <a href="https://laravel.com/docs">
                                <div class="mt-3 flex items-center text-sm font-semibold text-indigo-700">
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
                @endif

                {{-- <div class="p-6 border-t border-gray-200">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://tailwindcss.com/">Tailwind</a></div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-sm text-gray-500">
                            Laravel Jetstream is built with Tailwind, an amazing utility first CSS framework that doesn't get in your way. You'll be amazed how easily you can build and maintain fresh, modern designs with this wonderful framework at your fingertips.
                        </div>
                    </div>
                </div> --}}


            </div>


        </div>
    </div>
</div>