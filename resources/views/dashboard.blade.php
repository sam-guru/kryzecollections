<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-sm uppercase tracking-widest text-gray-900 leading-tight">
            {{ __('Account Overview') }}
        </h2>
    </x-slot>

    <!-- Wrap everything in x-data for Alpine.js modals -->
    <div class="py-12" x-data="{ showAddressModal: false }">
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
                        <a href="{{ url('/') }}" class="text-[10px] font-bold uppercase underline">Browse More</a>
                    </div>

                    <div class="bg-white border border-gray-100 p-6">
                        @if($favorites && $favorites->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                @foreach($favorites as $product)
                                    <div class="group relative">
                                        <div class="aspect-square overflow-hidden bg-gray-100 border border-gray-200">
                                            @if($product->main_image)
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
                    <div class="flex justify-between items-end">
                        <h4 class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Order History</h4>
                        <a href="{{ route('orders.index') }}" class="text-[10px] font-bold uppercase underline hover:text-black transition">
                            View All Orders
                        </a>
                    </div>

                    <div class="space-y-3">
                        @forelse($orders as $order)
                            <div class="bg-white border border-gray-100 p-5 group hover:border-black transition-colors duration-300">
                                <!-- Header: ID and Status -->
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="text-[11px] font-black italic tracking-tighter uppercase leading-none">
                                            {{ $order->order_number }}
                                        </p>
                                        <p class="text-[9px] text-gray-400 uppercase font-bold mt-1">
                                            {{ $order->created_at->format('d.m.y') }} — {{ $order->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-[8px] px-2 py-0.5 border border-black font-black uppercase tracking-widest mb-1 group-hover:bg-black group-hover:text-white transition-colors">
                                            {{ $order->status }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Body: Item List -->
                                <div class="space-y-2 mb-4 border-l-2 border-gray-50 pl-4">
                                    @foreach($order->items as $item)
                                        <div class="flex justify-between items-center">
                                            <p class="text-[10px] text-gray-600 uppercase tracking-tight">
                                                <span class="font-black text-black">{{ $item->quantity }}x</span> {{ $item->product_name }}
                                                <span class="text-gray-300 mx-1">/</span>
                                                <span class="text-[9px] font-bold">{{ $item->size }}</span>
                                            </p>
                                            <p class="text-[10px] font-medium text-gray-400">£{{ number_format($item->price, 2) }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Footer: Total and Shipping -->
                                <div class="pt-3 border-t border-gray-50 flex justify-between items-end">
                                    <div>
                                        <p class="text-[8px] text-gray-300 uppercase font-bold tracking-widest mb-1 text-[7px]">Shipping To</p>
                                        <p class="text-[9px] text-gray-500 uppercase truncate max-w-[150px] italic">
                                            {{ $order->shipping_address }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[12px] font-black italic tracking-tighter">£{{ number_format($order->total_price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-20 text-center border-2 border-dashed border-gray-50 rounded-xl">
                                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-300">Archive Empty</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- profile management quick links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('profile.edit') }}" class="border border-gray-900 p-4 text-center text-[10px] font-bold uppercase hover:bg-black hover:text-white transition">
                    Edit Profile
                </a>
                
                <!-- Shipping Address Button -->
                <button @click="showAddressModal = true" class="border border-gray-900 p-4 text-center text-[10px] font-bold uppercase hover:bg-black hover:text-white transition">
                    Shipping Addresses ({{ auth()->user()->shippingAddresses->count() }})
                </button>
                
                <div class="border border-gray-200 p-4 text-center text-[10px] font-bold uppercase text-gray-400">
                    Payment Methods
                </div>
            </div>

            <!-- SHIPPING ADDRESS MODAL -->
            <div x-show="showAddressModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak>
                <div @click.away="showAddressModal = false" class="bg-white p-8 max-w-2xl w-full shadow-2xl overflow-y-auto max-h-[80vh]">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-black text-xl uppercase italic tracking-tighter">My Addresses</h3>
                        <button @click="showAddressModal = false" class="text-2xl">&times;</button>
                    </div>

                    <!-- List Current Addresses -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        @foreach(auth()->user()->shippingAddresses as $address)
                            <div class="border p-4 relative group hover:border-black transition">
                                <p class="text-[9px] font-black uppercase tracking-widest {{ $address->is_default ? 'text-black' : 'text-gray-300' }}">
                                    {{ $address->is_default ? 'Default' : 'Secondary' }}
                                </p>
                                <p class="text-xs font-bold uppercase mt-2">{{ $address->address_line_1 }}</p>
                                <p class="text-[10px] text-gray-500 uppercase">{{ $address->city }}, {{ $address->postcode }}</p>
                                
                                <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="mt-4">
                                    @csrf @method('DELETE')
                                    <button class="text-[9px] font-bold text-red-500 uppercase hover:underline">Remove</button>
                                </form>
                            </div>
                        @endforeach
                    </div>

                    <!-- Simple Add Form -->
                    <div class="border-t pt-6">
                        <h4 class="text-[10px] font-black uppercase tracking-widest mb-4">+ Add New</h4>
                        <form action="{{ route('addresses.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="text" name="address_line_1" placeholder="Address Line 1" required class="w-full border-gray-200 text-[11px] uppercase focus:ring-black focus:border-black">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" name="city" placeholder="City" required class="w-full border-gray-200 text-[11px] uppercase focus:ring-black focus:border-black">
                                <input type="text" name="postcode" placeholder="Postcode" required class="w-full border-gray-200 text-[11px] uppercase focus:ring-black focus:border-black">
                            </div>
                            <button class="w-full bg-black text-white py-3 text-[10px] font-bold uppercase tracking-widest">Save Address</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>