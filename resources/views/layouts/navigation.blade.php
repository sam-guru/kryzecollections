<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-black italic tracking-tighter">KRYZE</a>
                </div>

                <!-- Shop Links (Desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex uppercase text-[11px] font-bold tracking-widest">
                    <x-nav-link href="/?category=Men" :active="request('category') == 'Men'">Men</x-nav-link>
                    <x-nav-link href="/?category=Women" :active="request('category') == 'Women'">Women</x-nav-link>
                    <x-nav-link href="/?category=Accessories" :active="request('category') == 'Accessories'">Accessories</x-nav-link>
                </div>
            </div>

            <!-- Search Bar (Middle - Desktop) -->
            <div class="hidden sm:flex items-center flex-1 px-10">
                <form action="/" method="GET" class="w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." 
                        class="w-full border-gray-200 focus:border-black focus:ring-0 text-sm rounded-full px-4 py-1.5">
                </form>
            </div>

            <!-- right side icons (cart + hamburger) -->
            <div class="flex items-center">
                <!-- cart icon (always visible) -->
                <div class="me-2 relative">
                    <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-black transition relative p-2 inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-[10px] font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-black rounded-full">
                                {{-- This sums up the 'quantity' value of every item in the cart --}}
                                {{ collect(session('cart'))->sum('quantity') }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- desktop auth links -->
                <div class="hidden sm:flex sm:items-center">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 transition">
                                    {{ Auth::user()->name }}
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('dashboard')">User Dashboard</x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')">Settings</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <div class="space-x-4 text-xs font-bold uppercase tracking-widest ms-4">
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-black">Login</a>
                            <a href="{{ route('register') }}" class="text-black">Register</a>
                        </div>
                    @endauth
                </div>

                <!-- Hamburger Button (Mobile Only) -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <!-- Mobile Search -->
        <div class="pt-4 pb-2 px-4">
            <form action="/" method="GET" class="w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." 
                    class="w-full border-gray-200 focus:border-black focus:ring-0 text-sm rounded-full px-4 py-2">
            </form>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="/?category=Men" :active="request('category') == 'Men'">Men</x-responsive-nav-link>
            <x-responsive-nav-link href="/?category=Women" :active="request('category') == 'Women'">Women</x-responsive-nav-link>
            <x-responsive-nav-link href="/?category=Accessories" :active="request('category') == 'Accessories'">Accessories</x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4 mb-3">
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('dashboard')">Dashboard</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')">Settings</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="py-3 px-4 space-y-3">
                    <a href="{{ route('login') }}" class="block text-sm font-bold uppercase tracking-widest text-gray-500">Login</a>
                    <a href="{{ route('register') }}" class="block text-sm font-bold uppercase tracking-widest text-black">Register</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
