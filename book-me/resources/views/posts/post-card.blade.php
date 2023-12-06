<div class="py-6 post-container">

    <div class="bg-white dark:bg-gray-800 mx-auto overflow-hidden shadow-sm sm:rounded-lg ">
        <div class="flex p-4 items-center">
            <a type="button" href={{ route('profile.show', $post->user) }} class="flex items-center cursor-pointer">
                <img class="rounded-full border-2 shadow h-16 w-16 object-cover" src="{{ $post->user->getImageProfileURL() }}"/>
                <p class="px-2 text-lg font-medium">{{$post->user->name}}</p>
            </a>
            @if($post->recipient_id != $post->user_id)
                <a type="button" href={{ route('profile.show', $post->recipient_id) }} class="flex items-center cursor-pointer">
                    <span class="text-xs text-gray-600">posted on {{$post->recipient->name}} feed</span>
                </a>
            @endif
            @if ($post->user->is(auth()->user()) || $post->user->is(auth()->user()))
                <a type="button" class="ml-auto px-3" href={{route('posts.edit', $post)}}>
                    <svg class="h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                @if($editing ?? false)
                @else
                    <form class="flex pr-3 cursor-pointer" method="POST" action="{{ route('posts.destroy', $post) }}">
                        @csrf
                        @method('delete')
                        <a onclick="this.closest('form').submit();">
                            <svg fill="#000000" class="h-6" viewBox="0 0 24 24" id="cross" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color">
                                <line id="primary" x1="19" y1="19" x2="5" y2="5" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                                <line id="primary-2" data-name="primary" x1="19" y1="5" x2="5" y2="19" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                            </svg>
                        </a>
                    </form>
                @endif
            @endif
        </div>
        @if($editing ?? false)
            <form method="POST" action="{{route('posts.update', $post)}}">
                @csrf
                @method('patch')
                <textarea
                    name="content"
                    class="block w-[95%] mx-auto resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >{{ old('content', $post->content) }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                <div class="ml-7 mt-4 space-x-2">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                    <a href="{{ route('posts.show', $post) }}">{{ __('Cancel') }}</a>
                </div>
            </form>
        @else
            <div class="p-6 font-normal text-lg text-gray-900 dark:text-gray-100">
                {{ $post->content }}
            </div>
        @endif
        <div class="flex items-center gap-1 my-3 mx-6">
            @if(auth()->user()->likesPost($post))
                <form method="POST" action="{{ route('posts.unlike', $post)}}">
                    @csrf
                    <button class="flex gap-1 cursor-pointer" type="submit">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.39062 18.4907V8.33071C8.39062 7.93071 8.51062 7.54071 8.73062 7.21071L11.4606 3.15071C11.8906 2.50071 12.9606 2.04071 13.8706 2.38071C14.8506 2.71071 15.5006 3.81071 15.2906 4.79071L14.7706 8.06071C14.7306 8.36071 14.8106 8.63071 14.9806 8.84071C15.1506 9.03071 15.4006 9.15071 15.6706 9.15071H19.7806C20.5706 9.15071 21.2506 9.47071 21.6506 10.0307C22.0306 10.5707 22.1006 11.2707 21.8506 11.9807L19.3906 19.4707C19.0806 20.7107 17.7306 21.7207 16.3906 21.7207H12.4906C11.8206 21.7207 10.8806 21.4907 10.4506 21.0607L9.17062 20.0707C8.68062 19.7007 8.39062 19.1107 8.39062 18.4907Z" fill="#292D32"/>
                            <path d="M5.21 6.37891H4.18C2.63 6.37891 2 6.97891 2 8.45891V18.5189C2 19.9989 2.63 20.5989 4.18 20.5989H5.21C6.76 20.5989 7.39 19.9989 7.39 18.5189V8.45891C7.39 6.97891 6.76 6.37891 5.21 6.37891Z" fill="#292D32"/>
                        </svg>
                        <span>{{ $post->likes->count() }}<span>
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('posts.like', $post)}}">
                    @csrf
                    <button class="flex gap-1 cursor-pointer" type="submit">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.47998 18.35L10.58 20.75C10.98 21.15 11.88 21.35 12.48 21.35H16.28C17.48 21.35 18.78 20.45 19.08 19.25L21.48 11.95C21.98 10.55 21.08 9.34997 19.58 9.34997H15.58C14.98 9.34997 14.48 8.84997 14.58 8.14997L15.08 4.94997C15.28 4.04997 14.68 3.04997 13.78 2.74997C12.98 2.44997 11.98 2.84997 11.58 3.44997L7.47998 9.54997" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10"/>
                            <path d="M2.38 18.35V8.55002C2.38 7.15002 2.98 6.65002 4.38 6.65002H5.38C6.78 6.65002 7.38 7.15002 7.38 8.55002V18.35C7.38 19.75 6.78 20.25 5.38 20.25H4.38C2.98 20.25 2.38 19.75 2.38 18.35Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ $post->likes->count() }}<span>
                    </button>
                </form>
            @endif
            <button data-post-id="{{$post->id}}" type="button" class="flex gap-1 mx-14 toggle-comments-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                </svg>
                <span class="">{{$post->comments->count()}}</span>
            </button>
            <p class="ml-auto">{{$post->created_at->format('j M Y, g:i a')}}</p>
            @unless ($post->created_at->eq($post->updated_at))
            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
            @endunless
        </div>
    </div>

    @include('posts.post-comment')

</div>
