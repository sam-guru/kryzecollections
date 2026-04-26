<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-900 leading-tight uppercase italic tracking-tighter">
            {{ __('Your Shopping Bag') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('cart') && count(session('cart')) > 0)

                <div class="flex flex-col lg:flex-row gap-12">

                    <!-- ITEMS -->
                    <div class="flex-1 space-y-6">

                        @foreach(session('cart') as $id => $details)

                            @php
                                $image = $details['image'] ?? null;

                                // Ensure correct path
                                if ($image && !str_starts_with($image, 'storage/')) {
                                    $image = 'storage/' . $image;
                                }
                            @endphp

                            <div class="flex items-center gap-6 border-b pb-6">

                                <!-- IMAGE -->
                                <img 
                                        src="{{ asset($details['image']) }}"
                                        alt="{{ $details['name'] }}"
                                        class="w-24 h-32 object-cover rounded-lg"
                                    >

                                <!-- INFO -->
                                <div class="flex-1">
                                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">
                                        {{ $details['brand'] }}
                                    </p>

                                    <h3 class="font-bold text-lg uppercase italic tracking-tighter">
                                        {{ $details['name'] }}
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        £{{ number_format($details['price'], 2) }} × {{ $details['quantity'] }}
                                    </p>
                                </div>

                                <!-- TOTAL -->
                                <div class="text-right">
                                    <p class="font-black text-lg">
                                        £{{ number_format($details['price'] * $details['quantity'], 2) }}
                                    </p>
                                </div>

                            </div>

                        @endforeach

                    </div>

                    <!-- SUMMARY -->
                    <div class="w-full lg:w-80">

                        <div class="bg-gray-50 p-8 rounded-xl">

                            <h4 class="font-black text-sm uppercase tracking-widest mb-6">
                                Order Summary
                            </h4>

                            @php $total = 0; @endphp

                            @foreach(session('cart') as $details)
                                @php $total += $details['price'] * $details['quantity']; @endphp
                            @endforeach

                            <div class="flex justify-between font-bold text-lg border-t pt-4">
                                <span>Total</span>
                                <span>£{{ number_format($total, 2) }}</span>
                            </div>

                            <a href="/checkout"
                               class="block w-full bg-black text-white text-center py-4 mt-8 text-[11px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
                                Proceed to Checkout
                            </a>

                        </div>

                    </div>

                </div>

            @else

                <!-- EMPTY CART -->
                <div class="text-center py-20 border-2 border-dashed rounded-2xl">
                    <p class="text-gray-400 font-medium italic">
                        Your bag is currently empty.
                    </p>

                    <a href="/"
                       class="mt-6 inline-block bg-black text-white px-8 py-3 text-[10px] font-black uppercase tracking-widest">
                        Start Shopping
                    </a>
                </div>

            @endif

        </div>
    </div>
</x-app-layout>