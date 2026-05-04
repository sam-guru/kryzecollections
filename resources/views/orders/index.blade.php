<x-app-layout>
    <div class="py-16 max-w-5xl mx-auto px-4">
        <div class="mb-12">
            <a href="{{ route('dashboard') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition">
                &larr; Back to Dashboard
            </a>
            <h2 class="font-black text-4xl uppercase italic tracking-tighter mt-4">Order Archive</h2>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em]">Full Purchase History</p>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @forelse($orders as $order)
                <div class="bg-white border border-gray-100 p-8 flex flex-col md:flex-row justify-between items-start md:items-center group hover:border-black transition">
                    
                    <div class="mb-4 md:mb-0">
                        <span class="text-[9px] font-black uppercase tracking-widest text-gray-300 group-hover:text-black transition">{{ $order->created_at->format('M d, Y') }}</span>
                        <h3 class="font-black text-xl uppercase italic tracking-tighter">{{ $order->order_number }}</h3>
                        <div class="mt-2 space-y-1">
                            @foreach($order->items as $item)
                                <p class="text-[10px] text-gray-500 uppercase italic">{{ $item->quantity }}x {{ $item->product_name }}</p>
                            @endforeach
                        </div>
                    </div>

                    <div class="text-left md:text-right w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0 border-gray-50">
                        <p class="text-[10px] font-bold uppercase text-gray-400 mb-1">Total Amount</p>
                        <p class="text-2xl font-black italic tracking-tighter">£{{ number_format($order->total_price, 2) }}</p>
                        <span class="inline-block mt-2 text-[8px] px-3 py-1 bg-black text-white font-black uppercase tracking-widest">
                            {{ $order->status }}
                        </span>
                    </div>
                    
                </div>
            @empty
                <div class="py-24 text-center border-2 border-dashed border-gray-100">
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-300">No Orders Found</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>