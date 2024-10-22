<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                {{ __('Make Short URL') }}
            </h2>
            <a href="{{ route('url-shorten.index') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded border border-black ring-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                {{ __('Back') }}
            </a>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">

                    <form method="post" action="{{ route('url-shorten.store') }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="long_url" :value="__('Long URL')" />
                            <x-text-input id="long_url" name="long_url" type="url" class="mt-1 block w-full" :value="old('long_url')" required autofocus placeholder="https://example.com" />
                            <x-input-error class="mt-2" :messages="$errors->get('long_url')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Generate') }}</x-primary-button>

                            @if (session('short_url'))
                                <p class="mt-2 text-sm text-gray-600">
                                    {{ __('Shortened URL: ') }}
                                    <a href="{{ session('short_url') }}" class="text-blue-600 underline">{{ session('short_url') }}</a>
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
