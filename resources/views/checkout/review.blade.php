<x-app-layout>
    <div class="py-16 max-w-4xl mx-auto px-4">
        <h2 class="font-black text-3xl uppercase italic tracking-tighter mb-12 text-center">Review Your Order</h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Side: Items & Address -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Shipping Details -->
                <div class="border border-gray-100 p-6 rounded-xl">
                    <h3 class="text-[10px] font-black uppercase tracking-widest mb-4 flex items-center">
                        <span class="mr-2">01</span> Shipping Destination
                    </h3>
                    <p class="text-sm font-bold uppercase tracking-tight">{{ $address->address_line_1 }}</p>
                    <p class="text-xs text-gray-500 uppercase">{{ $address->city }}, {{ $address->postcode }}</p>
                </div>

                <!-- Product List -->
                <div class="border border-gray-100 p-6 rounded-xl">
                    <h3 class="text-[10px] font-black uppercase tracking-widest mb-6 flex items-center">
                        <span class="mr-2">02</span> Order Inventory
                    </h3>
                    
                    <div class="space-y-6">
                        @foreach($cart as $id => $details)
                            <div class="flex justify-between items-center pb-6 border-b border-gray-50 last:border-0 last:pb-0">
                                <div class="flex items-center gap-4">
                                    <!-- Placeholder for Image if available, else Initials -->
                                    <div class="w-16 h-20 bg-gray-50 flex items-center justify-center text-[10px] font-bold text-gray-300 uppercase tracking-tighter italic">
                                        {{ substr($details['name'], 0, 2) }}
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-black uppercase italic tracking-tighter">{{ $details['name'] }}</h4>
                                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">
                                            Size: {{ $details['size'] }} | Qty: {{ $details['quantity'] }}
                                        </p>
                                    </div>
                                </div>
                                <p class="text-sm font-black">£{{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Side: Order Summary & Pay -->
            <div class="lg:col-span-1">
                <div class="bg-gray-50 p-8 sticky top-8">
                    <h3 class="text-[10px] font-black uppercase tracking-widest mb-6 border-b border-gray-200 pb-2">Summary</h3>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-[10px] uppercase font-bold tracking-widest text-gray-500">
                            <span>Subtotal</span>
                            <span>£{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-[10px] uppercase font-bold tracking-widest text-gray-500">
                            <span>Shipping</span>
                            <span class="text-green-600">FREE</span>
                        </div>
                        <div class="flex justify-between items-end pt-4 border-t border-gray-200">
                            <span class="text-[12px] font-black uppercase italic tracking-tighter">Total</span>
                            <span class="text-xl font-black italic tracking-tighter">£{{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <!-- Pass the address_id so the 'complete' method can save it to the order -->
                        <input type="hidden" name="address_id" value="{{ $address->id }}">
                        
                        <button type="submit" class="w-full bg-black text-white py-5 text-[11px] font-black uppercase tracking-[0.2em] hover:bg-gray-800 transition shadow-xl">
                            PLACE ORDER
                        </button>
                    </form>

                    <p class="text-[9px] text-gray-400 uppercase mt-6 text-center leading-relaxed">
                        By clicking above, you confirm this is a simulation. No actual payment will be processed.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>