<x-app-layout>

    @php
        $mainImagePath = $product->main_image;

        if ($mainImagePath && str_starts_with($mainImagePath, 'storage/')) {
            $mainImagePath = str_replace('storage/', '', $mainImagePath);
        }

        $mainImageUrl = $mainImagePath
            ? \Illuminate\Support\Facades\Storage::disk('s3')->url($mainImagePath)
            : asset('images/placeholder.jpg');
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            <!-- LEFT: IMAGE GALLERY -->
            <div 
                x-data="{ activeImage: @js($mainImageUrl) }"
                class="grid grid-cols-1 md:grid-cols-[90px_1fr] gap-4"
            >

                <!-- Thumbnails -->
                <div class="order-2 md:order-1 flex md:flex-col gap-3 overflow-x-auto">

                    <!-- Main Image Thumbnail -->
                    <button 
                        type="button"
                        @click="activeImage = @js($mainImageUrl)"
                        class="w-20 h-24 shrink-0 border overflow-hidden rounded-md hover:border-black"
                        :class="activeImage === @js($mainImageUrl) ? 'border-black' : 'border-gray-200'"
                    >
                        <img 
                            src="{{ $mainImageUrl }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover"
                        >
                    </button>

                    <!-- Extra Images -->
                    @foreach($product->images as $image)
                        @php
                            $galleryPath = $image->image_path;

                            if ($galleryPath && str_starts_with($galleryPath, 'storage/')) {
                                $galleryPath = str_replace('storage/', '', $galleryPath);
                            }

                            $galleryUrl = $galleryPath
                                ? \Illuminate\Support\Facades\Storage::disk('s3')->url($galleryPath)
                                : asset('images/placeholder.jpg');
                        @endphp

                        <button 
                            type="button"
                            @click="activeImage = @js($galleryUrl)"
                            class="w-20 h-24 shrink-0 border overflow-hidden rounded-md hover:border-black"
                            :class="activeImage === @js($galleryUrl) ? 'border-black' : 'border-gray-200'"
                        >
                            <img 
                                src="{{ $galleryUrl }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover"
                            >
                        </button>
                    @endforeach

                </div>

                <!-- Main Display Image -->
                <div class="order-1 md:order-2 aspect-[3/4] bg-gray-100 overflow-hidden rounded-xl">
                    <img 
                        :src="activeImage"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover"
                    >
                </div>

            </div>

            <!-- RIGHT: PRODUCT INFO -->
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

                @if($product->sizes)
                    <div class="mb-6">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">
                            Size
                        </p>

                        <div class="flex gap-2 flex-wrap">
                            @foreach($product->sizes as $size)
                                <button 
                                    type="button"
                                    class="border px-4 py-2 text-xs font-bold hover:border-black"
                                    onclick="selectSize(this, '{{ $size }}')"
                                >
                                    {{ $size }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($product->colors)
                    <div class="mb-8">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-2">
                            Colour
                        </p>

                        <div class="flex gap-3">
                            @foreach($product->colors as $color)
                                <button 
                                    type="button"
                                    class="w-6 h-6 rounded-full border cursor-pointer"
                                    style="background-color: {{ strtolower($color) }}"
                                    onclick="selectColor(this, '{{ $color }}')"
                                ></button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf

                    <input type="hidden" name="size" id="selectedSize">
                    <input type="hidden" name="color" id="selectedColor">

                    <button 
                        type="submit"
                        class="w-full bg-black text-white py-4 text-sm font-bold uppercase tracking-widest hover:bg-gray-900 transition"
                    >
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
                btn.classList.remove('bg-black', 'text-white');
            });

            el.classList.add('bg-black', 'text-white');
            document.getElementById('selectedSize').value = size;
        }

        function selectColor(el, color) {
            document.querySelectorAll('[onclick^="selectColor"]').forEach(btn => {
                btn.classList.remove('ring-2', 'ring-black');
            });

            el.classList.add('ring-2', 'ring-black');
            document.getElementById('selectedColor').value = color;
        }
    </script>

</x-app-layout>