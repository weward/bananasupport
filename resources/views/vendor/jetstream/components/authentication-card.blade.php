<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 p-1 sm:p-none sm:pt-0 bg-amber-50">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white border-t-4 border-t-amber-200 shadow-md overflow-hidden sm:rounded-lg border-2">
        {{ $slot }}
    </div>
</div>
