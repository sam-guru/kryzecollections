<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl p-6 shadow-sm border">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-2">
                Products
            </p>
            <h2 class="text-3xl font-black">
                {{ \App\Models\Product::count() }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-2">
                Categories
            </p>
            <h2 class="text-3xl font-black">
                {{ \App\Models\Product::distinct('category')->count('category') }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-sm border">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-2">
                Gallery Images
            </p>
            <h2 class="text-3xl font-black">
                {{ \App\Models\ProductImage::count() }}
            </h2>
        </div>

    </div>
</x-admin-layout>