<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Kryze | {{ $title ?? 'Premium Outfits' }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('k-logo.svg') }}">
        <script src="https://cdn.tailwindcss.com"></script>
    

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-[#f8f8f8] text-gray-900 font-sans">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <footer class="bg-black text-white mt-20">
            <div class="max-w-7xl mx-auto px-6 py-12">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                    <!-- BRAND -->
                    <div>
                        <h2 class="text-2xl font-black italic tracking-tighter mb-4">
                            KRYZE
                        </h2>
                        <p class="text-gray-400 text-sm">
                            Modern fashion storefront. Clean design. Premium feel.
                        </p>
                    </div>

                    <!-- LINKS -->
                    <div>
                        <h4 class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-4">
                            Shop
                        </h4>

                        <div class="space-y-2 text-sm">
                            <a href="/?category=Men" class="block hover:text-gray-300">Men</a>
                            <a href="/?category=Women" class="block hover:text-gray-300">Women</a>
                            <a href="/?category=Accessories" class="block hover:text-gray-300">Accessories</a>
                            <a href="{{ route('cart.index') }}" class="block hover:text-gray-300">Cart</a>
                        </div>
                    </div>

                    <!-- ADMIN -->
                    <div>
                        <h4 class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-4">
                            Admin
                        </h4>

                        <div class="space-y-2 text-sm">

                            @auth
                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="block hover:text-gray-300">
                                        Admin Dashboard
                                    </a>

                                    <a href="{{ route('admin.products.index') }}" class="block hover:text-gray-300">
                                        Manage Products
                                    </a>
                                @endif
                            @else
                                @if(Route::has('login'))
                                    <a href="{{ route('login') }}" class="block hover:text-gray-300">
                                        Admin Login
                                    </a>
                                @endif
                            @endauth

                        </div>
                    </div>

                </div>

                <!-- BOTTOM -->
                <div class="border-t border-white/10 mt-10 pt-6 text-center text-xs text-gray-500">
                    © {{ date('Y') }} KRYZE. All rights reserved.
                </div>

            </div>
        </footer>
    </body>
</html>
