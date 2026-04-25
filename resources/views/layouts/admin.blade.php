<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin - KRYZE</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-gray-100 text-gray-900">

        <div class="min-h-screen flex">

            <!-- Sidebar -->
            <aside class="w-64 bg-black text-white hidden md:flex md:flex-col">

                <div class="h-20 flex items-center px-6 border-b border-white/10">
                    <a href="{{ route('admin.dashboard') }}" class="text-2xl font-black italic tracking-tighter">
                        KRYZE ADMIN
                    </a>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2">

                    <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-3 rounded-lg text-sm font-bold uppercase tracking-widest
                    {{ request()->routeIs('admin.dashboard') ? 'bg-white text-black' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                    class="block px-4 py-3 rounded-lg text-sm font-bold uppercase tracking-widest
                    {{ request()->routeIs('admin.products.*') ? 'bg-white text-black' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                        Products
                    </a>

                    <a href="{{ route('home') }}"
                    class="block px-4 py-3 rounded-lg text-sm font-bold uppercase tracking-widest text-gray-300 hover:bg-white/10 hover:text-white">
                        View Store
                    </a>

                </nav>

                <div class="p-4 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button class="w-full text-left px-4 py-3 rounded-lg text-sm font-bold uppercase tracking-widest text-red-300 hover:bg-red-500 hover:text-white">
                            Logout
                        </button>
                    </form>
                </div>

            </aside>

            <!-- Main -->
            <main class="flex-1">

                <!-- Top bar -->
                <header class="h-20 bg-white border-b flex items-center justify-between px-6">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-gray-400 font-bold">
                            Admin Panel
                        </p>
                        <h1 class="text-lg font-black">
                            {{ $title ?? 'Dashboard' }}
                        </h1>
                    </div>

                    <div class="text-sm font-bold">
                        {{ Auth::user()->name }}
                    </div>
                </header>

                <section class="p-6">
                    {{ $slot }}
                </section>

            </main>

        </div>

    </body>
</html>