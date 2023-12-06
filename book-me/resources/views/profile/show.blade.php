<x-app-layout>

    <div class="flex flex-col items-center">
        <img src="{{ $user->getImageBgURL() }}" class="w-full rounded border-b-2 relative h-80 object-cover shadow"/>
        <img src="{{ $user->getImageProfileURL() }}" class="rounded-full border-4 object-cover shadow absolute h-48 w-48 top-48 ">
        <p class="mt-[4.5rem] font-bold text-4xl">{{$user->name}}</p>


        <div class ="mt-3">
            {{ $user->bio}}
        </div>
        @if ($user->is(auth()->user()))
            <a type="submit" class="flex flex-row gap-1 mt-3 cursor-pointer" href={{ route('profile.edit')}} >
                <p class="align-bottom text-sm">Edit</p>
                <svg class="h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        @else
            @if(auth()->user()->follows($user))
            <form method="POST" action="{{ route('users.unfollow', $user->id)}}">
                @csrf
                <button type="submit" class="mt-5 bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded">
                    Unfollow
                </button>
            </form>
            @else
                <form method="POST" action="{{ route('users.follow', $user->id)}}">
                    @csrf
                    <button type="submit" class="mt-5 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                        Follow
                    </button>
                </form>
            @endif
        @endif
    </div>

    <div class="container mx-auto sm:px-6 lg:px-8">
        @include('components.post-alert')

        @if(($user == auth()->user()) || $user->friends->contains(auth()->user()))
            @if($user == auth()->user())
                <p class="text-2xl font-semibold mt-5">Post something on your feed</p>
            @elseif($user->friends->contains(auth()->user()))
                <p class="text-2xl font-semibold mt-5">Post something on {{$user->name}} feed</p>
            @endif
                <div class="mx-auto my-3">
                    <form method="POST" action="{{ route('posts.store', $user) }}">
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
        @endif
        @if($user == auth()->user())
            <p class="text-2xl font-semibold mt-3">Your Feed</p>
        @else
            <p class="text-2xl font-semibold mt-3">{{$user->name}} Feed</p>
        @endif

        @include('posts.post-list')
    </div>


</x-app-layout>
