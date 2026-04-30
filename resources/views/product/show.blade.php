<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            <!-- left:image galary -->
            <div 
                x-data="{
                    activeImage: '{{ asset($product->main_image) }}'
                }"
                class="grid grid-cols-1 md:grid-cols-[90px_1fr] gap-4"
            >

                <!-- thumbnails -->
                <div class="order-2 md:order-1 flex md:flex-col gap-3 overflow-x-auto">

                    <!-- main image thumbnails -->
                    <button 
                        type="button"
                        @click="activeImage = '{{ asset($product->main_image) }}'"
                        class="w-20 h-24 shrink-0 border overflow-hidden rounded-md hover:border-black"
                        :class="activeImage === '{{ asset($product->main_image) }}' ? 'border-black' : 'border-gray-200'"
                    >
                        <img 
                            src="{{ asset($product->main_image) }}"
                            class="w-full h-full object-cover"
                        >
                    </button>

                    @foreach($product->images as $image)
                        {{-- ADD THIS CHECK: Skip if this image is already the main thumbnail --}}
                        @if(asset($image->image_path) === asset($product->main_image))
                            @continue
                        @endif

                        <button 
                            type="button"
                            @click="activeImage = '{{ asset($image->image_path) }}'"
                            class="w-20 h-24 shrink-0 border overflow-hidden rounded-md hover:border-black"
                            :class="activeImage === '{{ asset($image->image_path) }}' ? 'border-black' : 'border-gray-200'"
                        >
                            <img 
                                src="{{ asset($image->image_path) }}"
                                class="w-full h-full object-cover"
                            >
                        </button>
                    @endforeach

                </div>

                <!-- main image display -->
                <div class="order-1 md:order-2 aspect-[3/4] bg-gray-100 overflow-hidden rounded-xl">
                    <img 
                        :src="activeImage"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover"
                    >
                </div>

            </div>

            <!-- right:product info -->
            <div class="flex flex-col justify-start">
                <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">
                    {{ $product->category }}
                </p>

                <h1 class="text-3xl font-black uppercase tracking-tight mb-2">
                    {{ $product->name }}
                </h1>

                <p class="text-sm text-gray-500 mb-4">
                    {{ $product->brand }}
                </p>

                <p class="text-xl font-bold mb-8">
                    £{{ number_format($product->price, 2) }}
                </p>

                <!-- size select -->
                @if($product->sizes)
                <div class="mb-6">
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">Size</p>
                    <div class="flex gap-2 flex-wrap">
                        @foreach($product->sizes as $size)
                            <button 
                                class="border px-4 py-2 text-xs font-bold hover:border-black"
                                onclick="selectSize(this, '{{ $size }}')"
                            >
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- COLOR SELECT -->
                @if($product->colors)
                <div class="mb-8">
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">Colour</p>
                    <div class="flex gap-3">
                        @foreach($product->colors as $color)
                            <div 
                                class="w-6 h-6 rounded-full border cursor-pointer"
                                style="background-color: {{ strtolower($color) }}"
                                onclick="selectColor(this, '{{ $color }}')"
                            ></div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- ADD TO CART -->
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <input type="hidden" name="size" id="selectedSize">
                    <input type="hidden" name="color" id="selectedColor">
                    <button class="w-full bg-black text-white py-4 text-sm font-bold uppercase tracking-widest hover:bg-gray-900 transition">
                        Add to Cart
                    </button>
                </form>

                <div class="mt-10 border-t pt-6">
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectSize(el, size) {
            document.querySelectorAll('[onclick^="selectSize"]').forEach(btn => {
                btn.classList.remove('bg-black','text-white');
            });
            el.classList.add('bg-black','text-white');
            document.getElementById('selectedSize').value = size;
        }

        function selectColor(el, color) {
            document.querySelectorAll('[onclick^="selectColor"]').forEach(btn => {
                btn.classList.remove('ring-2','ring-black');
            });
            el.classList.add('ring-2','ring-black');
            document.getElementById('selectedColor').value = color;
        }
    </script>

</x-app-layout>
