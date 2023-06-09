<x-guest-layout>
    <x-jet-authentication-card >
        <x-slot name="logo">
            <x-jet-application-logo class="block h-24 mx-auto w-full" />
            <h1 class="text-center pt-3 text-lg text-amber-700 font-extrabold">BANANA SUPPORT</h1>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="mt-4 w-full">
                <div class="flex justify-between">
                    <div>
                        @if (Route::has('register'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                                {{ __('Register') }}
                            </a>
                        @endif
                    </div>
                    <div>
                        <x-jet-button class="ml-4 bg-amber-200 hover:bg-amber-100 text-black">
                            {{ __('Log in') }}
                        </x-jet-button>
                    </div>
                </div>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
