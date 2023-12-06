<aside class="flex fixed w-[20%] h-[calc(100%-5rem)] overflow-y-scroll">
    <div class="py-8 bg-[#5576be] border-r border-[#122541] w-full">
        <h2 class="px-5 text-lg font-medium text-slate-200 text-shadow shadow-slate-600 dark:text-white">Friends</h2>

        <div class="mt-8 space-y-4">
            @foreach ($friends as $friend)
                <a href="{{ route('profile.show', $friend)}}" class="flex items-center w-full px-5 py-2 transition-colors duration-200 gap-x-2 hover:bg-[#203f61] focus:outline-none">
                    <img class=" border-[1px] border-black object-cover w-8 h-8 rounded-full" src="{{ $friend->getImageProfileURL() }}" alt="">

                    <div class="text-left rtl:text-right">
                        <h1 class="text-sm font-medium text-slate-200 text-shadow shadow-slate-600 capitalize dark:text-white">{{$friend->name}}</h1>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</aside>
