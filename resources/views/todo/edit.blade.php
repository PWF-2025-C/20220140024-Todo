<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ isset($todo) ? __('Edit Todo') : __('Create Todo') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form method="POST" 
                      action="{{ isset($todo) ? route('todo.update', $todo) : route('todo.store') }}">
                    @csrf
                    @if (isset($todo))
                        @method('PATCH')
                    @endif

                    <div class="mb-6">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input 
                            id="title" 
                            name="title" 
                            type="text" 
                            class="mt-1 block w-full" 
                            required 
                            autofocus 
                            autocomplete="title"
                            :value="old('title', $todo->title ?? '')"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select id="category_id" name="category_id" class="mt-1 block w-full">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ (old('category_id', $todo->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>
                            {{ isset($todo) ? __('Update') : __('Save') }}
                        </x-primary-button>
                        <x-cancel-button href="{{ route('todo.index') }}" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
