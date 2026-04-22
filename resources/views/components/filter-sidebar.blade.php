<div class="space-y-10">
    <!-- filter by size -->
    <div>
        <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Select Size</h4>
        <div class="grid grid-cols-3 gap-2">
            @foreach(['XS', 'S', 'M', 'L', 'XL', '2XL'] as $size)
                <a href="{{ request()->fullUrlWithQuery(['size' => $size]) }}" 
                   class="border py-2 text-center text-xs font-bold transition {{ request('size') == $size ? 'bg-black text-white border-black' : 'bg-white text-gray-900 hover:border-gray-400' }}">
                    {{ $size }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- filter by color-->
    <div>
        <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4">Colours</h4>
        <div class="space-y-3">
            @foreach(['Black', 'White', 'Navy', 'Grey', 'Beige'] as $color)
                <a href="{{ request()->fullUrlWithQuery(['color' => $color]) }}" 
                   class="flex items-center gap-3 text-xs {{ request('color') == $color ? 'font-black' : 'text-gray-500 hover:text-black' }}">
                    <span class="w-4 h-4 rounded-full border border-gray-200" style="background-color: {{ $color }}"></span>
                    {{ $color }}
                </a>
            @endforeach
        </div>
    </div>

    @if(request()->anyFilled(['category', 'size', 'color', 'sort', 'search']))
        <a href="/" class="block text-center text-[10px] font-bold uppercase text-red-500 underline mt-6">Clear All Filters</a>
    @endif
</div>
