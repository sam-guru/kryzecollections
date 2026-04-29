<x-app-layout>
    <!-- header -->
    <x-slot name="header">
        <div class="flex justify-between items-end">
            <div>
                <nav class="text-[10px] uppercase text-gray-400 font-bold mb-1">
                    Home / Shop
                </nav>

                <h2 class="font-black text-3xl text-gray-900 uppercase italic tracking-tighter">
                    {{ request('category') ?? 'New In' }}
                </h2>
            </div>

            <!-- sort -->
            <form method="GET" action="/" class="flex items-center gap-4">
                @foreach(request()->except('sort') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <select name="sort" onchange="this.form.submit()"
                    class="border-none bg-transparent text-[11px] font-bold uppercase tracking-widest focus:ring-0 cursor-pointer">
                    <option value="">Sort By</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                        Price: High-Low
                    </option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                        Price: Low-High
                    </option>
                </select>
            </form>
        </div>
    </x-slot>

    <!-- content -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- success message! -->
            @if(session()->has('success'))
                <div id="flash-message" class="mb-6 p-4 bg-black text-white text-[10px] font-bold uppercase tracking-widest flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-white/50 hover:text-white">
                        Dismiss
                    </button>
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-16">

                <!-- sidebar -->
                <aside class="w-full md:w-48 space-y-12">
                    <x-filter-sidebar />
                </aside>

                <!-- products -->
                <div class="flex-1">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-12 gap-x-8">

                        @forelse($products as $product)

                            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden group shadow-sm hover:shadow-md transition">

                                <!-- image (clickable) -->
                                <a href="{{ route('products.show', $product) }}">
                                    <div class="aspect-[3/4] overflow-hidden">
                                        <img 
                                            src="{{ asset($product->main_image) }}" 
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                        >

                                    </div>
                                </a>

                                <!-- info -->
                                <div class="p-4">

                                    <div class="flex justify-between items-start mb-1">
                                        <h3 class="text-sm font-bold text-gray-900 truncate">
                                            {{ $product->name }}
                                        </h3>

                                        <p class="text-sm font-black">
                                            £{{ number_format($product->price, 2) }}
                                        </p>
                                    </div>

                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-4">
                                        {{ $product->brand }}
                                    </p>

                                    
                                    <!-- actions -->
                                    <div class="flex gap-2">
                                        
                                        <!-- favorite togle -->
                                        <form action="{{ route('favorite.toggle', $product) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                class="w-full border py-2 flex items-center justify-center hover:bg-gray-50 transition group">
                                                
                                                @php
                                                    $isFavorited = $product->isFavoritedBy(auth()->user());
                                                @endphp

                                                @if($isFavorited)
                                                    <!-- solid red heart (favorited) -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-red-600">
                                                        <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001Z" />
                                                    </svg>
                                                @else
                                                    <!-- outline heart (unfavorited) -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400 group-hover:text-red-400 transition">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>

                                        <!-- add to cart -->
                                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                class="w-full bg-black text-white py-2 text-[10px] font-bold uppercase hover:bg-gray-900 transition">
                                                Add to cart
                                            </button>
                                        </form>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <!-- if products empty -->
                            <div class="col-span-full text-center py-32">
                                <p class="text-gray-400 font-medium italic">
                                    No products found matching your selection.
                                </p>

                                <a href="/" class="mt-6 inline-block px-6 py-2 bg-black text-white text-[10px] font-bold uppercase tracking-widest">
                                    Clear All Filters
                                </a>
                            </div>

                        @endforelse

                    </div>

                    <!-- pagination -->
                    <div class="mt-20">
                        {{ $products->links() }}
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const message = document.getElementById('flash-message');
            
            if (message) {
                // wait 2 seconds, then start fading out
                setTimeout(() => {
                    message.style.opacity = '0';
                    
                    // after the 500ms fade transition finishes, remove it from the DOM
                    setTimeout(() => {
                        message.remove();
                    }, 500);
                }, 2000); // Change 3000 to 5000 if you want it to stay for 5 seconds
            }
        });
    </script>
</x-app-layout>