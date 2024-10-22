<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('URL List') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-100">
        <div class="container mx-auto p-4">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('url-shorten.create') }}"
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded border border-black ring-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                        {{ __('Create Short URL') }}
                    </a>
                </div>

                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Long URL') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Short URL') }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Click Count') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($urls as $url)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ $url->long_url }}" target="_blank" class="text-blue-600 underline">
                                    {{ $url->long_url }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">

                                <a href="{{ route('s', $url->short_url) }}" target="_blank" class="text-blue-600 underline mr-4">
                                    {{ route('s', $url->short_url) }}
                                </a>
                                &nbsp;
                                &nbsp;
                                <button onclick="copyToClipboard('{{ route('s', $url->short_url) }}')"
                                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded border border-black text-sm ring-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out">
                                    {{ __('Copy') }}
                                </button>

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                {{ $url->click_count }}
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Display pagination links -->
                <div class="mt-4">
                    {{ $urls->links() }}
                </div>

                <!-- If no URLs found, display a message -->
                @if ($urls->isEmpty())
                    <p class="text-gray-600 text-center mt-4">{{ __('No URLs found.') }}</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            // Create a temporary input element to hold the URL
            const tempInput = document.createElement("input");
            tempInput.style.position = "absolute";
            tempInput.style.left = "-9999px";
            tempInput.value = text;

            // Add the input element to the body and select its content
            document.body.appendChild(tempInput);
            tempInput.select();

            // Copy the content to the clipboard
            document.execCommand("copy");

            // Remove the temporary input element from the DOM
            document.body.removeChild(tempInput);

            // Notify the user
            alert("URL copied to clipboard!");
        }
    </script>
</x-app-layout>
