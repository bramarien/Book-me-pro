<div data-comments-id="{{$post->id}}" class="mx-1 bg-gray-300 overflow-hidden shadow-sm rounded-b-lg hidden comments">
    <form class="flex flex-col pb-2" method="POST" action="{{ route('posts.comments.store', $post) }}">
        @csrf
        <div class="flex flex-row gap-3 h-12 w-full mx-auto mt-3 justify-center">
            <textarea
            name="content"
            placeholder="{{ __('Comment anything...') }}"
            class=" w-[80%] resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('content') }}</textarea>
            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700  focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'">{{ __('Comment') }}</button>
        </div>
            @error('content', 'comment'.$post->id)
                <span class="w-[90%] mx-auto text-sm text-red-600 dark:text-red-400 space-y-1"> {{ $message }} </span>
            @enderror
    </form>

    @if($post->comments->count() > 0)
        <hr class="h-[2px] my-1 bg-black"/>
    @endif

    @foreach($post->comments as $comment)

    <div class="flex mx-5 my-2 pb-2   whitespace-normal">
        <div class="flex-1 min-w-0 mx-6">
            <div class="flex items-center">
                <a type="button" href={{ route('profile.show', $comment->user) }} class="flex items-center cursor-pointer">
                    <img class="rounded-full border-2 shadow h-8 w-8 object-cover" src="{{ $comment->user->getImageProfileURL() }}"/>
                    <p class="px-1 text-base font-medium" >{{$comment->user->name}}</p>
                </a>
            </div>
            @if(($editComment ?? false) && ($idComment ?? 0) == $comment->id)
                <form method="POST" action="{{route('comments.update', $comment)}}">
                    @csrf
                    @method('patch')
                    <div class="flex flex-row gap-3 h-12 w-full mx-auto mt-3 justify-center">
                        <textarea
                            name="content"
                            class="block w-[95%] mx-auto resize-none  border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >{{ old('content', $comment->content) }}</textarea>
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <a class="self-center" href="{{ route('posts.show', $post) }}">{{ __('Cancel') }}</a>
                    </div>
                    @error('content', 'comment'.$comment->id)
                        <span class="w-[90%] mx-auto text-sm text-red-600 dark:text-red-400 space-y-1"> {{ $message }} </span>
                    @enderror
                </form>
            @else
                <span class="min-w-0 break-words font-thin">
                    {{$comment->content}}
                </span>
            @endif
        </div>
        <div class="flex flex-col items-center my-auto">
            <p class="ml-auto text-sm self-center">{{$comment->created_at->format('j M Y, g:i a')}}</p>
            @unless ($comment->created_at->eq($comment->updated_at))
                <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
            @endunless
        </div>
        @if($comment->user->is(auth()->user()))
            <a type="button" class="ml-2 px-2 self-center" href="{{ route('comments.edit', $comment) }}">
                <svg class="h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        @endif
        @if($comment->user->is(auth()->user()) || $post->user->is(auth()->user()))
            <form class="flex pr-3 cursor-pointer" method="POST" action="{{ route('comments.destroy', $comment) }}">
                @csrf
                @method('delete')
                <a class="self-center" onclick="this.closest('form').submit();">
                    <svg fill="#000000" class="h-4" viewBox="0 0 24 24" id="cross" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color">
                        <line id="primary" x1="19" y1="19" x2="5" y2="5" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                        <line id="primary-2" data-name="primary" x1="19" y1="5" x2="5" y2="19" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                    </svg>
                </a>
            </form>
        @endif
    </div>
    @endforeach
</div>
