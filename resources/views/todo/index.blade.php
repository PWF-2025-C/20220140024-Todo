<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between px-6 py-4">
                <x-create-button href="{{ route('todo.create') }}" />
                @if (session('success'))
                    <div class="px-4 py-2 bg-green-100 text-green-800 text-sm rounded-lg dark:bg-green-900 dark:text-green-300">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Title</th>
                                <th scope="col" class="px-6 py-3">Category</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($todos as $todo)
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                    <td class="px-6 py-4 font-medium">
                                        <a href="{{ route('todo.edit', $todo) }}"
                                           class="text-gray-600 dark:text-gray-300 hover:underline text-sm">
                                            {{ $todo->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $todo->category_id ? $todo->category->title : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if (!$todo->is_done)
                                            <span class="text-red-600">Ongoing</span>
                                        @else
                                            <span class="text-green-600">Completed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex space-x-8">
                                        <a href="{{ route('todo.edit', $todo) }}"
                                           class="text-blue-600 hover:underline text-sm">Edit</a>

                                        @if (!$todo->is_done)
                                            <form action="{{ route('todo.complete', $todo) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-green-600 dark:text-green-400 text-sm">
                                                    Complete
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('todo.uncomplete', $todo) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-blue-600 dark:text-blue-400 text-sm">
                                                    Uncomplete
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('todo.destroy', $todo) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No data available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($todosCompleted > 0)
                <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
                    <form action="{{ route('todo.deleteallcompleted') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <x-primary-button>
                            Delete All Completed Tasks
                        </x-primary-button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>