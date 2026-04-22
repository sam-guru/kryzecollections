@props(['product'])

<div class="bg-white border border-gray-100 rounded-xl overflow-hidden group shadow-sm hover:shadow-md transition">
    <div class="relative aspect-[3/4]">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
        
        <!-- favorite heart button -->
        <form action="{{ route('favorite.toggle', $product) }}" method="POST" class="absolute top-3 right-3">
            @csrf
            <button type="submit" class="bg-white/90 p-2 rounded-full hover:bg-white shadow-sm transition-transform active:scale-90">
                <svg xmlns="http://w3.org" 
                     fill="{{ $product->isFavoritedBy(auth()->user()) ? 'red' : 'none' }}" 
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                     class="w-5 h-5 {{ $product->isFavoritedBy(auth()->user()) ? 'text-red-500' : 'text-gray-400' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                </svg>
            </button>
        </form>
    </div>

    <div class="p-4">
        <div class="flex justify-between items-start mb-1">
            <h3 class="text-sm font-bold text-gray-900 truncate">{{ $product->name }}</h3>
            <p class="text-sm font-black">${{ number_format($product->price, 2) }}</p>
        </div>
        <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-4">{{ $product->brand }}</p>
        
        <!-- affiliate link -->
        <a href="{{ $product->affiliate_url }}" target="_blank" 
           class="block w-full bg-black text-white text-center py-2.5 text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition">
            Shop Partner
        </a>
    </div>
</div>
