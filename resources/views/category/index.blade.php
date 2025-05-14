<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Todo Category') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tombol Create tetap kiri --}}
            <div class="flex justify-start mb-4">
                <a href="{{ route('category.create') }}">
                    <x-primary-button>
                        {{ __('Create Category') }}
                    </x-primary-button>
                </a>
            </div>

            {{-- Tabel --}}
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-1/2 text-center">Title</th>
                            <th scope="col" class="px-6 py-3 w-1/2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr class="border-b dark:border-gray-700 border-gray-200 h-16">
                                <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200 text-center">
                                    {{ $category->title }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-4">
                                        <a href="{{ route('category.edit', $category) }}" class="text-blue-600 hover:underline">
                                            Edit
                                        </a>
                                        <form action="{{ route('category.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>