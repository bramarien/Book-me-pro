<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Feed') }}
        </h2>
    </x-slot> --}}

    <div class="container mx-auto sm:px-6 lg:px-8 pt-6">

        <p class="text-2xl font-semibold mt-3">Post something New</p>

        @include('components.post-alert')

        <div class="mx-auto my-3">
            <form method="POST" action="{{ route('posts.store', auth()->user()) }}">
                @csrf
                <div class="flex flex-col">
                    <textarea
                    name="content"
                    placeholder="{{ __('What\'s on your mind?') }}"
                    class="block w-full resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >{{ old('content') }}</textarea>
                    @error('content')
                    <span class="text-sm text-red-600 dark:text-red-400 space-y-1"> {{ $message }} </span>
                    @enderror
                </div>
                <x-primary-button class="mt-4">{{ __('Post') }}</x-primary-button>
            </form>
        </div>
        <p class="text-2xl font-semibold mt-10">Feed</p>
        @include('posts.post-list')

    </div>
</x-app-layout>
