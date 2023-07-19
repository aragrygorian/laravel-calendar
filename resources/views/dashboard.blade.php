<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden  sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('storage/images/user-png-icon-16.jpg') }}" width="100" height="100" class="rounded">
                        </div>
                        <div class="d-flex">
                            <p>Total User</p>
                            <p>23</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
