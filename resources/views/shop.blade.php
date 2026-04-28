<x-app-layout>
    <!-- Header -->
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

            <!-- Sort -->
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

    <!-- Content -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row gap-16">

                <!-- Sidebar -->
                <aside class="w-full md:w-48 space-y-12">
                    <x-filter-sidebar />
                </aside>

                <!-- Products -->
                <div class="flex-1">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-12 gap-x-8">

                        @forelse($products as $product)

                            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden group shadow-sm hover:shadow-md transition">

                                <!-- IMAGE (clickable) -->
                                <a href="{{ route('products.show', $product) }}">
                                    <div class="aspect-[3/4] overflow-hidden">
                                        <img 
                                            src="{{ asset($product->main_image) }}" 
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                        >

                                    </div>
                                </a>

                                <!-- INFO -->
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

                                    <!-- 🔥 ACTIONS -->
                                    <div class="flex gap-2">
                                        

                                        <!-- VIEW -->
                                        <a href="{{ route('products.show', $product) }}"
                                        class="flex-1 text-center border py-2 text-[10px] font-bold uppercase hover:bg-gray-50">
                                            View
                                        </a>

                                        <!-- ADD TO CART -->
                                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                class="w-full bg-black text-white py-2 text-[10px] font-bold uppercase">
                                                Add
                                            </button>
                                        </form>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <!-- Empty State -->
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

                    <!-- Pagination -->
                    <div class="mt-20">
                        {{ $products->links() }}
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>