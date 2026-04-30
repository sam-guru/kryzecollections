<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-sm uppercase tracking-widest text-gray-900 leading-tight">
            {{ __('Account Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- welcome header -->
            <div class="border-b border-gray-200 pb-5">
                <h3 class="text-2xl font-light text-gray-900">Hello, {{ auth()->user()->name }}</h3>
                <p class="text-sm text-gray-500">Manage your favorites and track your recent orders.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- left column: favorites -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex justify-between items-end">
                        <h4 class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Your Favorites</h4>
                        {{-- Changed this to '/' to ensure it goes to your shop --}}
                        <a href="{{ url('/') }}" class="text-[10px] font-bold uppercase underline">Browse More</a>
                    </div>

                    <div class="bg-white border border-gray-100 p-6">
                        @if($favorites && $favorites->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                @foreach($favorites as $product)
                                    <div class="group relative">
                                        <div class="aspect-square overflow-hidden bg-gray-100 border border-gray-200">
                                            @if($product->main_image)
                                                {{-- Link to the product details page --}}
                                                <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                                    <img src="{{ asset($product->main_image) }}" 
                                                        alt="{{ $product->name }}"
                                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                                </a>
                                            @else
                                                <div class="flex items-center justify-center h-full text-[10px] text-gray-400">
                                                    No Image
                                                </div>
                                            @endif
                                        </div>
                                        
                                        {{-- Also wrap the name in a link for better UX --}}
                                        <a href="{{ route('products.show', $product->slug ?? $product->id) }}">
                                            <h5 class="mt-2 text-[11px] font-medium truncate hover:underline uppercase">{{ $product->name }}</h5>
                                        </a>
                                        <p class="text-[10px] text-gray-500">£{{ number_format($product->price, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-10 text-center border-2 border-dashed border-gray-100 text-gray-400 text-xs">
                                No items saved yet.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- right column: purchase history -->
                <div class="space-y-4">
                    <h4 class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Recent Orders</h4>
                    <div class="bg-white border border-gray-100 divide-y divide-gray-100">
                        @forelse($orders as $order)
                            <div class="p-4 flex justify-between items-center">
                                <div>
                                    <p class="text-[11px] font-bold">ORDER #{{ $order->id }}</p>
                                    <p class="text-[10px] text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                                <span class="text-[10px] font-bold uppercase text-green-600">Delivered</span>
                            </div>
                        @empty
                            <div class="p-10 text-center text-gray-400 text-xs italic">
                                No purchases made yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- profile management quick links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- FIXED: Changed </button> to </a> --}}
                <a href="{{ route('profile.edit') }}" class="border border-gray-900 p-4 text-center text-[10px] font-bold uppercase hover:bg-black hover:text-white transition">
                    Edit Profile
                </a>
                
                <div class="border border-gray-200 p-4 text-center text-[10px] font-bold uppercase text-gray-400">
                    Shipping Address
                </div>
                
                <div class="border border-gray-200 p-4 text-center text-[10px] font-bold uppercase text-gray-400">
                    Payment Methods
                </div>
            </div>

        </div>
    </div>
</x-app-layout>