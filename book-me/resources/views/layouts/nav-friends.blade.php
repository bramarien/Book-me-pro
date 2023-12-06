<nav x-data="{ open: false }" class="bg-[#5576be] border-b border-[#122541] flex  h-20 top-0 justify-start items-center z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="flex justify-between w-full">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('friends.index')" :active="request()->routeIs('friends.index')">
                        {{ __('Follow') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('friends.friends')" :active="request()->routeIs('friends.friends')">
                        {{ __('Friends') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('friends.followings')" :active="request()->routeIs('friends.followings')">
                        {{ __('Followings') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('friends.followers')" :active="request()->routeIs('friends.followers')">
                        {{ __('Followers') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
