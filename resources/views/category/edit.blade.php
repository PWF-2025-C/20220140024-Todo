<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form method="POST" action="{{ route('todo.update', $todo) }}">
                    @csrf
                    @method('PATCH')

                    {{-- Title --}}
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input 
                            id="title" 
                            name="title" 
                            type="text" 
                            class="mt-1 block w-full"
                            value="{{ old('title', $todo->title) }}" 
                            required 
                            autofocus 
                        />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    {{-- Category Dropdown --}}
                    <div class="mb-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id" class="block w-full mt-1 rounded-md">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ $todo->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                        <x-cancel-button href="{{ route('todo.index') }}" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
