<x-app-layout>
    <!-- Page Header (Small Title and Sort) -->
    <x-slot name="header">
        <div class="flex justify-between items-end">
            <div>
                <nav class="text-[10px] uppercase text-gray-400 font-bold mb-1">Home / Shop</nav>
                <h2 class="font-black text-3xl text-gray-900 leading-tight uppercase italic tracking-tighter">
                    {{ request('category') ?? 'New In' }}
                </h2>
            </div>
            
            <form method="GET" action="/" class="flex items-center gap-4">
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                <select name="sort" onchange="this.form.submit()" class="border-none bg-transparent text-[11px] font-bold uppercase tracking-widest focus:ring-0 cursor-pointer">
                    <option value="">Sort By</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High-Low</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low-High</option>
                </select>
            </form>
        </div>
    </x-slot>

    <!-- Main Content Area -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-16">
                
                <!-- Sidebar Filters -->
                <aside class="w-full md:w-48 space-y-12">
                    <x-filter-sidebar />
                </aside>

                <!-- Product Grid -->
                <div class="flex-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-12 gap-x-8">
                        @forelse($products as $product)
                            <x-product-card :product="$product" />
                        @empty
                            <div class="col-span-full text-center py-32">
                                <p class="text-gray-400 font-medium italic">No outfits found matching your selection.</p>
                                <a href="/" class="mt-4 inline-block px-6 py-2 bg-black text-white text-[10px] font-bold uppercase tracking-widest">Clear All</a>
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
