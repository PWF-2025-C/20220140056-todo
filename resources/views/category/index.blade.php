<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Create Button + Flash Message --}}
            <div class="flex justify-between items-center">
                <x-create-button href="{{ route('category.create') }}" />
                @if (session('success'))
                    <div class="text-green-600 dark:text-green-400 text-sm font-semibold px-4 py-2">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            {{-- Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-gray-500 dark:text-gray-400">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-center">Title</th>
                                <th class="px-6 py-3 text-center">Todo</th>
                                <th class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white group">
                                        <a href="{{ route('category.edit', $category) }}"
                                            class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                            {{ $category->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $category->todos->count() }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-3">
                                            {{-- Edit Category --}}
                                            <a href="{{ route('category.edit', $category) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:underline">
                                                Edit
                                            </a>
                                            {{-- Delete Category --}}
                                            <form action="{{ route('category.destroy', $category) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 dark:text-red-400 hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No categories found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>