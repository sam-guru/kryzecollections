<x-admin-layout>
    <div class="max-w-4xl mx-auto px-4 py-10">

        <h1 class="text-2xl font-black uppercase mb-8">Add Product</h1>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('admin.products.partials.form', ['product' => null])

            <button class="w-full bg-black text-white py-4 text-xs font-black uppercase tracking-widest">
                Save Product
            </button>
        </form>

    </div>
</x-admin-layout>