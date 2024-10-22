<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 for Total Clicks -->
                <div class="bg-blue-500 text-black shadow-md rounded-lg p-6">
                    <h2 class="text-2xl font-semibold">Total Clicks</h2>
                    <p class="text-4xl mt-4">{{$totalClick}}</p>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>
