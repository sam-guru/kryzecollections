<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-black italic tracking-tighter">KRYZE</a>
                </div>
                <a href="{{ route('admin.products.index') }}">
    Admin Products
</a>

                <!-- Shop Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex uppercase text-[11px] font-bold tracking-widest">
                    <x-nav-link href="/?category=Men" :active="request('category') == 'Men'">Men</x-nav-link>
                    <x-nav-link href="/?category=Women" :active="request('category') == 'Women'">Women</x-nav-link>
                    <x-nav-link href="/?category=Accessories" :active="request('category') == 'Accessories'">Accessories</x-nav-link>
                </div>
            </div>

            <!-- Search Bar (Middle) -->
            <div class="hidden sm:flex items-center flex-1 px-10">
                <form action="/" method="GET" class="w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." 
                        class="w-full border-gray-200 focus:border-black focus:ring-0 text-sm rounded-full px-4 py-1.5">
                </form>
            </div>

            <!-- Settings Dropdown (Right) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                 <!-- ADD THE CART ICON HERE -->
                <div class="me-4 relative">
                    <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-black transition relative p-2 inline-block">
                        <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-[10px] font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-black rounded-full">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                </div>
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')">User Dashboard</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">Settings</x-dropdown-link>
                            <x-dropdown-link href="/favorites">My Favorites</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4 text-xs font-bold uppercase tracking-widest">
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-black">Login</a>
                        <a href="{{ route('register') }}" class="text-black">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>


    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <!-- ... the rest of the profile/logout links ... -->
                </div>
            @endauth

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
