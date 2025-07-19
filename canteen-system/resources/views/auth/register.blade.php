<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium mb-4">Create an account</h3>
                    <p class="text-gray-600">
                        This is a demo. Authentication will be implemented with Fortify/Jetstream.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('menu') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">
                            Back to Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>