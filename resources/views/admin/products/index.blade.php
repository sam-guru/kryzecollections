<x-admin-layout>    
    <div class="max-w-7xl mx-auto px-4 py-10">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-black uppercase">Admin Products</h1>

            <a href="{{ route('admin.products.create') }}"
               class="bg-black text-white px-5 py-3 text-xs font-bold uppercase">
                Add Product
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 text-green-700 p-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase text-gray-400">
                    <tr>
                        <th class="p-4 text-left">Image</th>
                        <th class="p-4 text-left">Name</th>
                        <th class="p-4 text-left">Category</th>
                        <th class="p-4 text-left">Price</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $product)
                        <tr class="border-t">
                            <td class="p-4">
                                <img src="{{ asset($product->main_image) }}" class="w-14 h-16 object-cover rounded">

                            </td>

                            <td class="p-4 font-bold">
                                {{ $product->name }}
                            </td>

                            <td class="p-4">
                                {{ $product->category }}
                            </td>

                            <td class="p-4">
                                £{{ number_format($product->price, 2) }}
                            </td>

                            <td class="p-4 text-right space-x-3">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="text-blue-600 font-bold text-xs uppercase">
                                    Edit
                                </a>

                                <form action="{{ route('admin.products.destroy', $product) }}"
                                      method="POST"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this product?')"
                                            class="text-red-600 font-bold text-xs uppercase">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>

    </div>
</x-admin-layout>